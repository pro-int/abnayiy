<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\semester;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentAttendanceController extends Controller
{

    public function get_attandance($student_id)
    {
        $year =  $this->GetAcademicYear();

        $StudentPermissions = StudentPermission::select(
            'student_permissions.pickup_persion',
            'student_permissions.pickup_time',
            'student_permissions.permission_reson',
            'student_permissions.permission_duration',
            'student_permissions.approved_by',
            'permission_cases.case_name',
            'permission_cases.case_color',
        )
            ->leftjoin('permission_cases', 'permission_cases.id', 'student_permissions.case_id')
            ->whereDate('student_permissions.pickup_time', '>=', $year->year_start_date)
            ->where('student_permissions.student_id', $student_id)
            ->get();

        $StudentAbsent = StudentAttendance::select(
            'student_attendances.student_id',
            'student_attendances.absent_date',
            'student_attendances.reason',
        )
            ->whereDate('student_attendances.absent_date', '>', $year->year_start_date)
            ->where('student_attendances.student_id', $student_id)
            ->get();
        return $this->ApiSuccessResponse(['StudentPermissions' => $StudentPermissions, 'StudentAbsent' => $StudentAbsent]);
//        return response()->json([
//            'done' => true,
//            'success' => true,
//            'data' => ['StudentPermissions' => $StudentPermissions, 'StudentAbsent' => $StudentAbsent]
//        ]);
    }

}
