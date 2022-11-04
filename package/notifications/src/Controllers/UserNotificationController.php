<?php

namespace Gtech\AbnayiyNotification\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Gtech\AbnayiyNotification\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserNotificationController extends Controller
{
    public function sentNotifications()
    {
        $notifications = UserNotification::select('user_notifications.*', 'notification_types.type', DB::raw('CONCAT(first_name, " " ,last_name) as name'), 'notification_channels.channel_name', 'notifications.notification_name')
            ->leftjoin('notification_channels', 'notification_channels.id', 'user_notifications.channel_id')
            ->leftjoin('notification_types', 'notification_types.id', 'user_notifications.notification_type_id')
            ->leftjoin('notifications', 'notifications.id', 'notification_types.notification_id')
            ->leftjoin('users', 'users.id', 'user_notifications.user_id')
            ->orderBy('user_notifications.id', 'desc')
            ->paginate(config('view.per_page', 30));

        return view('Notification::Notifications.UserNotifications.index', compact('notifications'));
    }

    public function MyNotifications(Request $request)
    {

        $notifications = UserNotification::leftjoin('notification_channels', 'notification_channels.id', 'user_notifications.channel_id')
            ->leftjoin('notification_types', 'notification_types.id', 'user_notifications.notification_type_id')
            ->leftjoin('notifications', 'notifications.id', 'notification_types.notification_id')
            ->Where('user_id', Auth::id())
            ->orderBy('user_notifications.id', 'desc');

        if ($request->wantsJson()) {
            $notifications = $notifications->select('user_notifications.id', 'notifications.notification_name', 'user_notifications.notification_text', 'user_notifications.internal_url', 'user_notifications.created_at', 'user_notifications.created_at', 'notification_types.type', 'notification_channels.channel_name', 'notifications.notification_name', 'user_notifications.seen')->where('sent', 1)->get();
            return $this->ApiSuccessResponse($notifications);
        }
        $notifications = $notifications->select('user_notifications.*', 'notification_types.type', 'notification_channels.channel_name', 'notifications.notification_name')->paginate(config('view.per_page', 30));

        return view('Notification::Notifications.UserNotifications.mypage', compact('notifications'));
    }

    public function UserNotifications(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $notifications = UserNotification::select('user_notifications.*', 'notification_types.type', 'notification_channels.channel_name', 'notifications.notification_name')
            ->leftjoin('notification_channels', 'notification_channels.id', 'user_notifications.channel_id')
            ->leftjoin('notification_types', 'notification_types.id', 'user_notifications.notification_type_id')
            ->leftjoin('notifications', 'notifications.id', 'notification_types.notification_id')
            ->Where('user_id', $user_id)
            ->orderBy('user_notifications.id', 'desc')
            ->paginate(config('view.per_page', 30));

        return view('Notification::Notifications.UserNotifications.userpage', compact('notifications', 'user'));
    }

    public function setNotificationAsSeen(Request $request)
    {
        if ($request->filled('notification_id')) {
            $notification = UserNotification::Where('user_id', Auth::id())
                ->findOrFail($request->notification_id);

            $notification->seen = 1;
            $notification->save();
        }
        return $this->ApiSuccessResponse([]);
    }
}
