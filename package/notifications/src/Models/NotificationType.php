<?php

namespace Gtech\AbnayiyNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class NotificationType extends Model
{
    use HasFactory;
    
    protected $fillable=['notification_name','notification_id'];
    
    protected $casts = [
        'to_notify' => 'array',
        'channels' => 'array'
    ]; 
   
    public function frequents()
    {
        return $this->hasMany(NotificationFrequent::class);
    }

    public function getFrequentAttribute($value)
    {
        return $value == 'single' ? 'مرة واحدة' : 'متكرر';
    }

    public static function GetAllowedTypes($event_id)
    {
        $event = NotificationEvent::find($event_id);
        $types = [];
        if ($event) {
            if($event->single_allowed){ $types += ['single' => 'مرة واحدة'] ;}
            if($event->frequent_allowed){ $types += ['frequent' => 'متكرر'];}
        }

        return $types;
    }
 
}
