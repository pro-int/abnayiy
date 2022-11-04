<?php

namespace Gtech\AbnayiyNotification\Controllers\admin;

use App\Http\Controllers\Controller;
use Gtech\AbnayiyNotification\Models\NotificationChannel;
use Illuminate\Http\Request;

class AdminNotificationChannelController extends Controller
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
        $Channels = NotificationChannel::orderBy('id')->get();

        return view('Notification::Notifications.Channels.index', compact('Channels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Notification::Notifications.Channels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotificationContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function show($studentTransportation)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationChannel $channel)
    {
      
        return view('Notification::Notifications.Channels.edit', compact('channel'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationContentRequest  $request
     * @param  \App\Models\StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationChannel $channel)
    {
       $channel->channel_name = $request->channel_name;
       $channel->config = $request->config;
       $channel->active = (bool) $request->active;

        if ($channel->save()) {
            return redirect()->route('channels.index')
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
    public function destroy()
    {
        //
    }
}
