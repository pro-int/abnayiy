<?php // Code within \package\notifications\src\Helppers\NotificationHelper.php

use Gtech\AbnayiyNotification\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

/**
 * @return \Gtech\AbnayiyNotification\Models\UserNotification -  last 6 user AbnayiyNotification
 */
function GetUserNotification()
{
    return UserNotification::select('user_notifications.id', 'user_notifications.sent', 'user_notifications.notification_text', 'user_notifications.internal_url', 'notifications.notification_name', 'user_notifications.created_at')
        ->leftjoin('notification_types', 'notification_types.id', 'user_notifications.notification_type_id')
        ->leftjoin('notifications', 'notifications.id', 'notification_types.notification_id')
        ->where('notification_types.type', 'internal')
        ->where('notification_types.target_user', 'admin')
        ->Where('user_id', Auth::id())
        ->orderBy('user_notifications.id', 'desc')
        ->limit(6)
        ->get();

}
