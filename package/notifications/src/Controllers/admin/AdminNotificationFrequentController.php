<?php

namespace Gtech\AbnayiyNotification\Controllers\admin;

use App\Http\Controllers\Controller;
use Gtech\AbnayiyNotification\Models\Notification;
use Gtech\AbnayiyNotification\Models\NotificationFrequent;
use Gtech\AbnayiyNotification\Requests\Notifications\Frequent\StoreNotificationFrequentRequest;
use Gtech\AbnayiyNotification\Requests\Notifications\Frequent\UpdateNotificationFrequentRequest;

class AdminNotificationFrequentController extends Controller
{
    public function index($notification, $type)
    {
        $notification = Notification::select('notifications.*', 'notification_events.event_name', 'notification_sections.section_name', 'notification_types.type')
            ->leftjoin('notification_types', 'notification_types.notification_id', 'notifications.id')
            ->leftjoin('notification_events', 'notification_events.id', 'notifications.event_id')
            ->leftjoin('notification_sections', 'notification_sections.id', 'notification_events.section_id')
            ->where('notification_types.frequent', 'frequent')
            ->where('notification_types.id',$type)
            ->FindOrFail($notification);

        $frequent_notifications = NotificationFrequent::select('notification_frequents.*','notification_contents.content_name')
        ->leftjoin('notification_contents','notification_contents.id','notification_frequents.content_id' )    
        ->where('notification_type_id', $type)
        ->orderBy('notification_frequents.id')
        ->get();

        return view('Notification::Notifications.Frequent.index', compact('notification', 'frequent_notifications'));
    }

    public function create($notification, $type)
    {
        $notification = Notification::select('notifications.*', 'notification_events.event_name', 'notification_sections.section_name')
            ->leftjoin('notification_events', 'notification_events.id', 'notifications.event_id')
            ->leftjoin('notification_sections', 'notification_sections.id', 'notification_events.section_id')
            ->FindOrFail($notification);

        return view('Notification::Notifications.Frequent.create', compact('notification', 'type'));
    }

    public function store(StoreNotificationFrequentRequest $request)
    {
        $notifications_frequent = new NotificationFrequent();

        $notifications_frequent->condition_type = $request->condition_type;
        $notifications_frequent->interval = $request->interval;
        $notifications_frequent->content_id = $request->content_id;
        $notifications_frequent->notification_type_id = $request->type;
        $notifications_frequent->active = $request->active;
        
        if ($notifications_frequent->save()) {
            return redirect()->route('notifications.types.frequent.index', ['notification' => $request->notification, 'type' => $request->type])
                ->with('alert-success', 'تم اضافة الاشعار المتكرر بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة الاشعار المتكرر');
    }

    public function edit($notification, $type, NotificationFrequent $frequent)
    {
        $notification = Notification::select('notifications.*', 'notification_events.event_name', 'notification_sections.section_name')
        ->leftjoin('notification_events', 'notification_events.id', 'notifications.event_id')
        ->leftjoin('notification_sections', 'notification_sections.id', 'notification_events.section_id')
        ->FindOrFail($notification);


        return view('Notification::Notifications.Frequent.edit', compact('notification', 'frequent'));
    }

    public function update(UpdateNotificationFrequentRequest $request, $notification, $type, NotificationFrequent $frequent)
    {

        $frequent->condition_type = $request->condition_type;
        $frequent->interval = $request->interval;
        $frequent->content_id = $request->content_id;
        $frequent->active = $request->active;

        if ($frequent->save()) {
            return redirect()->route('notifications.types.frequent.index', ['notification' => $notification, 'type' => $type])
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
