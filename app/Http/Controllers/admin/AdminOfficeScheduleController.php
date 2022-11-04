<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\Appointments\StoreAppointmentRequest;
use App\Http\Requests\Appointments\UpdateAppointmentRequest;
use App\Models\officeSchedule;
use App\Http\Controllers\Controller;
use App\Models\AppointmentOffice;
use App\Models\Office;

class AdminOfficeScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AppointmentOffice $office)
    {
        $schedules = officeSchedule::where('office_id', $office->id)
            ->orderBy('office_schedules.id')
            ->get();

        return view('admin.Appointment.Office.Schedule.index', compact('schedules', 'office'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(AppointmentOffice $office)
    {
        return view('admin.Appointment.Office.Schedule.create', compact('office'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAppointmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentRequest $request)
    {
        $appointment = officeSchedule::create($request->only(['day_of_week', 'time_from', 'time_to', 'active']) + ['office_id' => $request->office]);

        if ($appointment) {
            return redirect()->route('appointments.offices.days.index', [$request->office])
                ->with('alert-success', 'تم اضافة المواعيد بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة مواعيد اليوم ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(AppointmentOffice $office, officeSchedule $day)
    {
        return view('admin.Appointment.Office.Schedule.show', compact('office', 'day'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(AppointmentOffice $office, officeSchedule $day)
    {
        return view('admin.Appointment.Office.Schedule.edit', compact('office', 'day'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAppointmentRequest  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentRequest $request, $office, officeSchedule $day)
    {
        $app = $day->update($request->only(['day_of_week', 'time_from', 'time_to', 'active']));
        if (!$app) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات الميعاد ');
        }

        return redirect()->route('appointments.offices.days.index', [$office])
            ->with('alert-success', 'تم تعديل معلومات الميعاد بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($office, officeSchedule $day)
    {
        if ($day->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف مواعيد اليوم بنجاح');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء حذف مواعيد اليوم ');
        }
    }
}
