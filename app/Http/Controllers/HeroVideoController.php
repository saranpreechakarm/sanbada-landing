<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HeroVideoController extends Controller
{
    public function __invoke(Request $request, string $quality)
    {
        abort_unless(in_array($quality, ['480p', '720p'], true), 404);
        $path = public_path('media/sanbada/sanbada-ru-'.$quality.'.mp4');
        abort_unless(is_file($path), 404);

        // Bound each media request so the single-worker local PHP server can also
        // deliver the page, photos and forms while the film buffers.
        $size = filesize($path);
        if (preg_match('/^bytes=(\d+)-(\d*)$/i', $request->headers->get('Range', ''), $range)) {
            $start = (int) $range[1];
            if ($start >= $size) {
                return response('', 416, ['Content-Range' => 'bytes */'.$size, 'Accept-Ranges' => 'bytes']);
            }
            $end = $range[2] === '' ? $size - 1 : (int) $range[2];
            $end = min($end, $size - 1, $start + 1048575);
            $request->headers->set('Range', 'bytes='.$start.'-'.$end);
        }

        return response()->file($path, [
            'Content-Type' => 'video/mp4',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
