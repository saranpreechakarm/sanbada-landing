<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public const ASPECT_RATIOS = [
        '16:9' => 'แนวนอน 16:9 — วิดีโอทั่วไป',
        '9:16' => 'แนวตั้ง 9:16 — Shorts / Reels',
        '1:1' => 'จัตุรัส 1:1',
        '4:5' => 'แนวตั้ง 4:5',
    ];

    protected $guarded = ['id'];

    public function formatClass(): string
    {
        return match ($this->aspect_ratio) {
            '9:16' => 'portrait', '1:1' => 'square', '4:5' => 'tall', default => 'landscape',
        };
    }

    public function thumbnailUrl(): ?string
    {
        if ($this->cover_path && str_starts_with($this->cover_path, 'uploads/content/')) return asset($this->cover_path);
        $embed = self::embedUrl($this->url);
        if ($embed && preg_match('~/embed/([A-Za-z0-9_-]{11})$~', $embed, $match)) {
            return 'https://i.ytimg.com/vi/'.$match[1].'/hqdefault.jpg';
        }
        return null;
    }

    protected function casts(): array
    {
        return ['title' => 'array', 'description' => 'array', 'is_published' => 'boolean'];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function localized(string $field): string
    {
        $value = $this->getAttribute($field) ?? [];
        return $value[app()->getLocale()] ?? $value['en'] ?? '';
    }

    public static function embedUrl(string $url): ?string
    {
        $parts = parse_url($url);
        if (!$parts || ($parts['scheme'] ?? '') !== 'https' || isset($parts['user']) || isset($parts['pass']) || isset($parts['port'])) {
            return null;
        }
        $host = strtolower($parts['host'] ?? '');
        $path = $parts['path'] ?? '';
        $id = null;
        if ($host === 'youtu.be') {
            $id = trim($path, '/');
        } elseif (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com'], true)) {
            parse_str($parts['query'] ?? '', $query);
            if ($path === '/watch') {
                $id = $query['v'] ?? null;
            } elseif (preg_match('~^/(?:embed|shorts)/([A-Za-z0-9_-]{11})/?$~', $path, $match)) {
                $id = $match[1];
            }
        } elseif (in_array($host, ['vimeo.com', 'www.vimeo.com', 'player.vimeo.com'], true)
            && preg_match('~^/(?:video/)?([0-9]+)(?:/([a-f0-9]+))?/?$~', $path, $match)) {
            parse_str($parts['query'] ?? '', $query);
            $hash = $match[2] ?? ($query['h'] ?? null);
            return 'https://player.vimeo.com/video/'.$match[1]
                .(is_string($hash) && preg_match('/^[a-f0-9]+$/', $hash) ? '?h='.$hash : '');
        }
        return is_string($id) && preg_match('/^[A-Za-z0-9_-]{11}$/', $id)
            ? 'https://www.youtube-nocookie.com/embed/'.$id : null;
    }
}
