<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StudentPermission;
use App\Http\Requests\student\StoreStudentPermissionRequest;
use App\Http\Requests\student\UpdateStudentPermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminStudentPermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:StudentPermissions-list|StudentPermissions-create|StudentPermissions-edit|StudentPermissions-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:StudentPermissions-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:StudentPermissions-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:StudentPermissions-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = StudentPermission::select(
            'student_permissions.id',
            'student_permissions.student_id',
            'student_permissions.pickup_persion',
            'student_permissions.pickup_time',
            'student_permissions.permission_reson',
            'student_permissions.permission_duration',
            'student_permissions.approved_by',
            'student_permissions.case_id',

            'genders.gender_name',

            'schools.school_name',

            'grades.grade_name',

            'class_rooms.class_name',

            'levels.level_name',

            'permission_cases.case_name',
            'permission_cases.case_color',
            'students.student_name',
            DB::raw('CONCAT(admins.first_name, " " ,admins.last_name) as admin_name'),
        )
            ->join('students', 'students.id', 'student_permissions.student_id')
            ->join('contracts', 'contracts.student_id', 'students.id')
            ->leftjoin('users as admins', 'admins.id', 'student_permissions.approved_by')
            ->leftjoin('users as guardians', 'guardians.id', 'students.guardian_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->leftjoin('class_rooms', 'class_rooms.id', 'contracts.class_id')
            ->leftjoin('permission_cases', 'permission_cases.id', 'student_permissions.case_id')
            ->orderBy('student_permissions.id');

        if ($request->filled('search')) {
            $permissions = $permissions->where('students.student_name', 'like', '%' . $request->case_id . '%');
        }


        if ($request->filled('case_id') && is_numeric($request->case_id)) {
            $permissions = $permissions->where('student_permissions.case_id', $request->case_id);
        }


        if ($request->filled('date_from')) {
            # select start date
            $permissions = $permissions->whereDate('student_permissions.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $permissions = $permissions->whereDate('student_permissions.created_at', '<=', $request->date_to);
        }

        $permissions = $permissions->orderBy('student_permissions.id', 'DESC')
            ->paginate(config('view.per_page', 30));

        return view('admin.student.permissions.index', compact('permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentPermissionsRequest  $request
     * @param  \App\Models\StudentPermissions  $StudentPermissions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentPermissionRequest $request, StudentPermission $permission)
    {
        if (!$permission->update($request->only(['case_id']) + ['approved_by' => Auth::id()])) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تحديث حالة الأذن ');
        }

        return redirect()->route('permissions.index')
            ->with('alert-success', 'تم تحديث حالة الأذن بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentPermissions  $StudentPermissions
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentPermission $StudentPermission)
    {

        if ($StudentPermission->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف طلب الاستئذان ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ .. فشل حذف طلب الاستئذان ');
    }
}
