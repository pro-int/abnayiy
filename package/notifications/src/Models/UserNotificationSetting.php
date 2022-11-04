<?php

namespace Gtech\AbnayiyNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    use HasFactory;
    protected $primaryKey = "user_id";
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'channels'
    ];

    protected $casts = [
        'channels' => 'array'
    ];
}
