<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['badge' => 'array', 'price' => 'array', 'description' => 'array', 'images' => 'array',
            'is_published' => 'boolean', 'is_new' => 'boolean', 'is_featured' => 'boolean',
            'seo_title' => 'array', 'seo_description' => 'array', 'new_year' => 'integer'];
    }

    public function newLabel(): string
    {
        return 'NEW'.($this->new_year ? ' '.$this->new_year : '');
    }

    public function catalogArea(): string
    {
        $location = trim(preg_replace('/,\s*Phuket.*$/i', '', $this->location ?? ''));
        $source = $location ?: $this->title;
        foreach (['Naiyang' => 'nai[ -]?yang', 'Bang Tao' => 'bang[ -]?tao', 'Karon' => 'karon', 'Kata' => 'kata', 'Rawai' => 'rawai', 'Kamala' => 'kamala', 'Patong' => 'patong'] as $area => $pattern) {
            if (preg_match('/'.$pattern.'/i', $source)) return $area;
        }
        return $location;
    }

    public function catalogPriceMillions(): ?float
    {
        $text = $this->price['en'] ?? $this->price['ru'] ?? '';
        if (!preg_match('/\d[\d.,\s\x{00a0}]*/u', $text, $match)) return null;
        $number = preg_replace('/[\s\x{00a0}]/u', '', $match[0]);
        $millions = preg_match('/(?:\d|\s)(?:m\b|million|млн)/iu', $text);
        if (str_contains($number, ',') && str_contains($number, '.')) {
            $number = strrpos($number, ',') > strrpos($number, '.') ? str_replace(',', '.', str_replace('.', '', $number)) : str_replace(',', '', $number);
        } elseif (substr_count($number, ',') > 1 || (!$millions && preg_match('/^\d{1,3},\d{3}$/', $number))) {
            $number = str_replace(',', '', $number);
        } elseif (substr_count($number, '.') > 1) {
            $number = str_replace('.', '', $number);
        } else {
            $number = str_replace(',', '.', $number);
        }
        if (!is_numeric($number)) return null;
        if ($millions) return (float) $number;
        return preg_match('/THB|฿|БАТ/iu', $text) ? (float) $number / 1000000 : null;
    }

    public function localized(string $field): string
    {
        $value = $this->getAttribute($field) ?? [];
        return $value[app()->getLocale()] ?? $value['en'] ?? '';
    }

    public function imageUrls(): array
    {
        return array_map(fn ($path) => asset($path), $this->imagePaths());
    }

    public function imagePaths(): array
    {
        return array_map(function ($path) {
            if (str_starts_with($path, 'assets/projects/')) {
                $optimized = preg_replace('/\.(jpe?g|png|webp)$/i', '.webp', str_replace('assets/projects/', 'assets/projects-optimized/', $path));
                if (is_file(public_path($optimized))) {
                    return $optimized;
                }
            }
            return $path;
        }, $this->images ?? []);
    }
}
