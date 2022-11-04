<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\StudentParticipation;
use App\Http\Requests\StoreStudentParticipationRequest;
use App\Http\Requests\UpdateStudentParticipationRequest;
use App\Models\AttendanceReport;
use App\Models\Helper;
use App\Models\ParticipationReport;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminStudentParticipationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:StudentParticipations-list|StudentParticipations-create|StudentParticipations-edit|StudentParticipations-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:StudentParticipations-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:StudentParticipations-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:StudentParticipations-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = ClassRoom::with('students')->whereHas('students')->get();

        return view('admin.StudentParticipation.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $class  = ClassRoom::findOrFail($request->class);
        $students = Student::select('students.id','students.student_name')->where('class_id', $class->id)->get();

        return view('admin.StudentParticipation.create', compact('class', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentParticipationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentParticipationRequest $request)
    {
        $inserted = DB::transaction(function () use ($request) {

            $user_id = Auth::id();
            $report = ParticipationReport::whereDate('report_date', $request->report_date)->where('class_id', $request->class_id)->first();
            if (!$report) {
                $report = new ParticipationReport();
                $report->report_date = $request->report_date;
                $report->day_name = Helper::arabic_date($request->report_date);
                $report->class_id = $request->class_id;
                $Marks_data = [];

                foreach ($request->marks as $key => $mark) {
                    array_push($Marks_data, ['student_id' => $key, 'subject_id' => $request->subject_id, 'home_work' => $mark['home_work'], 'participation' => $mark['participation'], 'attention' => $mark['attention'], 'tools' => $mark['tools'], 'add_by' => $user_id, 'report_id' => $report->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
                }
    
                return StudentParticipation::insert($Marks_data);
                
            }
            return false;

        });

        if (!$inserted) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة تفاصيل المشاركة');
        }

        return redirect()->route('StudentParticipations.index')
            ->with('alert-success', 'تم اضافة تفاصيل المشاركة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentParticipation  $studentParticipation
     * @return \Illuminate\Http\Response
     */
    public function show(StudentParticipation $studentParticipation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentParticipation  $studentParticipation
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentParticipation $studentParticipation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentParticipationRequest  $request
     * @param  \App\Models\StudentParticipation  $studentParticipation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentParticipationRequest $request, StudentParticipation $studentParticipation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentParticipation  $studentParticipation
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentParticipation $studentParticipation)
    {
        //
    }
    /**
     * Get  Student Participation Reports 
     *
     * @param  int $class_id
     * @return \Illuminate\Http\Response
     */
    public function getStudentClassRoomParticipationReports($class_id)
    {
        $participation_reports = ParticipationReport::select('participation_reports.id', 'participation_reports.day_name', 'participation_reports.report_date', 'class_rooms.id as class_id', 'class_rooms.class_name')
            ->leftjoin('class_rooms', 'class_rooms.id', 'participation_reports.class_id')
            ->where('participation_reports.class_id', $class_id)
            ->orderby('participation_reports.id', 'desc')
            ->get();
        return view('admin.StudentParticipation.reports', compact('participation_reports'));
    }
    /**
     * Get  Student Participation Details of Reports 
     *
     * @param  int $report_id
     * @return \Illuminate\Http\Response
     */
    public function getStudentParticipationDetails($report_id,$class_id)
    {
        $report = ParticipationReport::findorFail($report_id);
        $students = StudentParticipation::select('students.id','students.student_name','student_participations.home_work','student_participations.participation','student_participations.attention','student_participations.tools','student_participations.report_id')
        ->join('students','students.id','student_participations.student_id')
        ->where('student_participations.report_id',$report_id)
        ->where('students.class_id', $class_id)
        ->get();
        
        
        return view('admin.StudentParticipation.details', compact('students','report','class_id'));
    }
    public function updateStudentParticipationDetails(Request $request)
    {
        $clear_old_data = StudentParticipation::where('report_id',$request->report_id)->delete();
        if (!$clear_old_data) {
            return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل  تفاصيل المشاركة');
        }

        $inserted = DB::transaction(function () use ($request) {

            $user_id = Auth::id();
            
            $Marks_data = [];
            foreach ($request->marks as $key => $mark) {
                array_push($Marks_data, ['student_id' => $key, 'subject_id' => $request->subject_id, 'home_work' => $mark['home_work'], 'participation' => $mark['participation'], 'attention' => $mark['attention'], 'tools' => $mark['tools'], 'add_by' => $user_id, 'report_id' => $request->report_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            }

            return StudentParticipation::insert($Marks_data);
        });

        if (!$inserted) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة تفاصيل المشاركة');
        }

        return redirect()->route('StudentParticipations.index')
            ->with('alert-success', 'تم اضافة تفاصيل المشاركة بنجاح');
    }
}
