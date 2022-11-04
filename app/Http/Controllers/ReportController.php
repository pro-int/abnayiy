<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ParticipationReport;
use App\Models\semester;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ReportRequest;
class ReportController extends Controller
{
    public function report_index(ReportRequest $request)
    {
       

        # find report
        switch ($request->report) {
            case 'permissions':
               return $this->permissions_report($request);
                break;

            case 'attandance':
                return $this->attandance_report($request);

                break;

            // case 'participation':
            //     return $this->participation_report($request);
            //     break;

            // default:
            //     # code...
            //     break;
        }
    }

    public function permissions_report(Request $request)
    {

        try {
            $students = Student::where('guardian_id', Auth::id());

            if ($request->student_id != 'all') {
                $students = $students->where('id', $request->student_id);
            }
            $students = $students->pluck('id');

            if ($students) {

                $permission =  StudentPermission::select(
                    'students.student_name',
                    'student_permissions.pickup_persion',
                    'student_permissions.pickup_time',
                    'student_permissions.permission_reson',
                    'student_permissions.permission_duration',
                    'permission_cases.case_name',
                    'permission_cases.case_color',
                    'student_permissions.student_id',
                )
                    ->leftjoin('students', 'students.id', 'student_permissions.student_id')
                    ->leftjoin('users', 'users.id', 'students.guardian_id')
                    ->leftjoin('permission_cases', 'permission_cases.id', 'student_permissions.case_id')
                    ->whereIn('student_permissions.student_id', $students)
                    ->orderBy('student_permissions.id', 'DESC');

                if ($request->has('semester_id')) {
                    if ($request->semester_id == 'all') {
                        # get acadmic year
                        $AcademicYear = $this->GetAcademicYear();
                        $date_from = $AcademicYear->year_start_date;
                        $date_to = $AcademicYear->year_end_date;
                    } else {
                        $semester = semester::find($request->semester_id);
                        $date_from = $semester->semester_start;
                        $date_to = $semester->semester_end;
                    }
                    $permission = $permission->whereBetween('pickup_time', [$date_from, $date_to]);
                } else {

                    if ($request->has('date_to')) {
                        $permission = $permission->whereBetween('pickup_time', [$request->date_from, $request->date_to]);
                    } else {
                        $permission = $permission->whereDate('pickup_time', '=', $request->date_from);
                    }
                }

                $permission = $permission->get();

                $data = [
                    'report_title' => 'تقرير الأسئذان',
                    'report_disc' => 'تقرير الأسئذان',
                    'school_name' => 'تقرير الأسئذان',
                    'school_phone' => 'تقرير الأسئذان',
                    'school_email' => 'تقرير الأسئذان',
                    'school_website' => 'تقرير الأسئذان',
                    'logo' => '',
                    'headers' => [
                        'student_name' => 'اسم الطالب',
                        'pickup_persion' => 'المرافق',
                        'pickup_time' => 'الوقت',
                        'permission_reson' => 'السبب',
                        'permission_duration' => 'المدة',
                        'case_name' => 'الحالة',
                    ],
                    'report' => $permission,
                ];

                return $this->ApiSuccessResponse($data);
            }

            // return response()->json(
            //     [
            //         'done' => true,
            //         'success' => false,
            //         'message' => 'تعذر العثور علي الطالب المطلوب'
            //     ],
            //     201
            // );
            return $this->ApiErrorResponse('تعذر العثور علي الطالب المطلوب',201);

            
        } catch (\Throwable $th) {
            Log::debug($th);
            // return response()->json(
            //     [
            //         'done' => true,
            //         'success' => false,
            //         'message' => 'خطأ داخلي رجاء المحاولة لاحقا'
            //     ],
            //     500
            // );
            return $this->ApiErrorResponse('خطأ داخلي رجاء المحاولة لاحقا');

                }
    }

