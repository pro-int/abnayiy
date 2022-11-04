<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ReservedAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReservedAppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {      
        $appointments = ReservedAppointment::select('reserved_appointments.id','reserved_appointments.appointment_time', 'reserved_appointments.selected_date','appointment_offices.office_name','users.first_name','users.last_name','appointment_sections.section_name','reserved_appointments.created_at','reserved_appointments.updated_at')
        ->leftjoin('appointment_offices', 'appointment_offices.id', 'reserved_appointments.office_id')
        ->leftjoin('appointment_sections', 'appointment_sections.id', 'reserved_appointments.section_id')
        ->leftjoin('users', 'users.id', 'reserved_appointments.guardian_id')
        ->orderBy('reserved_appointments.id','DESC');
        
        if ($request->filled('office_id')) {
            $appointments = $appointments->where('reserved_appointments.office_id', $request->office_id);            
        }

        if ($request->filled('selected_date')) {
            $appointments = $appointments->whereDate('reserved_appointments.selected_date', $request->selected_date);
        }

       $appointments = $appointments->paginate();
       
        return view('admin.Appointment.Reserved.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        ReservedAppointment::where('id', $id)->delete();
        return redirect()->back()
            ->with('alert-success', 'تم حذف الميعاد بنجاح');
    }
}
