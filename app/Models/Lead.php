<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public const STATUSES = [
        'new' => 'ใหม่', 'contacted' => 'ติดต่อแล้ว', 'qualified' => 'มีความสนใจ',
        'viewing' => 'นัดชมโครงการ', 'won' => 'ปิดการขาย', 'lost' => 'ไม่ดำเนินการต่อ',
    ];

    protected $fillable = [
        'whatsapp_country','whatsapp_phone','email','name','consent','source','status',
        'project_id','project_name','project_category','locale','phone_normalized',
        'utm_source','utm_medium','utm_campaign','utm_content','utm_term',
        'sales_owner','notes','next_follow_up_at','contacted_at','closed_at',
        'purpose','budget_range','preferred_area',
    ];

    protected function casts(): array
    {
        return ['consent' => 'boolean', 'next_follow_up_at' => 'datetime', 'contacted_at' => 'datetime', 'closed_at' => 'datetime'];
    }

    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }

    public static function normalizePhone(?string $country, string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);
        $prefix = preg_replace('/[^0-9]/', '', $country ?? '');
        if (str_starts_with(trim($phone), '+') || ($prefix !== '' && str_starts_with($digits, $prefix) && strlen($digits) >= 10)) {
            return '+'.$digits;
        }
        return '+'.$prefix.ltrim($digits, '0');
    }

    public function whatsappUrl(): ?string
    {
        $digits = preg_replace('/[^0-9]/', '', $this->phone_normalized ?? self::normalizePhone($this->whatsapp_country, $this->whatsapp_phone));
        return strlen($digits) >= 6 ? 'https://wa.me/'.$digits : null;
    }
}
