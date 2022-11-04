<?php

namespace Gtech\AbnayiyNotification;

use Gtech\AbnayiyNotification\Models\Notification;
use Gtech\AbnayiyNotification\Models\NotificationType;
use Illuminate\Database\Eloquent\Model;

class ApplySingleNotification extends ApplyNotification
{


    function __construct(Model $model, $event_id, $user_id = null)
    {
        $this->model = $model;
        $this->event_id = $event_id;
        $this->frequent = 'single';
        $this->user_id = $user_id;
    }

    public function fireNotification()
    {
        $notification = Notification::select('notifications.*', 'notification_events.model_namespace')
            ->leftjoin('notification_events', 'notification_events.id', 'notifications.event_id')
            ->where('notifications.event_id', $this->event_id)->where('active', true)->first();

        if ($notification && $this->model instanceof $notification->model_namespace) {
            $this->notification = $notification;
            return $this->getNotificationTypes();
        }
    }

    protected function getNotificationTypes()
    {
        $NotificationTypes = NotificationType::where('notification_id', $this->notification->id)
            ->where('frequent', $this->frequent)->where('active', true)->get();

        if ($NotificationTypes) {
            $this->NotificationTypes = $NotificationTypes;

            return $this->sendNotifications();
        }
    }

    protected function sendNotifications()
    {
        foreach ($this->NotificationTypes as $notification) {
            $this->target_users = $this->getTargetUsers($notification);
            $this->contents = $this->prepareContent($this->model, $notification->content_id);
            call_user_func([$this, 'send' . $notification->type . 'Notification'], $notification);
        }
        return true;
    }
}
