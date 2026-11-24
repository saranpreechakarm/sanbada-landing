<?php

namespace Tests\Feature;

use Tests\TestCase;

class HeroVideoDeliveryTest extends TestCase
{
    public function test_video_supports_partial_downloads_for_playback_and_seeking(): void
    {
        $response = $this->get('/media/sanbada/480p.mp4', ['Range' => 'bytes=0-1023']);
        $response->assertStatus(206)->assertHeader('Content-Type', 'video/mp4')
            ->assertHeader('Accept-Ranges', 'bytes')->assertHeader('Content-Length', '1024');
        $this->assertStringStartsWith('bytes 0-1023/', $response->headers->get('Content-Range'));
    }

    public function test_video_route_rejects_unknown_files_and_invalid_byte_ranges(): void
    {
        $this->get('/media/sanbada/1080p.mp4')->assertNotFound();
        $this->get('/media/sanbada/not-a-video.mp4')->assertNotFound();
        $this->get('/media/sanbada/480p.mp4', ['Range' => 'bytes=999999999-1000000000'])->assertStatus(416);
    }

    public function test_open_ended_video_requests_are_limited_to_small_chunks(): void
    {
        $response = $this->get('/media/sanbada/480p.mp4', ['Range' => 'bytes=0-']);
        $response->assertStatus(206)->assertHeader('Content-Length', '1048576');
        $this->assertStringStartsWith('bytes 0-1048575/', $response->headers->get('Content-Range'));
    }
}
