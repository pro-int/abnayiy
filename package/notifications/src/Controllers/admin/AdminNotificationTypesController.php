<?php

namespace Gtech\AbnayiyNotification\Controllers\admin;

use App\Http\Controllers\Controller;
use Gtech\AbnayiyNotification\Models\NotificationType;
use Gtech\AbnayiyNotification\Models\Notification;
use Gtech\AbnayiyNotification\Requests\Notifications\Types\StoreNotificationTypeRequest;
use Gtech\AbnayiyNotification\Requests\Notifications\Types\UpdateNotificationTypeRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminNotificationTypesController extends Controller
{

    public function index(Request $request, $notification)
    {
        $notification = Notification::select('notifications.id', 'notifications.notification_name', 'notification_events.event_name', 'notification_sections.section_name')
            ->leftjoin('notification_events', 'notification_events.id', 'notifications.event_id')
            ->leftjoin('notification_sections', 'notification_sections.id', 'notification_events.section_id')
            ->findOrFail($notification);

        $notifications_types = NotificationType::select('notification_types.*', 'notification_contents.content_name')
            ->leftjoin('notification_contents', 'notification_contents.id', 'notification_types.content_id')
            ->where('notification_id', $notification->id)
            ->where('notification_types.type', $request->selected_type)
            ->orderBy('notification_types.id')
            ->get();

        return view('Notification::Notifications.Types.index', compact('notification', 'notifications_types'));
    }

    public function create(Notification $notification)
    {
        $roles = Role::pluck('display_name', 'id');

        return view('Notification::Notifications.Types.create', compact('notification', 'roles'));
    }

    public function store(StoreNotificationTypeRequest $request)
    {
        $notifications_type = new NotificationType();

        $notifications_type->notification_id = $request->notification;
        $notifications_type->frequent = $request->frequent;
        $notifications_type->target_user = $request->target_user;
        $notifications_type->content_id = $request->content_id;
        $notifications_type->to_notify = $request->to_notify;
        $notifications_type->channels = $request->channels;
        $notifications_type->type = $request->type;
        $notifications_type->active = $request->active;

        if ($notifications_type->save()) {
            return redirect()->route('notifications.types.index', ['notification' => $request->notification, 'selected_type' => $request->type])
                ->with('alert-success', 'تم اضافة الاشعار بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة الاشعار');
    }

    public function edit($notification, $notification_type)
    {
        $notification_type = NotificationType::select('notification_types.*', 'notifications.event_id')
            ->leftjoin('notifications', 'notifications.id', 'notification_types.notification_id')
            ->findOrFail($notification_type);

        $roles = Role::pluck('display_name', 'id');
        return view('Notification::Notifications.Types.edit', compact('notification_type', 'roles'));
    }

    public function update(UpdateNotificationTypeRequest $request, $notification, NotificationType $type)
    {

        $type->content_id = $request->content_id;
        $type->to_notify = $request->to_notify;
        $type->channels = $request->channels;
        $type->active = $request->active;

        if ($type->save()) {
            return redirect()->route('notifications.types.index', ['notification' => $request->notification, 'selected_type' => $type->type])
                ->with('alert-success', 'تم تعديل الاشعار بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل الاشعار');
    }

    public function destroy($notification, NotificationType $type)
    {
        if ($type->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف الاشعار بنجاج');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف الاشعار');
    }

}
