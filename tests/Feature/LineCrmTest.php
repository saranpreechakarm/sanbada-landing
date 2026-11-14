<?php

namespace Tests\Feature;

use App\Models\LineCustomer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LineCrmTest extends TestCase
{
    use RefreshDatabase;

    protected function migrateFreshUsing(): array
    {
        // The legacy leads migration executes schema changes at include time.
        // Exercise only the existing users schema and this feature's migration.
        return ['--path' => [
            'database/migrations/0001_01_01_000000_create_users_table.php',
            'database/migrations/2026_09_18_000001_create_line_crm_tables.php',
        ]];
    }

    protected function setUp(): void
    {
        parent::setUp();
        config(['line_crm.channel_secret' => 'test-secret', 'line_crm.access_token' => 'test-token',
            'app.key' => 'base64:'.base64_encode(str_repeat('a', 32))]);
        Http::preventStrayRequests();
        Http::fake(['api.line.me/*' => Http::response(['displayName' => 'คุณอ้อม'])]);
    }

    private function event(string $id = 'event-1', int $timestamp = 1789704000000): array
    {
        return ['type' => 'message', 'webhookEventId' => $id, 'timestamp' => $timestamp,
            'source' => ['type' => 'user', 'userId' => 'U'.str_repeat('a', 32)],
            'message' => ['type' => 'text', 'text' => 'หาคอนโด']];
    }

    private function sendEvents(array $events)
    {
        $raw = json_encode(['events' => $events]);
        return $this->call('POST', '/api/line/webhook', [], [], [], [
            'CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json',
            'HTTP_X_LINE_SIGNATURE' => base64_encode(hash_hmac('sha256', $raw, 'test-secret', true)),
        ], $raw);
    }

    public function test_signature_and_empty_line_verification(): void
    {
        $this->postJson('/api/line/webhook', ['events' => [$this->event()]])->assertUnauthorized();
        $this->assertDatabaseCount('line_customers', 0);
        $this->sendEvents([])->assertOk()->assertJson(['ok' => true]);
    }

    public function test_duplicates_and_out_of_order_events_preserve_staff_fields(): void
    {
        $this->sendEvents([$this->event()])->assertOk();
        $customer = LineCustomer::firstOrFail();
        $customer->update(['nickname' => 'อ้อม คอนโด', 'sales_owner' => 'แนน', 'status' => 'viewing']);
        $this->sendEvents([$this->event()])->assertOk();
        $this->sendEvents([$this->event('later', 1789790400000)])->assertOk();
        $this->sendEvents([$this->event('older', 1789617600000)])->assertOk();
        $this->assertDatabaseCount('line_customers', 1);
        $this->assertDatabaseCount('line_webhook_events', 3);
        $customer->refresh();
        $this->assertSame('คุณอ้อม', $customer->display_name);
        $this->assertSame('แนน', $customer->sales_owner);
        $this->assertSame('viewing', $customer->status);
        $this->assertSame(1789617600, $customer->first_contact_at->timestamp);
        $this->assertSame(1789790400, $customer->last_contact_at->timestamp);
    }

    public function test_profile_failure_does_not_lose_customer_and_later_message_fills_name(): void
    {
        Http::swap(new \Illuminate\Http\Client\Factory);
        Http::preventStrayRequests();
        Http::fake(['api.line.me/*' => Http::sequence()->push([], 503)->push(['displayName' => 'คุณอ้อม'])]);
        $this->sendEvents([$this->event()])->assertOk();
        $this->assertDatabaseHas('line_customers', ['display_name' => null]);
        $this->sendEvents([$this->event('next')])->assertOk();
        $this->assertDatabaseHas('line_customers', ['display_name' => 'คุณอ้อม']);
    }

    public function test_group_members_are_not_imported_as_individual_customers(): void
    {
        $event = $this->event();
        $event['source']['type'] = 'group';
        $this->sendEvents([$event])->assertOk();
        $this->assertDatabaseCount('line_customers', 0);
    }

    public function test_crm_requires_explicit_staff_access(): void
    {
        $this->get('/crm')->assertRedirect('/crm/login');
        $user = User::factory()->create();
        $this->actingAs($user)->get('/crm')->assertForbidden();
        $user->can_access_line_crm = true;
        $user->save();
        $this->sendEvents([$this->event()])->assertOk();
        $this->actingAs($user)->get('/crm')->assertOk()->assertSee('คุณอ้อม');
        $this->patch('/crm/customers/'.LineCustomer::first()->id, ['status' => 'invalid'])->assertSessionHasErrors('status');
    }

    public function test_login_accepts_only_crm_staff(): void
    {
        $user = User::factory()->create(['password' => bcrypt('test-password')]);
        $this->post('/crm/login', ['email' => $user->email, 'password' => 'test-password'])->assertSessionHasErrors();
        $this->assertGuest();
        $user->can_access_line_crm = true;
        $user->save();
        $this->post('/crm/login', ['email' => $user->email, 'password' => 'test-password'])->assertRedirect('/crm');
        $this->assertAuthenticatedAs($user);
    }

    public function test_setup_requires_valid_unexpired_link_and_closes_after_first_account(): void
    {
        $this->get('/crm/setup')->assertForbidden();
        $expired = \Illuminate\Support\Facades\URL::temporarySignedRoute('crm.setup', now()->subMinute());
        $this->get($expired)->assertForbidden();
        $link = \Illuminate\Support\Facades\URL::temporarySignedRoute('crm.setup', now()->addMinutes(30));
        $this->get($link)->assertOk();
        $this->post($link, ['name' => 'Owner', 'email' => 'owner@example.test',
            'password' => 'test-password-123', 'password_confirmation' => 'test-password-123'])->assertRedirect('/crm/login');
        $this->assertDatabaseHas('users', ['email' => 'owner@example.test', 'can_access_line_crm' => 1]);
        $this->get($link)->assertForbidden();
        $this->travel(1)->minutes();
        $this->post($link, ['name' => 'Other', 'email' => 'other@example.test',
            'password' => 'test-password-123', 'password_confirmation' => 'test-password-123'])->assertForbidden();
    }
}
