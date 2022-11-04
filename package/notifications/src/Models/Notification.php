<?php

namespace Gtech\AbnayiyNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Gtech\AbnayiyNotification\Models\NotificationType;
class Notification extends Model
{
    use HasFactory;
    
    protected $primery_key = 'notification_id';

    protected $fillable=['notification_name','event_id','channels','active'];
    
    public function notificationTypes()
    {
        return $this->hasMany(NotificationType::class,'notification_id','id');
    }
   

}
