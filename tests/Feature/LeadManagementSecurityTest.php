<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Project;
use App\Models\User;
use App\Models\Video;
use App\Services\LeadAnalytics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LeadManagementSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function migrateFreshUsing(): array
    {
        return ['--path' => [
            'database/migrations/0001_01_01_000000_create_users_table.php',
            'database/migrations/2026_09_18_000001_create_line_crm_tables.php',
            'database/migrations/2026_11_18_000001_create_content_admin_tables.php',
            'database/migrations/2026_11_18_000002_add_video_aspect_ratio.php',
            'database/migrations/2026_11_18_000003_add_lead_management_and_video_covers.php',
        ]];
    }

    private function admin(): User
    {
        $user = User::factory()->create(['password' => 'admin-password-123']);
        $user->can_manage_content = true;
        $user->save();
        return $user;
    }

    private function lead(array $values = []): Lead
    {
        $lead = new Lead(array_replace(['whatsapp_country' => '+66', 'whatsapp_phone' => '0812345678',
            'phone_normalized' => '+66812345678', 'name' => 'Demo Customer', 'email' => 'demo@example.test',
            'consent' => true, 'source' => 'website', 'status' => 'new', 'locale' => 'en'], $values));
        if (isset($values['created_at'])) $lead->created_at = \Carbon\CarbonImmutable::parse($values['created_at'], 'UTC')->setTimezone(config('app.timezone'));
        $lead->save();
        return $lead;
    }

    private function publicData(array $values = []): array
    {
        return array_replace(['whatsapp_country' => '+66', 'whatsapp_phone' => '081 234 5678',
            'name' => 'Demo inquiry', 'email' => 'inquiry@example.test', 'consent' => '1'], $values);
    }

    private function project(): Project
    {
        return Project::create(['title' => 'Demo Villa', 'category' => 'villa', 'badge' => ['en'=>'2 beds','ru'=>'2 спальни'],
            'price' => ['en'=>'From 10m','ru'=>'От 10m'], 'description' => ['en'=>'Description','ru'=>'Описание'],
            'images' => ['assets/projects/demo.jpg'], 'is_published' => true]);
    }

    public function test_lead_pages_and_export_require_explicit_admin_access(): void
    {
        $lead = $this->lead();
        foreach (['/admin/leads','/admin/leads/dashboard','/admin/leads/export','/admin/leads/'.$lead->id] as $url) {
            $this->get($url)->assertRedirect('/admin/login')->assertDontSee('demo@example.test');
        }
        $staff = User::factory()->create();
        $staff->can_access_line_crm = true;
        $staff->save();
        $this->actingAs($staff)->get('/admin/leads')->assertForbidden();
        $this->get('/admin/leads/export')->assertForbidden();
        $this->patch('/admin/leads/'.$lead->id, ['status'=>'won'])->assertForbidden();
        $this->assertSame('new', $lead->fresh()->status);
    }

    public function test_lead_submission_captures_canonical_project_language_and_campaign(): void
    {
        $project = $this->project();
        $this->post('/ru/lead', $this->publicData(['project_id'=>$project->id, 'project'=>'Spoofed title',
            'source'=>'fake-admin', 'status'=>'won', 'utm_source'=>'facebook', 'utm_medium'=>'paid', 'utm_campaign'=>'phuket']))
            ->assertSessionHasNoErrors()->assertRedirect('/ru/thank-you');
        $lead = Lead::firstOrFail();
        $this->assertSame($project->id, $lead->project_id);
        $this->assertSame('Demo Villa', $lead->project_name);
        $this->assertSame('villa', $lead->project_category);
        $this->assertSame('ru', $lead->locale);
        $this->assertSame('website', $lead->source);
        $this->assertSame('new', $lead->status);
        $this->assertSame('facebook', $lead->utm_source);
        $this->assertSame('phuket', $lead->utm_campaign);
        $this->assertSame('+66812345678', $lead->phone_normalized);
    }

    public function test_drafts_honeypot_and_invalid_phone_cannot_create_a_lead(): void
    {
        $project = $this->project();
        $project->update(['is_published'=>false]);
        $this->postJson('/en/lead', $this->publicData(['project_id'=>$project->id]))->assertUnprocessable()->assertJsonValidationErrors('project_id');
        $this->postJson('/en/lead', $this->publicData(['company_website'=>'https://spam.example']))->assertUnprocessable()->assertJsonValidationErrors('company_website');
        $this->postJson('/en/lead', $this->publicData(['whatsapp_phone'=>'not-a-phone']))->assertUnprocessable()->assertJsonValidationErrors('whatsapp_phone');
        $this->postJson('/en/lead', $this->publicData(['whatsapp_phone'=>['malformed']]))->assertUnprocessable()->assertJsonValidationErrors('whatsapp_phone');
        $this->assertDatabaseCount('leads', 0);
    }

    public function test_repeated_submissions_are_rate_limited_by_phone(): void
    {
        for ($i=0; $i<5; $i++) $this->post('/en/lead', $this->publicData())->assertRedirect();
        $this->post('/en/lead', $this->publicData())->assertStatus(429);
        $this->assertDatabaseCount('leads', 5);
    }

    public function test_public_lead_endpoint_rejects_file_uploads_and_oversized_payloads(): void
    {
        $this->post('/en/lead', [...$this->publicData(), 'attachment'=>UploadedFile::fake()->create('unexpected.pdf',1)])->assertStatus(413);
        $this->withServerVariables(['CONTENT_LENGTH'=>40000])->post('/en/lead',$this->publicData())->assertStatus(413);
        $this->assertDatabaseCount('leads',0);
    }

    public function test_list_detail_and_analytics_render_and_escape_customer_input(): void
    {
        $lead = $this->lead(['name'=>'<script>alert(1)</script>', 'utm_campaign'=>'<svg onload=alert(2)>', 'notes'=>'<img src=x onerror=alert(3)>']);
        $this->actingAs($this->admin());
        foreach (['/admin','/admin/leads','/admin/leads/'.$lead->id,'/admin/leads/dashboard?days=7','/admin/leads/dashboard?days=90'] as $url) {
            $this->get($url)->assertOk()->assertHeader('X-Frame-Options', 'DENY')->assertHeader('X-Content-Type-Options','nosniff')
                ->assertHeader('Cache-Control','no-store, private')->assertDontSee('<script>alert(1)</script>',false)
                ->assertDontSee('<svg onload=alert(2)>',false)->assertDontSee('<img src=x onerror=alert(3)>',false);
        }
        $this->get('/admin/leads/'.$lead->id)->assertSee('&lt;script&gt;',false);
        $this->get('/admin/login')->assertHeader('Content-Security-Policy');
    }

    public function test_filters_use_thailand_dates_and_support_an_end_date_without_a_start(): void
    {
        $inside = $this->lead(['name'=>'Inside range','created_at'=>'2026-11-17 18:00:00']);
        $this->lead(['name'=>'Before range','created_at'=>'2026-11-17 16:59:00']);
        $this->actingAs($this->admin())->get('/admin/leads?from=2026-11-18&to=2026-11-18')->assertOk()->assertSee('Inside range')->assertDontSee('Before range');
        $this->get('/admin/leads?to=2026-11-18')->assertOk();
        $this->get('/admin/leads?q=Inside')->assertOk()->assertSee('Inside range')->assertDontSee('Before range');
        $this->get('/admin/leads?q=%27%20OR%201%3D1%20--')->assertOk()->assertDontSee('Inside range');
    }

    public function test_followup_update_sets_timestamps_without_allowing_public_metadata_changes(): void
    {
        $lead = $this->lead(['project_name'=>'Original project']);
        $this->actingAs($this->admin())->patch('/admin/leads/'.$lead->id, ['status'=>'viewing','sales_owner'=>'Demo Sales',
            'notes'=>'Wants a viewing', 'next_follow_up_at'=>'2026-11-20T10:30', 'project_name'=>'Changed'])->assertSessionHasNoErrors();
        $lead->refresh();
        $this->assertSame('Original project', $lead->project_name);
        $this->assertSame('2026-11-20 03:30', $lead->next_follow_up_at->utc()->format('Y-m-d H:i'));
        $this->assertNotNull($lead->contacted_at);
        $this->assertNull($lead->closed_at);
        $this->patch('/admin/leads/'.$lead->id,['status'=>'won'])->assertSessionHasNoErrors();
        $this->assertNotNull($lead->fresh()->closed_at);
        $this->patch('/admin/leads/'.$lead->id,['status'=>'invalid'])->assertSessionHasErrors('status');
    }

    public function test_dashboard_counts_requests_unique_phones_repeat_inquiries_and_won_status(): void
    {
        $this->lead(['status'=>'won']);
        $this->lead(['status'=>'new']);
        $this->lead(['phone_normalized'=>'+66899999999','status'=>'viewing','next_follow_up_at'=>now()->subHour()]);
        $report = app(LeadAnalytics::class)->report(7);
        $this->assertSame(3, $report['total']);
        $this->assertSame(2, $report['unique']);
        $this->assertSame(1, $report['repeat']);
        $this->assertSame(1, $report['won']);
        $this->assertEquals(33.3, $report['conversion']);
        $this->assertSame(3, array_sum($report['chart']));
        $this->actingAs($this->admin())->get('/admin/leads?due=1')->assertOk()->assertSee('ดู / ติดตาม');
    }

    public function test_export_applies_filters_and_neutralizes_spreadsheet_formulas(): void
    {
        $this->lead(['name'=>'=HYPERLINK("https://example.test")', 'notes'=>"\t=1+1", 'status'=>'qualified']);
        $this->lead(['name'=>'Excluded Customer','status'=>'new']);
        $response = $this->actingAs($this->admin())->get('/admin/leads/export?status=qualified')->assertOk()->assertDownload();
        $csv = $response->streamedContent();
        $this->assertStringStartsWith("\xEF\xBB\xBF", $csv);
        $this->assertStringContainsString("'=HYPERLINK", $csv);
        $this->assertStringContainsString("'\t=1+1", $csv);
        $this->assertStringNotContainsString('Excluded Customer', $csv);
    }

    public function test_admin_account_mutations_require_current_password(): void
    {
        $this->actingAs($this->admin())->post('/admin/users',['name'=>'Other','email'=>'other@example.test',
            'password'=>'a-long-password-123','password_confirmation'=>'a-long-password-123'])->assertSessionHasErrors('current_password');
        $this->assertDatabaseMissing('users',['email'=>'other@example.test']);
        $this->put('/admin/password', ['current_password'=>['malformed'],'password'=>'new-password-123','password_confirmation'=>'new-password-123'])->assertSessionHasErrors('current_password');
    }

    public function test_admin_login_is_rate_limited(): void
    {
        for ($i=0; $i<5; $i++) $this->post('/admin/login',['email'=>'nobody@example.test','password'=>'wrong-password-123'])->assertSessionHasErrors('email');
        $this->post('/admin/login',['email'=>'nobody@example.test','password'=>'wrong-password-123'])->assertStatus(429);
    }

    public function test_csrf_is_required_outside_the_testing_bypass(): void
    {
        $this->app->detectEnvironment(fn ()=>'local');
        $this->post('/en/lead', $this->publicData())->assertStatus(419);
        $this->assertDatabaseCount('leads', 0);
    }

    public function test_automatic_and_uploaded_video_covers_and_upload_validation(): void
    {
        Storage::fake('content_images');
        $video = Video::create(['title'=>['en'=>'Tour','ru'=>'Обзор'],'description'=>['en'=>'','ru'=>''],
            'url'=>'https://youtu.be/abcdefghijk','aspect_ratio'=>'9:16','is_published'=>true]);
        $this->assertSame('https://i.ytimg.com/vi/abcdefghijk/hqdefault.jpg', $video->thumbnailUrl());
        $data=['title'=>$video->title,'description'=>$video->description,'url'=>$video->url,'aspect_ratio'=>'9:16','is_published'=>1,'sort_order'=>0];
        $image = UploadedFile::fake()->createWithContent('poster.png',base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='));
        $this->actingAs($this->admin())->put('/admin/videos/'.$video->id,[...$data,'cover'=>$image])->assertSessionHasNoErrors();
        $video->refresh();
        $this->assertStringStartsWith('uploads/content/video-covers/',$video->cover_path);
        Storage::disk('content_images')->assertExists(substr($video->cover_path,strlen('uploads/content/')));
        $this->put('/admin/videos/'.$video->id,[...$data,'cover'=>UploadedFile::fake()->createWithContent('bad.php','<?php echo 1;')])->assertSessionHasErrors('cover');
        $this->put('/admin/videos/'.$video->id,[...$data,'url'=>['malformed']])->assertSessionHasErrors('url');
        $this->put('/admin/videos/'.$video->id,[...$data,'remove_cover'=>1])->assertSessionHasNoErrors();
        $this->assertNull($video->fresh()->cover_path);
    }
}
