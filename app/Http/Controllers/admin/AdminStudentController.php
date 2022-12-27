<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\OdooIntegrationTrait;
use App\Models\Student;
use App\Http\Requests\student\StoreStudentRequest;
use App\Http\Requests\student\UpdateStudentRequest;
use App\Http\Traits\CreatePdfFile;
use App\Models\AcademicYear;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminStudentController extends Controller
{
    use CreatePdfFile, OdooIntegrationTrait;

    function __construct()
    {
        $this->middleware('permission:students-list|students-create|students-edit|students-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:students-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:students-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:students-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = null;
        $fileds = [
            'students.id',
            'students.student_name',
            'students.student_care',
            'students.national_id',
            'students.gender',
            'students.last_noor_sync',
            'students.student_name_en',
            'students.graduated',
            'students.created_at',
            'students.updated_at',
            'students.odoo_sync_status',
            'students.odoo_message',
            DB::raw('CONCAT(users.first_name, " " , users.last_name) as guardian_name'),
            'users.phone',
            'nationalities.nationality_name',
            'categories.category_name',
            'guardians.national_id as guardian_national_id',
            'categories.color',
        ];

        if ($request->filled('academic_year_id')) {
            $year = AcademicYear::findOrFail($request->academic_year_id);
            array_push(
                $fileds,
                'class_rooms.class_name',
                'plans.plan_name',
                'schools.school_name',
                'levels.level_name',
                'grades.grade_name',
                'genders.gender_name',
                'contracts.id as contract_id',
                DB::raw('CONCAT(sales_admin.first_name, " " , sales_admin.last_name) as sales_admin_name'),
            );
        }

        $students = student::select($fileds)
            ->join('users', 'users.id', 'students.guardian_id')
            ->join('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->leftjoin('nationalities', 'nationalities.id', 'students.nationality_id');


        if ($request->filled('academic_year_id')) {
            $students = $students->leftJoin('contracts', function ($query) use ($year) {
                $query->on('contracts.student_id', '=', 'students.id')
                    ->where('contracts.academic_year_id', $year->id);
            })
                ->leftjoin('plans', 'plans.id', 'contracts.plan_id')
                ->leftjoin('levels', 'levels.id', 'contracts.level_id')
                ->leftjoin('grades', 'grades.id', 'levels.grade_id')
                ->leftjoin('genders', 'genders.id', 'grades.gender_id')
                ->leftjoin('schools', 'schools.id', 'genders.school_id')
                ->leftjoin('class_rooms', 'class_rooms.id', 'contracts.class_id')
                ->leftjoin('applications', 'applications.id', 'contracts.application_id')
                ->leftjoin('users as sales_admin', 'sales_admin.id', 'applications.sales_id')
                ->whereHas('contract', function ($query) use ($year) {
                    $query->where('contracts.academic_year_id', $year->id);
                })
                ->with('contract', function ($query) use ($year) {
                    $query->where('contracts.academic_year_id', $year->id);
                });

            if ($request->filled('student_status')) {
                switch ($request->student_status) {
                    case 'new':
                        $students = $students->whereNotNull('contracts.application_id');
                        break;
                    case 'old':
                        $students = $students->whereNotNull('contracts.old_contract_id');
                        break;
                    case 'graduated':
                        $students = $students->where('students.graduated', true);
                        break;
                    default:
                        break;
                }
            }

            if ($request->filled('new_contract_status')) {
                switch ($request->new_contract_status) {
                    case 'done':
                        $students = $students->whereHas('contracts.transfare', function ($q) use ($year) {
                            $q->where('transfer_requests.status', 'complete')
                                ->where('transfer_requests.academic_year_id', $year->id);
                        });
                        break;
                    case 'underProcess':
                        $students = $students->whereHas('contracts.transfare', function ($q) use ($year) {
                            $q->whereIn('transfer_requests.status', ['new', 'pending'])
                                ->where('transfer_requests.academic_year_id', $year->id);
                        });
                        break;
                    case 'noAction':
                        $academic_year = GetAcademicYear();
                        $students = $students->whereDoesntHave('contracts', function ($q) use ($academic_year) {
                            $q->where('contracts.academic_year_id', $academic_year->id);
                        });

                        break;
                    default:
                        break;
                }
            }
        }

        if ($request->filled('search')) {
            if ($request->search[0] == '=') {
                $students = $students->where(function ($query) use ($request) {
                    $query->where('students.id', substr($request->search, 1));
                });
            } else {
                if (is_numeric($request->search)) {
                    # search only numitic values
                    $students = $students->where(function ($query) use ($request) {
                        $query->where('students.national_id', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('guardians.national_id', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('users.phone', 'LIKE', '%' . $request->search . '%');
                    });
                } else {

                    $students = $students->where(function ($query) use ($request) {
                        $query->orWhere('students.student_name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('users.first_name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('users.last_name', 'LIKE', '%' . $request->search . '%');
                    });
                }
            }
        }

        if ($request->filled('nationality_id') && is_numeric($request->nationality_id)) {
            $students = $students->where('students.nationality_id', $request->nationality_id);
        }

        if ($request->filled('category_id') && is_numeric($request->category_id)) {
            $students = $students->where('guardians.category_id', $request->category_id);
        }

        if ($request->filled('noor_status')) {
            if ($request->noor_status) {
                $students = $students->whereNotNull('students.last_noor_sync');
            } else {
                $students = $students->whereNull('students.last_noor_sync');
            }
        }


        $students = $this->fillter_students($request, $students)->orderBy('students.id', 'desc');

        if ($request->action == 'export_xlsx') {
            $students = $students->get();
            $export = new StudentsExport($students);
            return count($students) ? Excel::download($export, 'تقرير_الطلاب.xlsx') : redirect()->back()->with('alert-warning', 'لا توجد نتائج لمعاير اليحث')->withInput();
        }

        if ($request->action == 'export_pdf') {
            $students = $students->get();
            $html = view('admin.student.export', compact('students'))->render();
            $pdf = $this->getPdf($html)->setWaterMark(public_path('/assets/reportLogo45d.png'));
            return count($students) ? response($pdf->output('تقرير_الطلاب.pdf', "I"), 200, ['Content-Type', 'application/pdf']) : redirect()->back()->with('alert-warning', 'لا توجد نتائج لمعاير اليحث')->withInput();
        }

        // return $students->get()->pluck('id')->toArray();
        $students = $students->paginate(config('view.per_page', 30));

        return view('admin.student.index', compact('students', 'year'));
    }

    protected function fillter_students($request, $students)
    {
        if ($request->filled('academic_year_id')) {
            if ($request->filled('school_id') && is_numeric($request->school_id)) {
                $students = $students->where('schools.id', $request->school_id);
            }

            if ($request->filled('gender_id') && is_numeric($request->gender_id)) {
                $students = $students->where('genders.id', $request->gender_id);
            }

            if ($request->filled('grade_id') && is_numeric($request->grade_id)) {
                $students = $students->where('grades.id', $request->grade_id);
            }

            if ($request->filled('level_id') && is_numeric($request->level_id)) {
                $students = $students->where('levels.id', $request->level_id);
            }

            if ($request->filled('transportation')) {
                $students = $students->whereHas('contract.transportation');
            }

            if ($request->filled('status') && is_numeric($request->status)) {
                $students = $students->where('contracts.status', $request->status);
            }

            if ($request->filled('exam_result')) {
                if ($request->exam_result == 'null') {
                    $students = $students->whereNull('contracts.exam_result');
                } else {
                    $students = $students->where('contracts.exam_result', $request->exam_result);
                }
            }
        }

        return $students;
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
     * @param \App\Http\Requests\StorestudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorestudentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\student $student
     * @return \Illuminate\Http\Response
     */
    public function show($student)
    {
        $student = Student::select(
            'students.*',
            'guardians.guardian_id',
            'guardians.address',
            'guardians.city_name',
            'categories.category_name',
            'nationalities.nationality_name',
            DB::raw('CONCAT(users.first_name, " " , users.last_name) as guardian_name'),
            'users.phone',
            'users.email',
            'guardians.national_id as guardian_national_id'
        )
            ->join('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->join('users', 'users.id', 'guardians.guardian_id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->leftjoin('nationalities', 'nationalities.id', 'guardians.nationality_id')
            ->findOrFail($student);

        return view('admin.student.view', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\student $student
     * @return \Illuminate\Http\Response
     */
    public function edit($student)
    {
        $student = Student::select(
            'students.*',
            'guardians.guardian_id',
            'guardians.address',
            'guardians.city_name',
            'categories.category_name',
            'nationalities.nationality_name',
            DB::raw('CONCAT(users.first_name, " " , users.last_name) as guardian_name'),
            'users.phone',
            'users.email',
            'guardians.national_id as guardian_national_id'
        )
            ->join('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->join('users', 'users.id', 'guardians.guardian_id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->leftjoin('nationalities', 'nationalities.id', 'guardians.nationality_id')
            ->findOrFail($student);

        return view('admin.student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatestudentRequest $request
     * @param \App\Models\student $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatestudentRequest $request, student $student)
    {
        $student = $student->update($request->only([
            'student_name',
            'birth_date',
            'national_id',
            'birth_place',
            'student_care',
            'guardian_id',
            'allow_late_payment',
            'nationality_id'
        ]));

        if (!$student) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات الطالب ');
        }

        return redirect()->route('students.index')
            ->with('alert-success', 'تم تعديل معلومات الطالب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\student $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(student $student)
    {
        if ($student->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف الطالب ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف الطالب ');
    }

    public function storeStudentInOdoo(Request $request)
    {
        $student = Student::findOrFail($request->get('id'));
        return $this->createStudentInOdoo($student->getOdooKeys());
    }
}
