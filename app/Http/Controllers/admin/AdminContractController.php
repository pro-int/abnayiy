<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SystemConfigurationError;
use App\Exports\ContractsExport;
use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\StudentExamResultRequest;
use App\Http\Traits\ContractInstallments;
use App\Http\Traits\OdooIntegrationTrait;
use App\Models\Contract;
use App\Http\Requests\UpdatecontractRequest;
use App\Http\Traits\CreatePdfFile;
use App\Imports\StudentsResultsImport;
use App\Models\AcademicYear;
use App\Models\ContractTerms;
use App\Models\Student;
use App\Models\StudentTransportation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AdminContractController extends Controller
{
    use CreatePdfFile, OdooIntegrationTrait, ContractInstallments;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Student $student)
    {
        $contracts = Contract::select(
            'contracts.*',
            'academic_years.year_name',
            'academic_years.current_academic_year',
            'levels.level_name',
            'plans.plan_name',
            DB::raw('CONCAT(users.first_name, " " ,users.last_name) as admin_name')
        )
            ->leftjoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->leftjoin('users', 'users.id', 'contracts.admin_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('plans', 'plans.id', 'contracts.plan_id')
            ->where('student_id', $student->id)
            ->with(['transactions', 'transportation', 'files'])
            ->orderBy('contracts.id')
            ->get();

        return view('admin.student.contract.index', compact('contracts', 'student'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show($student, $contract, Request $request)
    {
        $contract = Contract::select('contracts.*', 'academic_years.year_name', 'plans.plan_name', 'contract_terms.version', 'schools.school_name', 'levels.level_name', 'grades.grade_name', 'genders.gender_name', DB::raw('CONCAT(first_name, " " ,last_name) as admin_name'))
            ->leftjoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->leftjoin('contract_terms', 'contract_terms.id', 'contracts.terms_id')
            ->leftjoin('plans', 'plans.id', 'contracts.plan_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->leftjoin('users', 'users.id', 'contracts.admin_id')
            ->with('transactions')
            ->findOrFail($contract);

        $transportation = StudentTransportation::where('contract_id', $contract->id)->select(
            'student_transportations.payment_type',
            'student_transportations.base_fees',
            'student_transportations.vat_amount',
            'student_transportations.total_fees',
            'student_transportations.expire_at',
            'transportations.transportation_type'
        )
            ->leftjoin('transportations', 'transportations.id', 'student_transportations.transportation_id')
            ->first();

        $student = Student::select('students.*', 'class_rooms.class_name', 'nationalities.nationality_name', 'class_rooms.class_name')
            ->leftjoin('contracts', 'contracts.student_id', 'students.id')
            ->leftjoin('class_rooms', 'class_rooms.id', 'contracts.class_id')
            ->leftjoin('nationalities', 'nationalities.id', 'students.nationality_id')
            ->findOrFail($student);

        $guardian = User::select('users.*', 'countries.country_name', 'categories.category_name', 'categories.color', 'nationalities.nationality_name', 'guardians.national_id', 'guardians.city_name')
            ->leftjoin('countries', 'countries.id', 'users.country_id')
            ->leftjoin('guardians', 'guardians.guardian_id', 'users.id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->leftjoin('nationalities', 'nationalities.id', 'guardians.nationality_id')
            ->findOrFail($student->guardian_id);

        if ($request->has('type')) {
            $term = ContractTerms::find($contract->terms_id);
            if (!$term) {
                throw new SystemConfigurationError('لم يتم العثور علي شروط التعاقد الخاصة بالعقد .. ربما تم حذفها من النظام');
            }
            $terms = $term->content;
            $logo_url = $this->getContractTempleteImg('logo');
            $html =  view('admin.contracts.print', compact('student', 'contract', 'guardian', 'logo_url', 'terms'))->render();
            $file_name = sprintf('عقد_%s_%s.pdf', $contract->id, $student->student_name);

            $mpdf = $this->getPdf($html, 'P')->setWaterMark($this->getContractTempleteImg());


            if ($request->type == 'view') {
                return response($mpdf->Output($file_name, "I"), 200, ['Content-Type', 'application/pdf']);
            } else {
                return $mpdf->Output($file_name, 'D');
            }
        }
        return view('admin.contracts.view', compact('student', 'contract', 'guardian', 'transportation'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy($student, Contract $contract)
    {
        if ($contract->delete()) {
            return redirect()->route('students.index')
                ->with('alert-success', 'تم حذف التعاقد  بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف التعاقد ولي الامر ');
    }

    public function getAllContracts(Request $request)
    {
        $contracts = Contract::select(
            'contracts.*',
            'academic_years.year_name',
            'students.student_name',
            'students.id as studentCode',
            'students.national_id as studentNationalId',
            'students.guardian_id',
            'users.phone',
            'contract_terms.version',
            'users.id as guardianCode',
            'guardians.national_id as guardianNationalId',
            DB::raw('CONCAT(users.first_name, " " ,users.last_name) as guardianName'),
            DB::raw('CONCAT(admins.first_name, " " ,admins.last_name) as admin_name')
        )
            ->join('students', 'students.id', 'contracts.student_id')
            ->join('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->join('users', 'users.id', 'students.guardian_id')
            ->join('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->leftjoin('users as admins', 'admins.id', 'contracts.admin_id')
            ->leftjoin('contract_terms', 'contract_terms.id', 'contracts.terms_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->orderBy('contracts.id', 'DESC');


        if ($request->filled('search')) {
            $contracts = $contracts->where(function ($query) use ($request) {
                $query->orWhere('students.student_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('users.first_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('users.last_name', 'LIKE', '%' . $request->search . '%');
            });
        }
        if ($request->filled('search_number')) {
            $contracts = $contracts->where(function ($query) use ($request) {
                $query->where('students.national_id', 'LIKE', '%' . $request->search_number . '%')
                    ->orWhere('guardians.national_id', 'LIKE', '%' . $request->search_number . '%')
                    ->orWhere('users.phone', 'LIKE', '%' . $request->search_number . '%');
            });
        }

        if ($request->action == 'export_xlsx') {
            $contracts = $this->filterContracts($request, $contracts)->orderBy('contracts.id')->get();
            $t = new ContractsExport($contracts);
            return Excel::download($t, 'تقرير_التعاقدات.xlsx');
        }

        $contracts = $this->filterContracts($request, $contracts)->orderBy('contracts.id')->paginate(config('view.per_page', 30));
        return view('admin.contracts.index', compact('contracts'));
    }

    protected function filterContracts(Request $request, $contracts)
    {

        if ($request->filled('date_to')) {
            $contracts = $contracts->whereDate('contracts.created_at', '<=', $request->date_to);
        }

        if ($request->filled('date_from')) {
            $contracts = $contracts->whereDate('contracts.created_at', '>=', $request->date_from);
        }

        if ($request->filled('school_id') && is_numeric($request->school_id)) {
            $contracts = $contracts->where('schools.id', $request->school_id);
        }

        if ($request->filled('gender_id') && is_numeric($request->gender_id)) {
            $contracts = $contracts->where('genders.id', $request->gender_id);
        }

        if ($request->filled('grade_id') && is_numeric($request->grade_id)) {
            $contracts = $contracts->where('grades.id', $request->grade_id);
        }

        if ($request->filled('level_id') && is_numeric($request->level_id)) {
            $contracts = $contracts->where('levels.id', $request->level_id);
        }

        if ($request->filled('level_id') && is_numeric($request->level_id)) {
            $contracts = $contracts->where('levels.id', $request->level_id);
        }

        if ($request->filled('search_code')) {
            $term = 'contracts.id';

            switch ($request->search_code_type) {
                case 'user':
                    $term = 'users.id';
                    break;
                case 'student':
                    $term = 'students.id';
                    break;
                default:
                    break;
            }

            $contracts = $contracts->where(function ($query) use ($request, $term) {
                $query->where($term, $request->search_code);
            });
        }
        if ($request->filled('academic_year_id') && is_numeric($request->academic_year_id)) {
            $contracts = $contracts->where('academic_years.id', $request->academic_year_id);
        }
        return $contracts;
    }

    public function showStudentExsamResutls()
    {
        return view('admin.contracts.exam_results');
    }

    /**
     * store student results.
     *
     * @param  \App\Http\Requests\Contract\StudentExamResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStudentExsamResutls(StudentExamResultRequest $request)
    {

        try {
            $import = new StudentsResultsImport($request->academic_year_id, $request->exam_result, $request->ignore_old_result);
            $import->import($request->file('sheet_path'));
            $skipped_students = $import->skipped_students;
            $total_students = $import->total_students;

            $class = 'warning';

            if (!$total_students) {
                $message = 'لم يتم العثور علي طلاب في الملف المرفق';
            } else {
                if (!empty($skipped_students)) {
                    $message = sprintf('لم يتم العثور علي %s طالب/ة من اصل %s طالب/ة', count($skipped_students), $total_students);
                } else {
                    $message = 'تم تحديث نتيجة الطلاب بنجاح ';
                    $class = 'success';
                }
            }

            session()->flash("alert-$class", $message);

            return view('admin.contracts.exam_results', compact('skipped_students'));
        } catch (\Throwable $th) {
            Log::debug($th);
            return back()->with('alert-danger', 'خطا اثناء قراءة ملف النتائج .. تأكد من عدم تغيير تنسيق الملف الصادر من نظام نور')->withInput();
        }
    }

    public function show_student_report(Request $request)
    {
        $year = $request->filled('old_academic_year_id') ? AcademicYear::findOrFail($request->old_academic_year_id) : GetAcademicYear();

        $students = student::select(
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
            DB::raw('CONCAT(users.first_name, " " , users.last_name) as guardian_name'),
            'users.phone',
            'nationalities.nationality_name',
            'categories.category_name',
            'guardians.national_id as guardian_national_id',
            'categories.color',
            'class_rooms.class_name',
            'plans.plan_name',
            'schools.school_name',
            'levels.level_name',
            'grades.grade_name',
            'genders.gender_name',
            'contracts.id as contract_id',
            DB::raw('CONCAT(sales_admin.first_name, " " , sales_admin.last_name) as sales_admin_name')
        )
            ->join('users', 'users.id', 'students.guardian_id')
            ->join('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->leftjoin('nationalities', 'nationalities.id', 'students.nationality_id')
            ->leftJoin('contracts', function ($query) use ($year) {
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

        // if ($request->filled('student_status')) {
        //     switch ($request->student_status) {
        //         case 'new':
        //             $students = $students->whereNotNull('contracts.application_id');
        //             break;
        //         case 'old':
        //             $students = $students->whereNotNull('contracts.old_contract_id');
        //             break;
        //         case 'graduated':
        //             $students = $students->where('students.graduated', true);
        //             break;
        //         default:
        //             break;
        //     }
        // }

        // if ($request->filled('new_contract_status')) {
        //     switch ($request->new_contract_status) {
        //         case 'done':
        //             $students = $students->whereHas('contracts.transfare', function ($q) use ($year) {
        //                 $q->where('transfer_requests.status', 'complete')
        //                     ->where('transfer_requests.academic_year_id', $year->id);
        //             });
        //             break;
        //         case 'underProcess':
        //             $students = $students->whereHas('contracts.transfare', function ($q) use ($year) {
        //                 $q->whereIn('transfer_requests.status', ['new', 'pending'])
        //                     ->where('transfer_requests.academic_year_id', $year->id);
        //             });
        //             break;
        //         case 'noAction':
        //             $academic_year = GetAcademicYear();
        //             $students = $students->whereDoesntHave('contracts', function ($q) use ($academic_year) {
        //                 $q->where('contracts.academic_year_id', $academic_year->id);
        //             });

        //             break;
        //         default:
        //             break;
        //     }
        // }


        // if ($request->filled('search')) {
        //     if ($request->search[0] == '=') {
        //         $students = $students->where(function ($query) use ($request) {
        //             $query->where('students.id', substr($request->search, 1));
        //         });
        //     } else {
        //         if (is_numeric($request->search)) {
        //             # search only numitic values
        //             $students = $students->where(function ($query) use ($request) {
        //                 $query->where('students.national_id', 'LIKE', '%' . $request->search . '%')
        //                     ->orWhere('guardians.national_id', 'LIKE', '%' . $request->search . '%')
        //                     ->orWhere('users.phone', 'LIKE', '%' . $request->search . '%');
        //             });
        //         } else {

        //             $students = $students->where(function ($query) use ($request) {
        //                 $query->orWhere('students.student_name', 'LIKE', '%' . $request->search . '%')
        //                     ->orWhere('users.first_name', 'LIKE', '%' . $request->search . '%')
        //                     ->orWhere('users.last_name', 'LIKE', '%' . $request->search . '%');
        //             });
        //         }
        //     }
        // }

        // if ($request->filled('nationality_id') && is_numeric($request->nationality_id)) {
        //     $students = $students->where('students.nationality_id', $request->nationality_id);
        // }

        // if ($request->filled('category_id') && is_numeric($request->category_id)) {
        //     $students = $students->where('guardians.category_id', $request->category_id);
        // }

        // if ($request->filled('noor_status')) {
        //     if ($request->noor_status) {
        //         $students = $students->whereNotNull('students.last_noor_sync');
        //     } else {
        //         $students = $students->whereNull('students.last_noor_sync');
        //     }
        // }


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
            return count($students) ?  response($pdf->output('تقرير_الطلاب.pdf', "I"), 200, ['Content-Type', 'application/pdf']) : redirect()->back()->with('alert-warning', 'لا توجد نتائج لمعاير اليحث')->withInput();
        }

        // return $students->get()->pluck('id')->toArray();
        $students = $students->paginate(config('view.per_page', 30));

        return view('admin.student.contract.report', compact('students', 'year'));
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

    public function storeInvoiceInOdoo(Request $request)
    {
        $contract = Contract::findOrFail($request->get('id'));
        $this->setOdooKeys($contract);
        return $this->createInvoiceInOdoo($this->odooIntegrationKeys, $this->odooIntegrationTransportationKey, $contract->id,$contract->odoo_sync_study_status, $contract->odoo_sync_transportation_status);
    }
}
