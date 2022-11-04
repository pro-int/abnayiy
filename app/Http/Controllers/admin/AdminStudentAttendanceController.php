<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use App\Http\Requests\student\StoreStudentAttendanceRequest;
use App\Http\Requests\student\UpdateStudentAttendanceRequest;
use App\Models\AttendanceManager;
use App\Models\AttendanceReport;
use App\Models\ClassRoom;
use App\Models\Helper;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminStudentAttendanceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:StudentAttendances-list|StudentAttendances-create|StudentAttendances-edit|StudentAttendances-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:StudentAttendances-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:StudentAttendances-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:StudentAttendances-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year = GetAcademicYear();
        $can_mange = AttendanceManager::where('admin_id', Auth::id())->pluck('level_id')->toArray();
        $classes = ClassRoom::with('students')->where('academic_year_id', $year->id)->whereIn('level_id', $can_mange)->get();
        // $classes = ClassRoom::with('students')->get();

        return view('admin.StudentAttendance.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $class  = ClassRoom::findOrFail($request->class);


        $can_mange = AttendanceManager::where('level_id', $class->level_id)->where('admin_id', Auth::id())->first();

        if (!$can_mange) {
            return redirect()->back()
                ->with('alert-danger', 'ليس لديك صلاحية ادخال الغياب الي الفصل المحدد');
        }

        $students = Student::select('students.id', DB::raw('CONCAT(students.student_name, " " ,users.first_name, " ", users.last_name) as student_name'))->where('class_id', $class->id)->leftjoin('users', 'users.id', 'students.guardian_id')->get();

        return view('admin.StudentAttendance.create', compact('class', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentAttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentAttendanceRequest $request)
    {
        if (!$request->has('absent')) {
            $request->flash('رجاء تحديد طالب واحد كغائب علي الاقل لتسجيل الغياب', 'error');
            return back();
        }
        $report = AttendanceReport::whereDate('report_date', $request->absent_date)->where('class_id', $request->class_id)->first();
        if (!$report) {
            $report = new AttendanceReport();
            $report->report_date = $request->absent_date;
            $report->day_name = Helper::arabic_date($request->absent_date);
            $report->class_id = $request->class_id;

            if (!$report->save()) {
                return redirect()->back()
                    ->with('alert-danger', 'خطأ اثناء اضافة تفاصيل الغياب');
            }
        }
        $absent_students = [];
        foreach ($request->absent as $key => $absent_student) {

            if (isset($absent_student['is_absent']) && (bool) $absent_student['is_absent']) {
                array_push($absent_students, ['student_id' => $key, 'absent_date' => $request->absent_date, 'reason' => (null !==  $absent_student['reason'] ? $absent_student['reason'] :  'بدون سبب'), 'class_id' => $request->class_id, 'add_by' => Auth::id(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            }
        }

        StudentAttendance::where('absent_date', $request->absent_date)->where('class_id', $request->class_id)->delete();
        $insertted = StudentAttendance::insert($absent_students);
        if (!$insertted) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة تفاصيل الغياب');
        }

        return redirect()->route('StudentAttendances.index')
            ->with('alert-success', 'تم اضافة تفاصيل الغياب بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentAttendanceRequest  $request
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentAttendanceRequest $request, StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentAttendance $studentAttendance)
    {
        //
    }
    /**
     * Get  Student Participation Reports 
     *
     * @param  int $class_id
     * @return \Illuminate\Http\Response
     */
    public function getStudentAttendanceReports($class_id)
    {
        $attendance_reports = AttendanceReport::select('attendance_reports.id', 'attendance_reports.day_name', 'attendance_reports.report_date', 'class_rooms.class_name')
            ->leftjoin('class_rooms', 'class_rooms.id', 'attendance_reports.class_id')
            ->where('attendance_reports.class_id', $class_id)
            ->orderby('attendance_reports.id', 'desc')
            ->get();
        return view('admin.StudentAttendance.reports', compact('attendance_reports'));
    }
    /**
     * Get  Student Attendance Details of Reports 
     *
     * @param  int $report_id
     * @return \Illuminate\Http\Response
     */
    public function getStudentAttendanceDetails($report_id)
    {
        dd($report_id);
    }
}
