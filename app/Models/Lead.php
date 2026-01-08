<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'whatsapp_country','whatsapp_phone','email','name','consent','source','status'
    ];

}
