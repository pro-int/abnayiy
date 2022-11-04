<?php

namespace Gtech\AbnayiyNotification;

use App\Models\User;
use Gtech\AbnayiyNotification\Models\NotificationChannel;
use Gtech\AbnayiyNotification\Models\UserNotification;
use Gtech\AbnayiyNotification\Models\UserNotificationSetting;
use Gtech\AbnayiyNotification\Traits\NotificationContentTrait;
use Gtech\AbnayiyNotification\Traits\ChannelSenderTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplyNotification
{
    use NotificationContentTrait, ChannelSenderTrait;

    public $user_id;
    public $model;
    public $event_id;
    public $frequent;
    public $notification;
    public $channels;
    public $NotificationTypes;
    public $target_users;
    public $contents;
    public $current_user;
    public $current_user_settings;
    public $internal_url = null;


    protected function getTargetUsers($notification)
    {

        if ($notification->target_user == 'user') {
            $users = [];
            $user = null;
            if ($this->user_id) {
                $user = $this->user_id;
            } else if ($this->model->user_id) {
                $user = $this->model->user_id;
            } else if ($this->model->guardian_id) {
                $user =  $this->model->guardian_id;
            } else if (Auth::check()) {
                $user =  Auth::id();
            }
            null !== $user && array_push($users, $user);

            return $users;
        } else {
            return array_unique(DB::table('model_has_roles')->where('role_id', $notification->to_notify)->pluck('model_id')->toArray());
        }
    }


    protected function sendInternalNotification($notification)
    {
        foreach ($this->target_users as $user) {
            // if (is_callable($this->model . '::getInternalUrl')) {
                try {
                    $this->internal_url =  $this->model->getInternalUrl();
                } catch (\Throwable $th) {
                    info('sinlent bug');
                    info($th);
                }
            // }
            $this->storeUserNotification($notification, $user);
        }
    }

    protected function storeUserNotification($notification, $user_id, $channel_id = null, $target_content = 'internal_content', $data = null)
    {
        $new_notification = new UserNotification();
        $new_notification->model_id = $this->model->id;
        $new_notification->notification_type_id = $notification->id;
        $new_notification->notification_text = $this->contents[$target_content];
        $new_notification->internal_url = $this->internal_url;
        $new_notification->channel_id = $channel_id;
        $new_notification->user_id = $user_id;
        $new_notification->sent = 1;
        if (null !== $data) {
            $new_notification->response = $data['response'];
            $new_notification->sent = (bool) $data['sent'];
        }
        $new_notification->save();
    }

    protected function sendExternalNotification($notification)
    {
        $this->channels = $this->getNotificationschannels($notification);

        foreach ($this->target_users as $user) {

            $this->current_user = User::find($user);

            $this->current_user_settings = UserNotificationSetting::where('user_id', $user)->first();

            if ($this->current_user_settings && is_array($this->current_user_settings->channels)) {
                // $userchannels = $this->channels->whereIn('id', [1, 2, 3, 4]);
                $userchannels = $this->channels->whereIn('id', $this->current_user_settings->channels);

                foreach ($userchannels as $channel) {
                    $response = call_user_func([$this, 'send' . $channel->fuc_name], $channel);
                    $response && $this->storeUserNotification($notification, $user, $channel->id, $channel->content_name, $response);
                }
            }
        }
    }

    protected function getNotificationschannels($notification)
    {
        return NotificationChannel::whereIn('id', $notification->channels)->where('active', true)->get();
    }
}
