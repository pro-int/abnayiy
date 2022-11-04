<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\ClassRoom;
use App\Models\PermissionCase;
use App\Models\semester;
use App\Models\StudentAttendance;
use App\Models\StudentPermission;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportsController extends Controller
{
    public function application_report(Request $request)
    {
        # get application report data
        $applications = Application::select(
            'applications.*',
            'schools.school_name',
            'levels.level_name',
            'grades.grade_name',
            'genders.gender_name',
            'application_statuses.status_name',
            'application_statuses.color',
            'transportations.transportation_type',
            DB::raw('CONCAT(countries.country_code,users.phone) as phone'),
        )
            ->leftjoin('users', 'users.id', 'applications.guardian_id')
            ->leftjoin('schools', 'schools.id', 'applications.school_id')
            ->leftjoin('levels', 'levels.id', 'applications.level_id')
            ->leftjoin('grades', 'grades.id', 'applications.grade_id')
            ->leftjoin('genders', 'genders.id', 'applications.gender_id')
            ->leftjoin('countries', 'countries.id', 'users.country_id')
            ->leftjoin('application_statuses', 'application_statuses.id', 'applications.status_id')
            ->leftjoin('transportations', 'transportations.id', 'applications.transportation_id')
            ->orderby('applications.id');

        $data = [
            'date' => '',
            'status' => 'جميع الطلبات',
            'transportation' => 'مشترك او غير مشترك'
        ];

        if ($request->has('status_id') && is_numeric($request->status_id)) {
            $applications = $applications->where('applications.status_id', $request->status_id);
            $data['status'] = ApplicationStatus::Statuses(true, $request->status_id)->status_name;
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $applications = $applications->whereDate('applications.created_at', '>=', $request->date_from);
            $data['date'] .= ' من : ' . $request->date_from;
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $applications = $applications->whereDate('applications.created_at', '<=',  $request->date_to);
            $data['date'] .= ' - الي : ' . $request->date_to;
        }

        if ($request->has('transportation') && $request->transportation == 'on') {
            $applications = $applications->whereNotNull('applications.transportation_id');
            $data['transportation'] = 'نعم';
        }

        if ($request->has('action') && $request->action == 'saveReport') {
            $applications = $applications->get();
            if (count($applications)) {
                # return report only if have data , 
                $html = view('admin.reports.pdf.applicationsPDF', compact('applications', 'data'))->render();
                return $this->get_pdf($html, 'تقرير الطلبات.pdf');
            }
            return back()->with('alert-danger', 'لا توجد بيانات لاصدار التقرير ');
        }

        $applications = $applications->paginate(config('view.per_page', 30));
        return view('admin.reports.applications', compact('applications'));
    }

    public function permissions_report(Request $request)
    {
        #permissions report
        $permissions = StudentPermission::select(
            'student_permissions.*',
            'permission_cases.case_name',
            'permission_cases.case_color',
            'students.student_name',
            DB::raw('CONCAT(admins.first_name, " ", admins.last_name) as admin_name')
        )
            ->leftjoin('students', 'students.id', 'student_permissions.student_id')
            ->leftjoin('users', 'users.id', 'students.guardian_id')
            ->leftjoin('users as admins', 'admins.id', 'student_permissions.approved_by')
            ->leftjoin('permission_cases', 'permission_cases.id', 'student_permissions.case_id')
            ->orderBy('student_permissions.id', 'DESC');

        $students = [];

        $data = [
            'date' => '',
            'caeses' => 'جميع الحالات',
            'students' => []
        ];

        if ($request->has('case_id') && is_array($request->case_id)) {
            $permissions = $permissions->whereIn('student_permissions.case_id', $request->case_id);
            $data['caeses'] = PermissionCase::cases(true, $request->case_id);
        }

        if ($request->has('student_id') && is_array($request->student_id)) {
            $students = $request->student_id;

            $permissions = $permissions->whereIn('student_permissions.student_id', $request->student_id);
            $data['students'] = $request->student_id;
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $permissions = $permissions->whereDate('student_permissions.pickup_time', '>=', $request->date_from);
            $data['date'] .= ' من : ' . $request->date_from;
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $permissions = $permissions->whereDate('student_permissions.pickup_time', '<=',  $request->date_to);
            $data['date'] .= ' - الي : ' . $request->date_to;
        }

        if ($request->has('action') && $request->action == 'saveReport') {
            $permissions = $permissions->get();
            if (count($permissions)) {
                # return report only if have data , 
                $html = view('admin.reports.pdf.permissionsPDF', compact('permissions', 'data'))->render();
                return $this->get_pdf($html, 'تقرير الاستئئذان.pdf');
            }
            return back()->with('alert-danger', 'لا توجد بيانات لاصدار التقرير ');
        }

        $permissions = $permissions->paginate(config('view.per_page', 30));

        return view('admin.reports.permissions', compact('permissions', 'students'));
    }

    public function attandance_report(Request $request)
    {

        $classes =  School::with(['genders', 'genders.grades', 'genders.grades.levels', 'genders.grades.levels.classrooms'])->get();

        $StudentAbsents = StudentAttendance::select(
            'student_attendances.id',
            'students.student_name',
            'student_attendances.student_id',
            'student_attendances.absent_date',
            'student_attendances.reason',
            'class_rooms.class_name',
            DB::raw('CONCAT(admins.first_name, " ", admins.last_name) as admin_name'),
        )
            ->leftjoin('students', 'students.id', 'student_attendances.student_id')
            ->leftjoin('class_rooms', 'class_rooms.id', 'students.class_id')
            ->leftjoin('users', 'users.id', 'students.guardian_id')
            ->leftjoin('users as admins', 'users.id', 'student_attendances.add_by')
            ->orderBy('student_attendances.id', 'DESC');

        $students = [];

        $data = [
            'date' => '',
            'students' => [],
            'classes' => []
        ];

        if ($request->has('class_id') && is_array($request->class_id)) {

            $StudentAbsents = $StudentAbsents->whereIn('students.class_id', $request->class_id);
            $data['classes'] = ClassRoom::classes(1, $request->class_id);
        }

        if ($request->has('student_id') && is_array($request->student_id)) {
            $students = $request->student_id;

            $StudentAbsents = $StudentAbsents->whereIn('student_attendances.student_id', $request->student_id);
            $data['students'] = $request->student_id;
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $StudentAbsents = $StudentAbsents->whereDate('student_attendances.absent_date', '>=', $request->date_from);
            $data['date'] .= ' من : ' . $request->date_from;
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $StudentAbsents = $StudentAbsents->whereDate('student_attendances.absent_date', '<=',  $request->date_to);
            $data['date'] .= ' - الي : ' . $request->date_to;
        }

        if ($request->has('action') && $request->action == 'saveReport') {
            $StudentAbsents = $StudentAbsents->get();
            if (count($StudentAbsents)) {
                # return report only if have data , 

                $html = view('admin.reports.pdf.attendancesPDF', compact('StudentAbsents', 'data'))->render();
                return $this->get_pdf($html, 'تقرير الغياب.pdf');
            }
            return back()->with('alert-danger', 'لا توجد بيانات لاصدار التقرير ');
        }


        $StudentAbsents = $StudentAbsents->paginate(config('view.per_page', 30));

        return view('admin.reports.attendances', compact('StudentAbsents', 'classes', 'students'));
    }
}
