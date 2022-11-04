<?php

namespace Gtech\AbnayiyNotification\Controllers\admin;

use App\Http\Controllers\Controller;
use Gtech\AbnayiyNotification\Models\Notification;
use Gtech\AbnayiyNotification\Models\NotificationEvent;
use Gtech\AbnayiyNotification\Requests\Notifications\StoreNotificationChannelRequest;
use Gtech\AbnayiyNotification\Requests\Notifications\UpdateNotificationChannelRequest;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{

    public function home()
    {
        return view('Notification::Notifications.home');
    }

    public function index()
    {
        $notifications = Notification::select('notifications.*', 'notification_events.external_allowed', 'notification_events.internal_allowed', 'notification_events.event_name', 'notification_sections.section_name')
            ->leftjoin('notification_events', 'notification_events.id', 'notifications.event_id')
            ->leftjoin('notification_sections', 'notification_sections.id', 'notification_events.section_id')
            ->orderBy('notifications.id')
            ->get();

        return view('Notification::Notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('Notification::Notifications.create');
    }

    public function store(StoreNotificationChannelRequest $request)
    {
        $notification = new Notification();

        $notification->notification_name = $request->notification_name;
        $notification->event_id = $request->event_id;
        $notification->active = (bool) $request->active;

        if ($notification->save()) {
            return redirect()->route('notifications.index')
                ->with('alert-success', 'تم اضافة الاشعار بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة الاشعار');
    }


    public function edit($notification)
    {
        $notification = Notification::select('notifications.*', 'notification_events.section_id')
            ->leftjoin('notification_events', 'notification_events.id', 'notifications.event_id')
            ->findOrFail($notification);


        return view('Notification::Notifications.edit', compact('notification'));
    }

    public function update(UpdateNotificationChannelRequest $request, Notification $notification)
    {
        $notification->notification_name = $request->notification_name;
        $notification->event_id = $request->event_id;
        $notification->active = (bool) $request->active;

        if ($notification->save()) {
            return redirect()->route('notifications.index')
                ->with('alert-success', 'تم تعديل الاشعار بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة الاشعار');
    }

    public function destroy(Notification $notification)
    {
        if ($notification->delete()) {
            return redirect()->route('notifications.index')
                ->with('alert-success', 'تم حضف الاشعار بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف الاشعار');
    }

    public function updateNotificationSettings($notification)
    {
        return $notification;

        return view('Notification::Notifications.edit', compact('notification'));
    }

    public function getSectionEvents(Request $request)
    {
        $events = NotificationEvent::select('id', 'section_id', 'event_name', 'content_vars')->get()->toArray();
        return $this->ApiSuccessResponse($events);
    }
}
