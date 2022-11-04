<?php

namespace Gtech\AbnayiyNotification\Controllers\admin;

use App\Http\Controllers\Controller;
use Gtech\AbnayiyNotification\Models\Notification;
use Gtech\AbnayiyNotification\Models\NotificationEvent;
use Gtech\AbnayiyNotification\Models\NotificationFrequent;
use Gtech\AbnayiyNotification\Models\NotificationSection;
use Gtech\AbnayiyNotification\Requests\Notifications\Frequent\StoreNotificationFrequentRequest;
use Gtech\AbnayiyNotification\Requests\Notifications\Frequent\UpdateNotificationFrequentRequest;
use Illuminate\Http\Request;

class AdminNotificationEventsController extends Controller
{
    public function index(NotificationSection $section)
    {
        $events = NotificationEvent::select('notification_events.*','notification_sections.section_name')
            ->leftjoin('notification_sections','notification_sections.id','notification_events.section_id')
            ->where('section_id', $section->id)
            ->orderBy('notification_events.id')
            ->get();

        return view('Notification::Notifications.Events.index', compact('events','section'));
    }

    // public function create($notification, $type)
    // {
    //     $notification = Notification::select('notifications.*', 'notification_events.event_name', 'notification_sections.section_name')
    //         ->leftjoin('notification_events', 'notification_events.id', 'notifications.event_id')
    //         ->leftjoin('notification_sections', 'notification_sections.id', 'notification_events.section_id')
    //         ->FindOrFail($notification);

    //     return view('Notification::Notifications.Frequent.create', compact('notification', 'type'));
    // }

    // public function store(StoreNotificationFrequentRequest $request)
    // {
    //     $notifications_frequent = new NotificationFrequent();

    //     $notifications_frequent->condition_type = $request->condition_type;
    //     $notifications_frequent->interval = $request->interval;
    //     $notifications_frequent->content_id = $request->content_id;
    //     $notifications_frequent->notification_type_id = $request->type;
    //     $notifications_frequent->active = $request->active;

    //     if ($notifications_frequent->save()) {
    //         return redirect()->route('notifications.types.frequent.index', ['notification' => $request->notification, 'type' => $request->type])
    //             ->with('alert-success', 'تم اضافة الاشعار المتكرر بنجاح');
    //     }
    //     return redirect()->back()
    //         ->with('alert-danger', 'خطأ اثناء اضافة الاشعار المتكرر');
    // }

    public function edit(NotificationSection $section, NotificationEvent $event)
    {
        
        return view('Notification::Notifications.Events.edit', compact('event','section'));
    }

    public function update(Request $request,$section, NotificationEvent $event)
    {
        $event->event_name = $request->event_name;
        $event->frequent_allowed = (bool) $request->frequent_allowed;
        $event->single_allowed = (bool) $request->single_allowed;
        $event->content_vars = $request->content_vars;

        if ($event->save()) {
            return redirect()->route('sections.events.index',['section' => $section,'event' => $event->id ])
                ->with('alert-success', 'تم تعديل الاشعار بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل الاشعار');
    }

    public function destroy($notification, $type, NotificationFrequent $frequent)
    {
        if ($frequent->delete()) {
            return redirect()->route('notifications.types.frequent.index', ['notification' => $notification, 'type' => $type])
                ->with('alert-success', 'تم حذف التكرار بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف التكرار المحتوي');
    }
}
