<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointmentoffice\StoreAppointmentOfficeRequest;
use App\Http\Requests\Appointmentoffice\UpdateAppointmentOfficeRequest;
use App\Models\AppointmentOffice;
use App\Models\AppointmentSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAppointmentOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offices = AppointmentOffice::select('appointment_offices.*')
            ->orderBy('appointment_offices.id');
      
            $section = null ;
        if ($request->filled('section')) {
            $section = AppointmentSection::find($request->section);

            $offices_ids = DB::table('section_has_offices')->where('appointment_section_id', $section->id)->pluck('appointment_office_id')->toArray();
            $offices = $offices->whereIn('id', $offices_ids);
        }


        $offices = $offices->get();
        return view('admin.Appointment.Office.index', compact('offices','section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $studentSections = AppointmentSection::pluck('section_name', 'id')->toArray();
        return view('admin.Appointment.Office.create', compact('studentSections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreOfficeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentOfficeRequest $request)
    {
        $office = AppointmentOffice::create($request->only(['office_name', 'employee_name', 'phone']));
        $office->sections()->sync($request->sections);

        if ($office) {
            return redirect()->route('appointments.offices.index')
                ->with('alert-success', 'تم اضافة المكتب بنجاح');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(AppointmentOffice $office)
    {
        return view('admin.Appointment.Office.view', compact('office'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(AppointmentOffice $office)
    {
        return view('admin.Appointment.Office.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfficeRequest  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentOfficeRequest $request, AppointmentOffice $office)
    {
        $office->sections()->sync($request->sections);
        $office = $office->update($request->only(['office_name', 'employee_name', 'phone']));

        if (!$office) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات المكتب ');
        }

        return redirect()->route('appointments.offices.index')
            ->with('alert-success', 'تم تعديل معلومات المكتب بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppointmentOffice $office)
    {
        $office->sections()->sync([]);

        if (!$office->delete()) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء حذف معلومات المكتب ');
        }

        return redirect()->route('appointments.offices.index')
            ->with('alert-success', 'تم حذف المكتب بنجاح');
    }
}
