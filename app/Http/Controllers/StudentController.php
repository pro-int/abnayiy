<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\ParticipationReport;
use App\Models\Student;
use App\Models\StudentCall;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function student_info($id)
    {
        # get single student info if $reuest has id
        try {
            $students = Student::select('students.*', 'class_rooms.class_name', 'levels.level_name', 'levels.next_level_id', 'schools.school_name', 'grades.grade_name', 'genders.gender_name', 'contracts.id as contract_id', 'contracts.student_id', 'contracts.exam_result')
                ->leftJoin('contracts', function ($query) {
                    $query->on('contracts.student_id', '=', 'students.id')
                        ->whereRaw('contracts.id IN (select MAX(a2.id) from contracts as a2 join students as u2 on u2.id = a2.student_id group by u2.id)');
                })
                ->leftjoin('class_rooms', 'contracts.class_id', 'class_rooms.id')
                ->leftjoin('levels', 'levels.id', 'contracts.level_id')
                ->leftjoin('grades', 'grades.id', 'levels.grade_id')
                ->leftjoin('genders', 'genders.id', 'grades.gender_id')
                ->leftjoin('schools', 'schools.id', 'genders.school_id')
                ->where('students.guardian_id', Auth::id())
                ->whereHas('contract');

            // ->where('guardian_id', Auth::user()->guardian->id);

            if ($id == 'all') {
                $students = $students->get();
            } else {
                $students = $students->where('students.id', $id)->get();
            }
            return $this->ApiSuccessResponse($students);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->ApiErrorResponse('خطا غير متوقع اثناء استعادة المعلومات');
        }
    }

    public function student_call(Request $request)
    {
        # get single student info if $reuest has id
        try {
            $student = Student::where('id', $request->student_id)->where('guardian_id', Auth::id())->first();
            // StudentCall::where('student_id', $student->id)->delete();
            $old_call = StudentCall::whereDate('call_date', '>=', Carbon::now()->subMinutes(5))->where('student_id', $student->id)->first();
            if ($old_call) {
                $message = 'تم نداء نفس الطالبة خلال الخمس دقائق الماضية';
                return $this->ApiErrorResponse($message, 422);
            }
            if (!$student) {
                $message = 'فشل العثور علي الطالب';
                return $this->ApiErrorResponse($message, 401);
            }

            $call = StudentCall::create(['student_id' => $student->id, 'call_date' => Carbon::now()]);

            if ($call) {
                $message = 'تم نداء الطالبة بنجاح';
                return $this->ApiSuccessResponse($call, $message);
            }
            $message = 'فشل تسجيل نداء الطالبة';
            return $this->ApiErrorResponse($message);
        } catch (\Throwable $th) {
            $message = 'خطا غير متوقع اثناء استعادة المعلومات';
            return $this->ApiErrorResponse($message);
        }
    }

    public function student_participation(Request $request)
    {

        $student = Student::where('id', $request->student_id)->where('guardian_id', Auth::id())->first();

        if ($student) {

            $participation = ParticipationReport::select('participation_reports.id', 'participation_reports.day_name', 'participation_reports.report_date')
                ->where('class_id', $student->class_id)
                ->with(['marks' => function ($q) use ($student) {
                    $q->leftjoin('subjects', 'subjects.id', 'student_participations.subject_id')->where('student_participations.student_id', $student->id);
                }]);


            if ($request->has('date')) {
                $participation  = $participation->whereDate('report_date', $request->date);
            }
            $participation =  $participation->get();

            return $participation;
        } else {
            $message = 'فشل العثور علي الطالب';
            return $this->ApiErrorResponse($message, 401);
        }
    }
}