    public function attandance_report(Request $request)
    {

        try {
            $students = Student::where('guardian_id', Auth::id());

            if ($request->student_id != 'all') {
                $students = $students->where('id', $request->student_id);
            }
            $students = $students->pluck('id');

            if ($students) {

                $StudentAbsent = StudentAttendance::select(
                    'students.student_name',
                    'student_attendances.absent_date',
                    'student_attendances.reason',
                    // 'student_attendances.student_id',

                )
                    ->whereIn('student_attendances.student_id', $students)
                    ->leftjoin('students', 'students.id', 'student_attendances.student_id')
                    ->leftjoin('users', 'users.id', 'students.guardian_id')
                    ->orderBy('student_attendances.id', 'DESC');

                if ($request->has('semester_id')) {
                    if ($request->semester_id == 'all') {
                        # get acadmic year
                        $AcademicYear = $this->GetAcademicYear();
                        $date_from = $AcademicYear->year_start_date;
                        $date_to = $AcademicYear->year_end_date;
                    } else {
                        $semester = semester::find($request->semester_id);
                        $date_from = $semester->semester_start;
                        $date_to = $semester->semester_end;
                    }
                    $StudentAbsent = $StudentAbsent->whereBetween('absent_date', [$date_from, $date_to]);
                } else {

                    if ($request->has('date_to')) {
                        $StudentAbsent = $StudentAbsent->whereBetween('absent_date', [$request->date_from, $request->date_to]);
                    } else {
                        $StudentAbsent = $StudentAbsent->whereDate('absent_date', '=', $request->date_from);
                    }
                }


                $StudentAbsent = $StudentAbsent->get();
                $data = [
                    'report_title' => 'تقرير الغياب',
                    'report_disc' => 'تقرير الأسئذان',
                    'school_name' => 'تقرير الأسئذان',
                    'school_phone' => 'تقرير الأسئذان',
                    'school_email' => 'تقرير الأسئذان',
                    'school_website' => 'تقرير الأسئذان',
                    'logo' => '',
                    'headers' => [
                        'student_name' => 'اسم الطالب',
                        'absent_date' => 'التاريخ',
                        'reason' => 'السبب',
                    ],
                    'report' => $StudentAbsent,
                ];
                return $this->ApiSuccessResponse($data);
//                return response()->json(
//                    [
//                        'done' => true,
//                        'success' => true,
//                        'data' => [
//                            'report_title' => 'تقرير الغياب',
//                            'report_disc' => 'تقرير الأسئذان',
//                            'school_name' => 'تقرير الأسئذان',
//                            'school_phone' => 'تقرير الأسئذان',
//                            'school_email' => 'تقرير الأسئذان',
//                            'school_website' => 'تقرير الأسئذان',
//                            'logo' => '',
//                            'headers' => [
//                                'student_name' => 'اسم الطالب',
//                                'absent_date' => 'التاريخ',
//                                'reason' => 'السبب',
//                            ],
//                            'report' => $StudentAbsent,
//                        ]
//                    ],
//                );
            }

            // return response()->json(
            //     [
            //         'done' => true,
            //         'success' => false,
            //         'message' => 'تعذر العثور علي الطالب المطلوب'
            //     ],
            //     201
            // );
            return $this->ApiErrorResponse('تعذر العثور علي الطالب المطلوب',201);

        } catch (\Throwable $th) {
            Log::debug($th);
            // return response()->json(
            //     [
            //         'done' => true,
            //         'success' => false,
            //         'message' => 'خطأ داخلي رجاء المحاولة لاحقا'
            //     ],
            //     500
            // );
            return $this->ApiErrorResponse('خطأ داخلي رجاء المحاولة لاحقا');
            
        }
    }


    public function participation_report(Request $request)
    {
        try {
            $students = Student::where('guardian_id', Auth::id());

            if ($request->student_id != 'all') {
                $students = $students->where('id', $request->student_id);
            }
            $students = $students->pluck('id');

            if ($students) {

                $participation = ParticipationReport::select('participation_reports.id','participation_reports.day_name','participation_reports.report_date')
                ->with(['marks' => function($q) use($students)
                {
                   $q->leftjoin('subjects','subjects.id','student_participations.subject_id')->whereIn('student_participations.student_id',$students);
                }]);


                if ($request->has('date')) {
                    $participation  = $participation->whereDate('report_date',$request->date);
                }
                $participation =  $participation->get();
                $permission =  StudentPermission::select(
                    'student_permissions.*',
                    'permission_cases.case_name',
                    'permission_cases.case_color',
                    DB::raw('CONCAT(students.student_name, " " ,users.first_name, " ", users.last_name) as student_name')
                )
                    ->leftjoin('students', 'students.id', 'student_permissions.student_id')
                    ->leftjoin('users', 'users.id', 'students.guardian_id')
                    ->leftjoin('permission_cases', 'permission_cases.id', 'student_permissions.case_id')
                    ->whereIn('student_permissions.student_id', $students)
                    ->orderBy('student_permissions.id', 'DESC');

                if ($request->has('semester_id')) {
                    if ($request->semester_id == 'all') {
                        # get acadmic year
                        $AcademicYear = $this->GetAcademicYear();
                        $date_from = $AcademicYear->year_start_date;
                        $date_to = $AcademicYear->year_end_date;
                    } else {
                        $semester = semester::find($request->semester_id);
                        $date_from = $semester->semester_start;
                        $date_to = $semester->semester_end;
                    }
                    $permission = $permission->whereBetween('pickup_time', [$date_from, $date_to]);
                } else {

                    if ($request->has('date_to')) {
                        $permission = $permission->whereBetween('pickup_time', [$request->date_from, $request->date_to]);
                    } else {
                        $permission = $permission->whereDate('pickup_time', '=', $request->date_from);
                    }
                }

                $permission = $permission->get();

                $data = [
                    'report_title' => 'تقرير الأسئذان',
                    'report_disc' => 'تقرير الأسئذان',
                    'school_name' => 'تقرير الأسئذان',
                    'school_phone' => 'تقرير الأسئذان',
                    'school_email' => 'تقرير الأسئذان',
                    'school_website' => 'تقرير الأسئذان',
                    'logo' => '',
                    'headers' => [
                        'student_name' => 'اسم الطالب',
                        'pickup_persion' => 'المرافق',
                        'pickup_time' => 'الوقت',
                        'permission_reson' => 'السبب',
                        'permission_duration' => 'المدة',
                        'case_name' => 'الحالة',
                    ],
                    'report' => $permission,
                ];

                return $this->ApiSuccessResponse($data);
            }

            // return response()->json(
            //     [
            //         'done' => true,
            //         'success' => false,
            //         'message' => 'تعذر العثور علي الطالب المطلوب'
            //     ],
            //     201
            // );
            return $this->ApiErrorResponse('تعذر العثور علي الطالب المطلوب',201);

            
        } catch (\Throwable $th) {
            Log::debug($th);
            // return response()->json(
            //     [
            //         'done' => true,
            //         'success' => false,
            //         'message' => 'خطأ داخلي رجاء المحاولة لاحقا'
            //     ],
            //     500
            // );
            return $this->ApiErrorResponse('خطأ داخلي رجاء المحاولة لاحقا');

        }
    }
}
