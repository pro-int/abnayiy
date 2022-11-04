<?php

namespace Gtech\AbnayiyNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_name',
        'sms_content',
        'email_content',
        'telegram_content',
        'whatsapp_content',
        'content_vars',
        'event_id'
    ];

    public $timestamps = false;

    protected $casts = [
        'content_vars' => 'array'
    ];

    public static function events($array = true, $section_id = null)
    {
        $events = NotificationEvent::select('event_name', 'id');

        if ($events) {
            $events = $events = $events->where('section_id', $section_id);
        }
        $events = $array ? $events->pluck('event_name', 'id') : $events->get();

        return $events;
    }
}
