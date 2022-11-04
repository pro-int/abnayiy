<?php

namespace Gtech\AbnayiyNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSection extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'content_name',
        'sms_content',
        'email_content',
        'telegram_content',
        'whatsapp_content',
        'content_vars',
        'event_id'
    ];

    public static function sections($array = true)
    {
        return  $array ?  NotificationSection::pluck('section_name', 'id')->toArray() :  NotificationEvent::pluck('section_name', 'id')->get();
    }
}
