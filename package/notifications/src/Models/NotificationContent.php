<?php

namespace Gtech\AbnayiyNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationContent extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'content_name',
        'sms_content',
        'email_content',
        'email_subject',
        'telegram_content',
        'whatsapp_content',
        'internal_content',
        'content_vars',
        'event_id'
    ];

    protected $casts = [
        'content_vars' => 'array'
    ]; 

    public static function contents($array = true, $event_id = null)
    {
        $contrnts = NotificationContent::select('id','content_name');

        $contrnts = null !== $event_id ?  $contrnts->where('event_id',$event_id) : $contrnts;
        
        return $array ? $contrnts->pluck('content_name','id') : $contrnts->get();
    }
}
