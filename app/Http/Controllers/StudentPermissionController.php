<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\StudentPermission;
use App\Http\Requests\student\StoreStudentPermissionRequest;
use App\Models\AcademicYear;
use App\Models\guardian;
use App\Models\semester;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentPermissionController extends Controller
{

    public function new_permission(StoreStudentPermissionRequest $request)
    {
        $student = Student::where('id', $request->student_id)->where('guardian_id', Auth::id())->first();
        if ($student) {
            $permission =  StudentPermission::create($request->all());

            return $this->ApiSuccessResponse($permission,'تم تسجيل الأذن بنجاح');
//            return response()->json(
//                [
//                    'done' => true,
//                    'success' => true,
//                    'data' => $permission,
//                    'message' => 'تم تسجيل الأذن بنجاح'
//                ],
//            );
        }

        // return response()->json(
        //     [
        //         'done' => true,
        //         'success' => false,
        //         'message' => 'تعذر العثور علي الطالب المطلوب'
        //     ],
        //     201
        // );
        return $this->ApiErrorResponse( 'تعذر العثور علي الطالب المطلوب',201);

    }

    public function get_permissions()
    {
        $students = guardian::where('guardian_id', Auth::id())->first()->students()->pluck('id');

        if ($students) {

            $permission =  StudentPermission::select('student_permissions.*', 'students.student_name', 'permission_cases.case_name', 'permission_cases.case_color')
                ->leftjoin('students', 'students.id', 'student_permissions.student_id')
                ->leftjoin('permission_cases', 'permission_cases.id', 'student_permissions.case_id')
                ->whereIn('student_permissions.student_id', $students)->orderBy('student_permissions.id', 'DESC')->get();

                return $this->ApiSuccessResponse($permission);
        }

        // return response()->json(
        //     [
        //         'done' => true,
        //         'success' => false,
        //         'message' => 'تعذر العثور علي الطالب المطلوب'
        //     ],
        //     201
        // );
        return $this->ApiErrorResponse( 'تعذر العثور علي الطالب المطلوب',201);

    }
}
