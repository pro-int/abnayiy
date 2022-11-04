<?php

namespace Gtech\AbnayiyNotification\Controllers\admin;

use App\Http\Controllers\Controller;
use Gtech\AbnayiyNotification\Requests\Content\UpdateNotificationContentRequest;
use Gtech\AbnayiyNotification\Requests\Content\StoreNotificationContentRequest;
use App\Models\admin;
use Gtech\AbnayiyNotification\Models\Notification;
use Gtech\AbnayiyNotification\Models\NotificationContent;
use Gtech\AbnayiyNotification\Models\NotificationEvent;
use Gtech\AbnayiyNotification\Models\NotificationSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdminNotificationContentController extends Controller
{

    function __construct()
    {
        // $this->middleware('permission:ApplicationManagers-list|ApplicationManagers-create|ApplicationManagers-edit|ApplicationManagers-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:ApplicationManagers-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:ApplicationManagers-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:ApplicationManagers-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = NotificationContent::select('notification_contents.*', 'notification_events.event_name','notification_sections.section_name')
            ->leftjoin('notification_events', 'notification_events.id', 'notification_contents.event_id')
            ->leftjoin('notification_sections', 'notification_sections.id', 'notification_events.section_id')
            ->orderBy('notification_contents.id')
            ->get();

        return view('Notification::Notifications.Content.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = NotificationSection::pluck('section_name', 'id')->toArray();

        return view('Notification::Notifications.Content.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotificationContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationContentRequest $request)
    {
        $content = new NotificationContent([
            'content_name' => $request->content_name,
            'event_id' => $request->event_id,
            'internal_content' => $request->internal_content,
            'email_subject' => $request->email_subject,
            'sms_content' => $request->sms_content,
            'email_content' => $request->email_content,
            'telegram_content' => $request->telegram_content,
            'whatsapp_content' => $request->whatsapp_content,
        ]);

        
        if ($content->save()) {
            return redirect()->route('contents.index')
                ->with('alert-success', 'تم اضافة المحتوي بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة المحتوي');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function show($content)
    {
       $content = NotificationContent::select('notification_contents.*','notification_events.section_id')
       ->where('notification_contents.id',$content)
        ->leftjoin('notification_events','notification_events.id','notification_contents.event_id')
        ->first();
        return view('Notification::Notifications.Content.view', compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function edit($content)
    {
       $content = NotificationContent::select('notification_contents.*','notification_events.section_id')
       ->where('notification_contents.id',$content)
        ->leftjoin('notification_events','notification_events.id','notification_contents.event_id')
        ->first();
        return view('Notification::Notifications.Content.edit', compact('content'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationContentRequest  $request
     * @param  \App\Models\StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationContentRequest $request, $content)
    {
        $update = NotificationContent::where('id',$content)->update([
            'content_name' => $request->content_name,
            'event_id' => $request->event_id,
            'internal_content' => $request->internal_content,
            'sms_content' => $request->sms_content,
            'email_subject' => $request->email_subject,
            'email_content' => $request->email_content,
            'telegram_content' => $request->telegram_content,
            'whatsapp_content' => $request->whatsapp_content,
        ]);

        if ($update) {
            return redirect()->route('contents.index')
                ->with('alert-success', 'تم اضافة المحتوي بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة المحتوي');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationContent $content)
    {
        if ($content->delete()) {
            return redirect()->route('contents.index')
                ->with('alert-success', 'تم حضف المحتوي بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف المحتوي');
    }
}
