<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\AppointmentSections\StoreAppointmentSectionRequest;
use App\Http\Requests\AppointmentSections\UpdateAppointmentSectionRequest;
use App\Models\AppointmentSection;
use App\Http\Controllers\Controller;
use App\Models\AppointmentOffice;
use App\Models\Office;
use Illuminate\Support\Facades\DB;

class AdminAppointmentSectionController extends Controller
{
    
    function __construct()
    {
        $this->middleware('permission:appointments-list|appointments-create|appointments-edit|appointments-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:appointments-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:appointments-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:appointments-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = AppointmentSection::all();
        return view('admin.Appointment.Sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Appointment.Sections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentSections\StoreAppointmentSectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentSectionRequest $request)
    {
        $section = AppointmentSection::create($request->only('section_name', 'max_day_to_reservation'));

        if ($section) {
            return redirect()->route('appointments.sections.index')
                ->with('alert-success', 'تم اضافة القسم بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة معلومات القسم ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppointmentSection  $section
     * @return \Illuminate\Http\Response
     */
    public function show(AppointmentSection $section)
    {
        return view('admin.Appointment.Sections.view', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppointmentSection  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(AppointmentSection $section)
    {
        return view('admin.Appointment.Sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentSections\UpdateAppointmentSectionRequest  $request
     * @param  \App\Models\AppointmentSection  $section
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentSectionRequest $request, AppointmentSection $section)
    {

        if ($section->update($request->only('section_name', 'max_day_to_reservation'))) {
            return redirect()->route('appointments.sections.index')
                ->with('alert-success', 'تم تعديل معلومات القسم بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل معلومات القسم ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppointmentSection  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppointmentSection $section)
    {
        if ($section->delete()) {

            return redirect()->back()
                ->with('alert-success', 'تم حذف القسم بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف معلومات القسم ');
    }

    public function getSectionOffices(AppointmentSection $section)
    {
        $offices_ids = DB::table('section_has_offices')->where('appointment_section_id', $section->id)->pluck('office_id')->toArray();
        $offices = AppointmentOffice::select('appointment_offices.*', 'appointment_offices.name', 'appointment_offices.employee_name', 'appointment_offices.phone')
            ->whereIn('id', $offices_ids)
            ->orderBy('appointment_offices.id');
        $offices = $offices->get();


        return view('admin.Appointment.Office.index', compact('offices', 'section'));
    }
}
