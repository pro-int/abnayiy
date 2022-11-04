<?php

namespace Gtech\AbnayiyNotification;

use Carbon\Carbon;
use Gtech\AbnayiyNotification\Models\NotificationType;

class ApplyFrequentNotification extends ApplyNotification
{
    public function fireNotification()
    {

        $this->NotificationTypes = NotificationType::select('notification_types.*', 'notifications.event_id', 'notification_events.model_namespace', 'notification_events.fun_name')
            ->leftjoin('notifications', 'notifications.id', 'notification_types.notification_id')
            ->leftjoin('notification_events', 'notification_events.id', 'notifications.event_id')
            ->where('notification_types.frequent', 'frequent')
            ->where('notifications.active', 1)
            ->where('notification_types.active', 1)
            ->with('frequents', function ($query) {
                $query->where('active', 1);
            })
            ->get();

        return $this->sendNotifications();
    }

    protected function sendNotifications()
    {
        foreach ($this->NotificationTypes as $notification) {
            foreach ($notification->frequents as $frequent) {

                if (is_callable(ApplyFrequentNotification::class . '::get' . $notification->fun_name)) {
                    $items = call_user_func([$this, 'get' . $notification->fun_name], $notification, $frequent);
                    if ($items) {
                        foreach ($items as $item) {
                            $this->model = $item;
                            $this->target_users = $this->getTargetUsers($notification);
                            $this->contents = $this->prepareContent($item, $frequent->content_id);
                            call_user_func([$this, 'send' . $notification->type . 'Notification'], $notification);
                        }
                    }
                } else {
                    info('cant - call_user_func : ' . $notification->fun_name);
                }
            }
        }

        return true;
    }

    protected function getMeetingNotifications($type, $frequent)
    {
        if ($frequent->condition_type == 'before') {
            $date = Carbon::now()->addHours($frequent->interval);

            $day = $date->format('Y-m-d');
            $time_from = $date->format('H:i');
            $time_to = $date->addMinutes(1)->format('H:i');
        } else {
            $date = Carbon::now()->subHours($frequent->interval);
            $day = $date->format('Y-m-d');
            $time_from = $date->format('H:i');
            $time_to = $date->addMinutes(1)->format('H:i');
        }

        $model = new $type->model_namespace;
        $model = $model->select('reserved_appointments.*', 'applications.guardian_id')
            ->leftjoin('applications', 'applications.appointment_id', 'reserved_appointments.id')
            ->whereDate('date', $day)
            ->whereBetween('appointment_time', [$time_from, $time_to])
            ->whereNull('admin_id')
            ->get();

        return $model;
    }
}
