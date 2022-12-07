<?php

namespace App\Http\Controllers\guardian;

use App\Exports\ApplcationsExport;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Http\Requests\application\admin\StoreApplicationRequest;
use App\Http\Requests\application\admin\UpdateApplicationRequest;
use App\Http\Traits\CreatePdfFile;
use App\Http\Traits\ManageAppointments;
use App\Models\ApplicationManager;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\StudentContract;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\ReservedAppointment;
use App\Models\User;
use Gtech\AbnayiyNotification\ApplySingleNotification;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GuardianApplicationController extends Controller
{
    use Studentcontract, ManageAppointments, CreatePdfFile;

    function __construct()
    {
        $this->middleware('permission:guardian-applications-list|guardian-applications-create|guardian-applications-edit|guardian-applications-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:guardian-applications-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:guardian-applications-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:guardian-applications-delete', ['only' => ['destroy']]);
    }

    /**
     * return gardes can be managed by admin
     *
     * @return array App\Modals\ApplicationManager
     */
    protected function can_manage()
    {
        $grade_ids = ApplicationManager::where('admin_id', Auth::id())->pluck('grade_id');
        return Level::whereIn('grade_id', $grade_ids)->pluck('id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $applications = Application::select(
            'applications.*',
            'schools.school_name',
            'levels.level_name',
            'grades.grade_name',
            'genders.gender_name',
            'users.phone',
            DB::raw('CONCAT(users.first_name, " " ,users.last_name) as guardian_name'),
            'application_statuses.status_name',
            'application_statuses.color',
            'transportations.transportation_type',
            'academic_years.year_name',
            'admins.first_name as salse_admin_name',
            'guardians.national_id as guardian_national_id'
        )
            ->leftjoin('users', 'users.id', 'applications.guardian_id')
            ->leftjoin('levels', 'levels.id', 'applications.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->leftjoin('academic_years', 'academic_years.id', 'applications.academic_year_id')
            ->leftjoin('guardians', 'guardians.guardian_id', 'applications.guardian_id')
            ->leftjoin('application_statuses', 'application_statuses.id', 'applications.status_id')
            ->leftjoin('transportations', 'transportations.id', 'applications.transportation_id')
            ->leftjoin('users as admins', 'admins.id', 'applications.sales_id')
            ->orderby('applications.id', 'desc')
            ->with('contract')
            ->where('applications.guardian_id', auth()->id());



        if ($request->filled('search')) {
            if ($request->search[0] == '=') {

                $applications = $applications->where(function ($query) use ($request) {
                    $query->where('applications.id', substr($request->search, 1));
                });
            } else {
                if (is_numeric($request->search)) {
                    # search only numitic values
                    $applications = $applications->where(function ($query) use ($request) {
                        $query->where('applications.national_id', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('guardians.national_id', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('users.phone', 'LIKE', '%' . $request->search . '%');
                    });
                } else {

                    $applications = $applications->where(function ($query) use ($request) {
                        $query->orWhere('applications.student_name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('users.first_name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('users.last_name', 'LIKE', '%' . $request->search . '%');
                    });
                }
            }
        }

        $applications = $this->fillter_applications($request, $applications);

        $date_from =  $request->filled('date_from') ? $request->date_from : 'غير محدد';
        $date_to =  $request->filled('date_to') ? $request->date_to : 'غير محدد';

        if ($request->action == 'export_xlsx') {
            $applications = $applications->get();
            $export = new ApplcationsExport($applications, $date_from, $date_to);
            return count($applications) ? Excel::download($export, 'تقرير_الطلبات.xlsx') : redirect()->back()->with('alert-warning', 'لا توجد نتائج لمعاير اليحث')->withInput();
        }

        if ($request->action == 'export_pdf') {
            $applications = $applications->get();
            $html = view('parent.application.export', compact('applications', 'date_from', 'date_to'))->render();
            $pdf = $this->getPdf($html)->setWaterMark(public_path('/assets/reportLogo45d.png'));
            return count($applications) ?  response($pdf->output('تقرير_الطلبات.pdf', "I"), 200, ['Content-Type', 'application/pdf']) : redirect()->back()->with('alert-warning', 'لا توجد نتائج لمعاير اليحث')->withInput();
        }

        $applications  =  $applications->paginate(config('view.per_page', 30));
        return view('parent.application.index', compact('applications'));
    }

    protected function fillter_applications($request, $applications)
    {
        if ($request->filled('status_id') && is_numeric($request->status_id)) {
            $applications = $applications->where('applications.status_id', $request->status_id);
        }

        if ($request->filled('date_from')) {
            $applications = $applications->whereDate('applications.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $applications = $applications->whereDate('applications.created_at', '<=',  $request->date_to);
        }

        if ($request->filled('transportation') && $request->transportation == 'on') {
            $applications = $applications->whereNotNull('applications.transportation_id');
        }

        if ($request->filled('academic_year_id')) {
            $applications = $applications->where('applications.academic_year_id', $request->academic_year_id);
        }

        return $applications;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $year = $this->GetAdmissionAcademicYear();
        return view('parent.application.create', compact('year'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApplicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicationRequest $request)
    {
        // handel new application after validation is passed "ApplicationReuest"
        try {
            $user = User::whereHas('guardian')->with('guardian')->findOrFail(Auth::user()->id);
            if ($user) {
                // get gender
                $gender = Gender::findOrFail($request->gender_id);
                $level = Level::select('grade_id')->findOrFail($request->level_id);
                $grade = Grade::select('appointment_section_id')->findOrFail($level->grade_id);

                $new_meetig = $this->bookNewAppointment($request, $grade->appointment_section_id, $request->guardian_id);
                if ($new_meetig['success'] && isset($new_meetig['appointment'])) {
                    $application = new Application();
                    $application->student_name = $request->student_name;
                    $application->birth_place = $request->birth_place;
                    $application->national_id = $request->national_id;
                    $application->birth_date = $request->birth_date;
                    $application->student_care = $request->student_care;
                    $application->nationality_id = $request->nationality_id;
                    $application->plan_id = $request->plan_id;
                    $application->status_id = env('default_application_status', 1);
                    $application->gender = $gender->gender_type;
                    $application->level_id = $request->level_id;
                    $application->academic_year_id = $request->academic_year_id;
                    $application->appointment_id = $new_meetig['appointment']->id;
                    $application->transportation_id = $request->transportation_required ? $request->transportation_id : null;
                    $application->transportation_payment = $request->transportation_required ? $request->transportation_payment : null;
                    $application->sales_id = Auth::id();
                    $application->guardian_id=Auth::id();

                    if ($application->save()) {

                        $new_application = Application::select('applications.id', 'applications.student_name', 'applications.national_id', 'reserved_appointments.appointment_time', 'reserved_appointments.selected_date', 'appointment_sections.section_name', 'appointment_offices.office_name', 'appointment_offices.employee_name', 'appointment_offices.phone')
                            ->leftjoin('reserved_appointments', 'reserved_appointments.id', 'applications.appointment_id')
                            ->leftjoin('appointment_sections', 'appointment_sections.id', 'reserved_appointments.section_id')
                            ->leftjoin('appointment_offices', 'appointment_offices.id', 'reserved_appointments.office_id')
                            ->leftjoin('levels', 'levels.id', 'applications.level_id')
                            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
                            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
                            ->leftjoin('schools', 'schools.id', 'genders.school_id')
                            ->leftjoin('application_statuses', 'application_statuses.id', 'applications.status_id')
                            ->where('applications.id', $application->id)->first();

                        $nNotification = new ApplySingleNotification($new_application, 5);
                        $nNotification->fireNotification();

                        return redirect()->route('parent.applications.index', ['status_id' => 1])
                            ->with('alert-success', 'تم تسجيل الطلب بنجاح');
                    }
                    $msg = 'قشل تقديم الطلب .. فشل حفظ الطلب في قاعدة البيانات';
                } else {
                    $msg = 'قشل تقديم الطلب .. بسبب فشل حجز موعد المقابلة';
                }
            } else {
                $msg = 'قشل تقديم الطلب .. بسبب عدم العثور علي بيانات ولي الأمر';
            }
            return redirect()->back()->with('alert-danger', $msg)->withInput();
        } catch (\Throwable $th) {

            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة الطلب')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $application)
    {
        $application = Application::select(
            'applications.*',
            'schools.id as school_id',
            'genders.id as gender_id',
            'grades.id as grade_id',
            DB::raw('CONCAT(users.first_name, " " ,users.last_name) as full_name'),
            'users.phone',
            'users.email',
            'category_name',
            'guardians.national_id as user_national_id',
            'appointment_offices.office_name',
            'appointment_offices.employee_name',
            'reserved_appointments.selected_date',
            'reserved_appointments.online',
            'reserved_appointments.online_url',
            'reserved_appointments.handled_by',
            'reserved_appointments.appointment_time',
        )
            ->leftjoin('levels', 'levels.id', 'applications.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->leftjoin('users', 'users.id', 'applications.guardian_id')
            ->leftjoin('guardians', 'guardians.guardian_id', 'applications.guardian_id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->leftjoin('reserved_appointments', 'reserved_appointments.id', 'applications.appointment_id')
            ->leftjoin('appointment_offices', 'appointment_offices.id', 'reserved_appointments.office_id')
            ->whereIn('applications.level_id', $this->can_manage())
            ->findorfail($application);


        return view('parent.application.view', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit($application)
    {
        $application = Application::select(
            'applications.*',
            'schools.id as school_id',
            'genders.id as gender_id',
            'grades.id as grade_id',
            DB::raw('CONCAT(users.first_name, " " ,users.last_name) as full_name'),
            'users.phone',
            'users.email',
            'category_name',
            'guardians.national_id as user_national_id',
            'appointment_offices.office_name',
            'appointment_offices.employee_name',
            'reserved_appointments.selected_date',
            'reserved_appointments.online',
            'reserved_appointments.online_url',
            'reserved_appointments.handled_by',
            'reserved_appointments.appointment_time',
        )
            ->leftjoin('levels', 'levels.id', 'applications.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->leftjoin('users', 'users.id', 'applications.guardian_id')
            ->leftjoin('guardians', 'guardians.guardian_id', 'applications.guardian_id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->leftjoin('reserved_appointments', 'reserved_appointments.id', 'applications.appointment_id')
            ->leftjoin('appointment_offices', 'appointment_offices.id', 'reserved_appointments.office_id')
            ->findorfail($application);



        if ($application->status_id > 2) {
            return redirect()->back()
                ->with('alert-danger', 'لا يمكن تعديل هذا الطلب حيث انة قد تمت الموافقة علية');
        }

        return view('parent.application.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApplicationRequest  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $appointment = ReservedAppointment::findOrFail($application->appointment_id);

        $result = $this->UpdateAppointments($request, $appointment);

        if ($result['success']) {
            $nNotification = new ApplySingleNotification($appointment, 12, $application->guardian_id);
            $nNotification->fireNotification();
        } else {
            return redirect()->back()
                ->with('alert-danger', 'فشل تغيير معلومات الموعد');
        }

        info($request);
        if ($application->status_id <= 3 && $application->update($request->only(
                'student_name',
                'national_id',
                'birth_place',
                'birth_date',
                'nationality_id',
                'student_care',
                'school_id',
                'gender_id',
                'grade_id',
                'level_id',
                'plan_id',
                'status_id',
                'transportation_id',
                'transportation_payment'
            ))) {

            return redirect()->route('applications.index')
                ->with('alert-success', 'تم تعديل معلومات الطلب بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'لا يمكن تعديل هذا الطلب حيث انة قد تمت الموافقة علية');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        if ($application->delete()) {
            return redirect()->route('applications.index')
                ->with('alert-success', 'تم حذف الطلب بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف الطلب ');
    }


    /**
     * Get meeting information from js request.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function meeting_info(Request $request)
    {
        if ($request->isMethod('put')) {
            $appointment = ReservedAppointment::findOrFail($request->appointment_id);

            $result = $this->UpdateAppointments($request, $appointment);

            if ($result['success']) {
                $application = Application::findOrFail($request->application_id);
                $nNotification = new ApplySingleNotification($appointment, 12, $application->guardian_id);
                $nNotification->fireNotification();

                return redirect()->back()
                    ->with('alert-success', 'تم تعديل معلومات المقابلة بنجاح');
            }
            return redirect()->back()
                ->with('alert-danger', $result['message'] ?? 'خطأ اثناء تعديل معلومات المقابلة  ');
        } else {

            $meeting = ReservedAppointment::select('reserved_appointments.*', 'applications.id as application_id', 'levels.grade_id', 'appointment_offices.office_name', 'appointment_offices.employee_name')
                ->leftjoin('applications', 'applications.appointment_id', 'reserved_appointments.id')
                ->leftjoin('appointment_offices', 'appointment_offices.id', 'reserved_appointments.office_id')
                ->leftjoin('levels', 'levels.id', 'applications.level_id')
                ->findOrFail($request->appointment_id);

            if ($meeting) {
                $html = view('parent.application.meeting', compact('meeting'))->render();
                return response()->json([
                    'done' => true,
                    'html' => $html
                ]);
            }
        }
    }

    public function meeting_result(Request $request)
    {
        if ($request->isMethod('put')) {

            $application = Application::findorfail($request->application_id);

            $appointment = ReservedAppointment::select('reserved_appointments.*', 'applications.id as application_id')
                ->leftjoin('applications', 'applications.appointment_id', 'reserved_appointments.id')
                ->findOrFail($request->appointment_id);

            $appointment->update(array_merge(['admin_id' => Auth::id()], $request->only('summary', 'attended')));

            if ($appointment) {
                $nNotification = new ApplySingleNotification($appointment, 9, $application->guardian_id);
                if ($request->approved == 1) {
                    //  change application stautus to approved
                    // $application = Application::where('id', $request->application_id)->update(['status_id' => 2]);
                    $result = $this->NewStudent($application);
                    if ($result) {
                        $application->status_id = 2;
                    }
                } elseif ($request->approved == 0) {
                    //  change application stautus to rejected - no more actions can be performed
                    $application->status_id = 6;
                    $nNotification->event_id = 11;
                }
                $nNotification->fireNotification();
            }
            if ($application->save()) {

                return redirect()->back()
                    ->with('alert-success', 'تم اضافة نتيجة المقابلة بنجاح');
            }

            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة نتيجة المقابلة  ');
        } else {
            if ($request->filled('appointment_id')) {
                $meeting = ReservedAppointment::select('reserved_appointments.*', 'applications.id as application_id')
                    ->leftjoin('applications', 'applications.appointment_id', 'reserved_appointments.id')
                    ->findOrFail($request->appointment_id);

                if ($meeting) {
                    $html = view('parent.application.meetingResult', compact('meeting'))->render();
                    return response()->json([
                        'done' => true,
                        'html' => $html
                    ]);
                }
            }
        }
    }

    public function updateapplicationstatus(Request $request)
    {
        if ($request->has('application_id') && null !== $request->application_id) {
            $application = Application::findOrFail($request->application_id);
            if ($request->changeTo == 'noor' && $application->status_id == 2) {
                # update applcation statues to add_to_noor
                $application->status_id = 3;
                $message = 'تم تحويل حالة الطلب الي تم الاضافة الي نور';
            } else if ($request->changeTo == 'pending' && $application->status_id == 3) {
                # update applcation statues to add_to_peinding
                $application->status_id = 4;
                $message = 'تم اضافة الطلب الي الطلاب المقبولين وضمن قائمة الانتظار';
            } else if ($request->changeTo == 'confirm' && in_array($application->status_id, [3, 4])) {
                # update applcation statues to add_to_confirmed
                $application->status_id = 5;
                $message = 'تم اضافة الطلب الي الطلاب المقبولين وضمن قائمة الانتظار';
            } else if ($request->changeTo == 'reopen'  && $application->status_id == 6) {
                # update applcation statues to add_to_confirmed
                $application->status_id = 1;
                $message = 'تم اعادة فتح الطلب';
            } else {
                return response()->json([
                    'done' => false,
                    'message' => 'لا يمكن تحديث حالة الطلب الي الحالة المطلوبة .. حاول مرة اخري'
                ]);
            }

            if ($application->save()) {
                $application = Application::select('applications.*', 'application_statuses.status_name')
                    ->leftjoin('application_statuses', 'application_statuses.id', 'applications.status_id')->first();

                $nNotification = new ApplySingleNotification($application, 6, $application->guardian_id);
                $nNotification->fireNotification();
                # return result
                return response()->json([
                    'done' => true,
                    'message' => $message
                ]);
            }
        } else {
            return response()->json([
                'done' => false,
                'message' => 'لم يتم العثور علي الطلب .. ربما تم حذفة'
            ]);
        }
    }

    public function confirm_application(Request $request)
    {
        $application = Application::select('applications.id', 'applications.student_name', 'applications.birth_place', 'applications.national_id', 'applications.birth_date', 'applications.student_care', 'nationalities.nationality_name', 'schools.school_name', 'genders.gender_name', 'grades.grade_name', 'levels.level_name', 'plans.plan_name', 'application_statuses.status_name', 'application_statuses.color')
            ->leftjoin('nationalities', 'nationalities.id', 'applications.nationality_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->leftjoin('levels', 'levels.id', 'applications.level_id')
            ->leftjoin('plans', 'plans.id', 'applications.plan_id')
            ->leftjoin('application_statuses', 'application_statuses.id', 'applications.status_id')
            ->where('applications.id', $request->id)
            ->whereIn('applications.grade_id', $this->can_manage())
            ->whereIn('applications.status_id', [3, 4]) // only pinding or add to noor status
            ->with('meeting')
            ->firstOrFail();

        return view('parent.application.confirm', compact('application'));
    }
}
