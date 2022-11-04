<?php

namespace Gtech\AbnayiyNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationChannel extends Model
{
    use HasFactory;

    protected $casts = [
        'config' => 'array'
    ];

    public static function channels($array = true)
    {
        return  $array ? NotificationChannel::pluck('channel_name', 'id') : NotificationChannel::select('channel_name', 'id')->get();
    }
}
