<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'name', 'company', 'email', 'phone', 'service', 'message', 'locale', 'consented_at',
    ];

    protected function casts(): array
    {
        return ['consented_at' => 'datetime', 'notification_sent_at' => 'datetime'];
    }
}
