<?php

namespace Gtech\AbnayiyNotification\Controllers;

use App\Http\Controllers\Controller;
use Gtech\AbnayiyNotification\Models\NotificationChannel;
use Gtech\AbnayiyNotification\Models\UserNotificationSetting;
use Gtech\AbnayiyNotification\Requests\setting\UpdateNotificationSettingRequest;
use Illuminate\Http\Request;

class UserNotificationSettingController extends Controller
{
    public function update(UpdateNotificationSettingRequest $request)
    {
        $user_id = auth()->id();
        $setting = UserNotificationSetting::find($user_id);
        $mandatory_channels = NotificationChannel::where('is_mandatory', 1)->pluck('id')->toArray();

        $channels = array_map('intval', array_unique(array_merge($mandatory_channels, $request->channels)));

        if (!$setting) {
            $setting = new UserNotificationSetting();
            $setting->user_id = $user_id;
        }

        $setting->channels =  $channels;
        $updated = $setting->save();

        if ($request->wantsJson()) {
            return $updated ? $this->ApiSuccessResponse(['channels' => $channels], 'تم تحديث اعدادات الأشعارات بنجاح ') : $this->ApiErrorResponse('فشل تحدث اعدادات الأشعارات', 404);
        }
    }

    public function notificationChannels()
    {
        $Channels = NotificationChannel::where('active', 1)->select('id', 'channel_name', 'is_mandatory', 'icon_name')->orderBy('id')->get();
        $user_setting = UserNotificationSetting::select('channels')->find(auth()->id());

        foreach ($Channels as $channel) {
            $channel->is_selected = in_array($channel->id, $user_setting['channels']);
        }
        return $this->ApiSuccessResponse(['Channels' => $Channels], 'تم تحديث اعدادات الأشعارات بنجاح ');
    }
}
