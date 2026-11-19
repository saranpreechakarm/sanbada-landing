<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ContentAdminTest extends TestCase
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

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.key' => 'base64:'.base64_encode(str_repeat('a', 32))]);
        Storage::fake('content_images');
        Storage::fake('content_documents');
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->can_manage_content = true;
        $user->save();
        return $user;
    }

    private function project(array $overrides = []): Project
    {
        return Project::create(array_replace($this->projectData(), ['images' => ['assets/projects/test.jpg']], $overrides));
    }

    private function projectData(array $overrides = []): array
    {
        return array_replace([
            'title' => 'Test residence', 'category' => 'condo', 'location' => 'Bang Tao',
            'badge' => ['en' => '2 bedrooms', 'ru' => '2 спальни'], 'price' => ['en' => 'From ฿5m', 'ru' => 'От ฿5m'],
            'description' => ['en' => 'English description', 'ru' => 'Русское описание'],
            'sort_order' => 10, 'is_published' => 0, 'is_new' => 1, 'is_featured' => 0,
        ], $overrides);
    }

    private function image(): UploadedFile
    {
        return UploadedFile::fake()->createWithContent('cover.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='));
    }

    public function test_all_admin_mutations_require_explicit_content_access(): void
    {
        $project = $this->project();
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->post('/admin/projects', $this->projectData())->assertRedirect('/admin/login');
        $user = User::factory()->create();
        $user->can_access_line_crm = true;
        $user->save();
        $this->actingAs($user)->get('/admin')->assertForbidden();
        $this->put('/admin/projects/'.$project->id, $this->projectData())->assertForbidden();
        $this->delete('/admin/projects/'.$project->id)->assertForbidden();
        $this->get('/admin/users')->assertForbidden();
    }

    public function test_login_only_accepts_content_admins_and_logout_ends_session(): void
    {
        $user = User::factory()->create(['password' => bcrypt('a-long-password-123')]);
        $this->post('/admin/login', ['email' => $user->email, 'password' => 'a-long-password-123'])->assertSessionHasErrors('email');
        $this->assertGuest();
        $user->can_manage_content = true;
        $user->save();
        $this->post('/admin/login', ['email' => $user->email, 'password' => 'a-long-password-123'])->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
        $this->post('/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    public function test_setup_is_signed_expires_and_closes_after_first_account(): void
    {
        $this->get('/admin/setup')->assertForbidden();
        $this->get(URL::temporarySignedRoute('admin.setup', now()->subMinute()))->assertForbidden();
        $url = URL::temporarySignedRoute('admin.setup', now()->addMinutes(30));
        $this->get($url)->assertOk();
        $this->post($url, ['name' => 'Owner', 'email' => 'owner@example.test', 'password' => 'a-long-password-123',
            'password_confirmation' => 'a-long-password-123'])->assertRedirect('/admin/login');
        $this->assertDatabaseHas('users', ['email' => 'owner@example.test', 'can_manage_content' => 1]);
        $this->get($url)->assertForbidden();
        $this->travel(61)->seconds();
        $this->post($url, [])->assertForbidden();
    }

    public function test_admin_pages_render_forms_and_existing_content(): void
    {
        $project = $this->project();
        $video = Video::create($this->videoData());
        $this->actingAs($this->admin());
        foreach (['/admin', '/admin/projects', '/admin/projects/create', '/admin/projects/'.$project->id.'/edit',
            '/admin/videos', '/admin/videos/create', '/admin/videos/'.$video->id.'/edit', '/admin/users', '/admin/guide'] as $path) {
            $this->get($path)->assertOk()->assertHeader('Cache-Control', 'no-store, private');
        }
    }

    public function test_projects_can_be_created_with_bilingual_copy_images_and_private_pdf(): void
    {
        $this->actingAs($this->admin());
        $data = $this->projectData(['is_published' => 1]);
        $data['new_images'] = [$this->image()];
        $data['brochure'] = UploadedFile::fake()->createWithContent('brochure.pdf', "%PDF-1.4\nTest brochure");
        $this->post('/admin/projects', $data)->assertSessionHasNoErrors()->assertRedirect();
        $project = Project::firstOrFail();
        $this->assertTrue($project->is_published);
        $this->assertTrue($project->is_new);
        $this->assertSame('Русское описание', $project->description['ru']);
        Storage::disk('content_images')->assertExists(substr($project->images[0], strlen('uploads/content/')));
        Storage::disk('content_documents')->assertExists(substr($project->pdf_path, strlen('content/')));
        $this->get('/en/download-pdf?'.http_build_query(['file' => $project->pdf_path]))->assertOk()->assertDownload();
        $project->update(['is_published' => false]);
        $this->get('/en/download-pdf?'.http_build_query(['file' => $project->pdf_path]))->assertNotFound();
    }

    public function test_project_validation_prevents_invalid_categories_missing_photos_and_executable_uploads(): void
    {
        $this->actingAs($this->admin());
        $this->post('/admin/projects', $this->projectData(['category' => 'other']))->assertSessionHasErrors('category');
        $this->post('/admin/projects', $this->projectData(['is_published' => 1]))->assertSessionHasErrors('new_images');
        $this->post('/admin/projects', $this->projectData(['new_images' => [UploadedFile::fake()->createWithContent('shell.php', '<?php echo 123;')]]))->assertSessionHasErrors('new_images.0');
        $this->post('/admin/projects', $this->projectData(['description' => ['en' => 'Only English']]))->assertSessionHasErrors('description.ru');
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_edits_preserve_reorder_remove_and_append_images(): void
    {
        $project = $this->project(['images' => ['assets/projects/a.jpg', 'assets/projects/b.jpg', 'assets/projects/c.jpg']]);
        $this->actingAs($this->admin())->put('/admin/projects/'.$project->id, $this->projectData([
            'category' => 'villa', 'image_order' => [0 => 20, 1 => 10, 2 => 0], 'remove_images' => [1],
            'new_images' => [$this->image()],
        ]))->assertSessionHasNoErrors()->assertRedirect();
        $project->refresh();
        $this->assertSame('villa', $project->category);
        $this->assertSame(['assets/projects/c.jpg', 'assets/projects/a.jpg'], array_slice($project->images, 0, 2));
        $this->assertCount(3, $project->images);
    }

    public function test_gallery_order_can_mix_new_images_and_existing_images_and_choose_a_new_cover(): void
    {
        $project = $this->project(['images' => ['assets/projects/a.jpg', 'assets/projects/b.jpg', 'assets/projects/c.jpg']]);
        $this->actingAs($this->admin())->put('/admin/projects/'.$project->id, $this->projectData([
            'new_images' => [$this->image(), $this->image()], 'remove_images' => [1],
            'gallery_order' => ['new:1', 'old:2', 'new:0', 'old:0'],
        ]))->assertSessionHasNoErrors();
        $images = $project->fresh()->images;
        $this->assertCount(4, $images);
        $this->assertStringStartsWith('uploads/content/images/', $images[0]);
        $this->assertSame('assets/projects/c.jpg', $images[1]);
        $this->assertSame('assets/projects/a.jpg', $images[3]);
        $this->assertNotSame($images[0], $images[2]);
        $this->get('/admin/projects/'.$project->id.'/edit')->assertOk()->assertSee('data-gallery-items', false)->assertSee('ตั้งเป็นปก');
    }

    public function test_gallery_rejects_duplicate_missing_or_unrecognized_image_tokens(): void
    {
        $project = $this->project(['images' => ['assets/projects/a.jpg', 'assets/projects/b.jpg']]);
        $this->actingAs($this->admin());
        foreach ([['old:0', 'old:0'], ['old:0'], ['old:0', 'old:99'], ['old:0', 'new:0'], ['old:0', '../secret']] as $order) {
            $this->put('/admin/projects/'.$project->id, $this->projectData(['gallery_order' => $order]))->assertSessionHasErrors();
            $this->assertSame(['assets/projects/a.jpg', 'assets/projects/b.jpg'], $project->fresh()->images);
        }
    }

    public function test_public_pages_split_categories_show_new_and_featured_and_hide_drafts(): void
    {
        $condo = $this->project(['title' => 'Featured condo', 'is_published' => 1, 'is_featured' => 1]);
        $villa = $this->project(['title' => 'Private villa', 'category' => 'villa', 'is_published' => 1]);
        $this->project(['title' => 'Secret draft']);
        Video::create($this->videoData(['is_published' => 1]));
        Video::create($this->videoData(['title' => ['en' => 'Secret video', 'ru' => 'Secret video']]));
        $this->get('/en')->assertOk()->assertSee('Condominiums')->assertSee('Villas')->assertSee('New Projects')
            ->assertSee('Recommended')->assertSee('Featured condo')->assertSee('Private villa')->assertDontSee('Secret draft')
            ->assertSee('Discover through video')->assertDontSee('Secret video')->assertSee('open-video', false)->assertSee('i.ytimg.com');
        $this->get('/ru')->assertOk()->assertSee('Новые проекты')->assertSee('Русское описание')->assertSee('Кондоминиумы');
    }

    public function test_public_page_hides_empty_new_and_video_sections(): void
    {
        $this->get('/en')->assertOk()->assertDontSee('id="new-projects"', false)->assertDontSee('id="videos"', false);
    }

    public function test_catalogue_text_is_escaped_including_alpine_expressions(): void
    {
        $this->project(['title' => '\"><script>alert(1)</script>', 'is_published' => 1]);
        $this->get('/en')->assertOk()->assertDontSee('<script>alert(1)</script>', false)->assertSee('&lt;script&gt;', false);
    }

    public function test_trash_hides_project_and_restore_keeps_it_draft(): void
    {
        $project = $this->project(['is_published' => 1]);
        $this->actingAs($this->admin())->delete('/admin/projects/'.$project->id)->assertRedirect('/admin/projects');
        $this->assertSoftDeleted('projects', ['id' => $project->id]);
        $this->get('/en')->assertDontSee('Test residence');
        $this->get('/admin/projects?status=trash')->assertOk()->assertSee('กู้คืนเป็นฉบับร่าง');
        $this->post('/admin/projects/'.$project->id.'/restore')->assertRedirect('/admin/projects/'.$project->id.'/edit');
        $this->assertFalse($project->fresh()->is_published);
        $this->assertFalse($project->fresh()->trashed());
    }

    private function videoData(array $overrides = []): array
    {
        return array_replace(['title' => ['en' => 'Project tour', 'ru' => 'Обзор проекта'],
            'description' => ['en' => 'A tour', 'ru' => 'Экскурсия'], 'url' => 'https://youtu.be/abcdefghijk',
            'is_published' => 0, 'sort_order' => 0, 'aspect_ratio' => '16:9'], $overrides);
    }

    public function test_video_crud_and_only_supported_provider_urls_are_accepted(): void
    {
        $this->actingAs($this->admin())->post('/admin/videos', $this->videoData())->assertSessionHasNoErrors()->assertRedirect();
        $video = Video::firstOrFail();
        $this->put('/admin/videos/'.$video->id, $this->videoData(['url' => 'https://vimeo.com/123456789', 'is_published' => 1]))->assertSessionHasNoErrors();
        $this->assertSame('https://player.vimeo.com/video/123456789', Video::embedUrl($video->fresh()->url));
        foreach (['https://youtube.com.evil.test/watch?v=abcdefghijk', 'javascript:alert(1)', 'https://youtu.be/short', 'https://www.youtube.com/playlist?list=123'] as $url) {
            $this->post('/admin/videos', $this->videoData(['url' => $url]))->assertSessionHasErrors('url');
        }
        $this->delete('/admin/videos/'.$video->id)->assertRedirect('/admin/videos');
        $this->assertDatabaseCount('videos', 0);
    }

    public function test_video_formats_persist_and_control_public_markup(): void
    {
        $this->actingAs($this->admin());
        foreach (['16:9' => 'landscape', '9:16' => 'portrait', '1:1' => 'square', '4:5' => 'tall'] as $ratio => $class) {
            $this->post('/admin/videos', $this->videoData(['aspect_ratio' => $ratio, 'is_published' => 1]))->assertSessionHasNoErrors();
            $video = Video::latest('id')->firstOrFail();
            $this->assertSame($ratio, $video->aspect_ratio);
            $this->assertSame($class, $video->formatClass());
            $this->get('/en')->assertOk()->assertSee('video-format-'.$class, false)->assertSee('data-aspect-ratio="'.$ratio.'"', false);
        }
        $this->post('/admin/videos', $this->videoData(['aspect_ratio' => '100:0']))->assertSessionHasErrors('aspect_ratio');
    }

    public function test_aspect_ratio_migration_preserves_videos_and_detects_existing_youtube_shorts(): void
    {
        $short = Video::create($this->videoData(['url' => 'https://www.youtube.com/shorts/abcdefghijk']));
        $normal = Video::create($this->videoData());
        $migration = require database_path('migrations/2026_11_18_000002_add_video_aspect_ratio.php');
        $migration->down();
        $migration->up();
        $this->assertSame('9:16', $short->fresh()->aspect_ratio);
        $this->assertSame('16:9', $normal->fresh()->aspect_ratio);
        $this->assertSame($short->title, $short->fresh()->title);
        $this->assertDatabaseCount('videos', 2);
    }

    public function test_brochure_endpoint_rejects_unregistered_and_traversal_paths(): void
    {
        foreach (['assets/projects/pdf/../../../.env', 'content/brochures/../../.env', 'https://evil.test/a.pdf', 'file[]=foo'] as $file) {
            $query = $file === 'file[]=foo' ? $file : http_build_query(['file' => $file]);
            $this->get('/en/download-pdf?'.$query)->assertNotFound();
        }
    }

    public function test_lead_form_returns_the_registered_brochure_after_successful_submission(): void
    {
        $project = $this->project(['is_published' => true, 'pdf_path' => 'content/brochures/test.pdf']);
        $this->post('/en/lead', ['whatsapp_country' => '+66', 'whatsapp_phone' => '081 234 5678', 'consent' => '1',
            'project' => $project->title, 'pdf' => $project->pdf_path])->assertSessionHasNoErrors()
            ->assertRedirectToRoute('thankyou', ['locale' => 'en', 'file' => $project->pdf_path, 'project' => $project->title]);
        $this->assertDatabaseHas('leads', ['whatsapp_phone' => '0812345678']);
        $this->post('/en/lead', ['whatsapp_country' => '+66', 'whatsapp_phone' => '0812345678', 'consent' => '1',
            'pdf' => 'content/brochures/unregistered.pdf'])->assertRedirectToRoute('thankyou', ['locale' => 'en']);
    }

    public function test_handover_can_create_revoke_and_reset_another_admin_without_revoking_self(): void
    {
        $owner = $this->admin();
        $owner->update(['password' => 'owner-password-123']);
        $this->actingAs($owner)->post('/admin/users', ['name' => 'Successor', 'email' => 'next@example.test',
            'password' => 'a-long-password-123', 'password_confirmation' => 'a-long-password-123', 'current_password' => 'owner-password-123'])->assertSessionHasNoErrors();
        $next = User::where('email', 'next@example.test')->firstOrFail();
        $this->assertTrue($next->can_manage_content);
        $this->patch('/admin/users/'.$owner->id, ['action' => 'revoke', 'current_password' => 'owner-password-123'])->assertStatus(422);
        $this->patch('/admin/users/'.$next->id, ['action' => 'reset', 'current_password' => 'owner-password-123', 'password' => 'another-password-123',
            'password_confirmation' => 'another-password-123'])->assertSessionHasNoErrors();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('another-password-123', $next->fresh()->password));
        $this->patch('/admin/users/'.$next->id, ['action' => 'revoke', 'current_password' => 'owner-password-123'])->assertSessionHasNoErrors();
        $this->assertFalse($next->fresh()->can_manage_content);
        $this->flushSession();
        $this->actingAs($next->fresh())->get('/admin')->assertForbidden();
    }

    public function test_password_change_requires_current_password(): void
    {
        $this->actingAs($this->admin())->put('/admin/password', ['current_password' => 'wrong',
            'password' => 'new-long-password-123', 'password_confirmation' => 'new-long-password-123'])->assertSessionHasErrors('current_password');
    }

    public function test_reset_password_invalidates_old_admin_session(): void
    {
        $user = $this->admin();
        $this->actingAs($user)->withSession(['password_hash_web' => $user->password])->get('/admin')->assertOk();
        $user->update(['password' => 'changed-password-123']);
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    public function test_import_is_idempotent_and_does_not_overwrite_edits_or_restore_deleted_projects(): void
    {
        $this->artisan('content:install')->assertSuccessful();
        $count = Project::count();
        $this->assertGreaterThan(10, $count);
        $project = Project::firstOrFail();
        $this->assertNotEmpty($project->description['en']);
        $this->assertNotEmpty($project->description['ru']);
        $project->update(['title' => 'Edited by staff']);
        $project->delete();
        $this->artisan('content:install')->assertSuccessful();
        $this->assertSame($count, Project::withTrashed()->count());
        $this->assertSame('Edited by staff', $project->fresh()->title);
        $this->assertTrue($project->fresh()->trashed());
        $this->assertSame('villa', Project::where('title', 'VILLA KIRARA Bang-Tao')->firstOrFail()->category);
    }
}
