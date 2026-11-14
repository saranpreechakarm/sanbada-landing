<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineCustomer extends Model
{
    public const STATUSES = [
        'new' => 'รอคัดกรอง', 'searching' => 'กำลังหาทรัพย์',
        'sent' => 'ส่งทรัพย์แล้ว', 'viewing' => 'นัดชม',
        'negotiating' => 'เจรจา', 'closed' => 'ปิดงาน', 'paused' => 'พักการค้นหา',
    ];

    protected $fillable = ['nickname', 'phone', 'sales_owner', 'status'];

    protected function casts(): array
    {
        return ['first_contact_at' => 'datetime', 'last_contact_at' => 'datetime'];
    }

    public function getCustomerCodeAttribute(): string
    {
        return 'CUS-'.str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }
}
