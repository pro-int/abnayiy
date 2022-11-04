<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractTerms;
use App\Models\ParticipationReport;
use App\Models\Student;
use App\Models\StudentCall;
use App\Models\StudentTransportation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\CreatePdfFile;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    use CreatePdfFile;

    public function contracts(Request $request)
    {
        # get all contracts for all students info
        try {

            $contracts = Contract::select(
                'contracts.id',
                'student_id',
                'academic_year_id',
                'students.student_name',
                // 'plan_id',
                // 'level_id',
                // 'applied_semesters',
                // 'tuition_fees',
                // 'period_discounts',
                // 'coupon_discounts',
                // 'vat_amount',
                // 'bus_fees',
                // 'total_fees',
                // 'total_paid',
                // 'levels.level_name',
                // 'schools.school_name',
                // 'grades.grade_name',
                // 'genders.gender_name'
            )
                // ->leftjoin('levels', 'levels.id', 'contracts.level_id')
                // ->leftjoin('grades', 'grades.id', 'levels.grade_id')
                // ->leftjoin('genders', 'genders.id', 'grades.gender_id')
                // ->leftjoin('schools', 'schools.id', 'genders.school_id')
                // ->leftjoin('plans', 'plans.id', 'genders.school_id')
                ->leftjoin('students', 'students.id', 'contracts.student_id')
                ->where('students.guardian_id', Auth::id());

                if ($request->filled('student_id')) {
                    $contracts = $contracts->where('contracts.student_id',$request->student_id);
                }
    
                if ($request->filled('year_id')) {
                    $contracts = $contracts->where('academic_year_id',$request->year_id);
                }

                
                $contracts = $contracts->get();

            return $this->ApiSuccessResponse(['contracts' => $contracts]);
        } catch (\Throwable $th) {
            info($th);
            return $this->ApiErrorResponse('خطا غير متوقع اثناء استعادة المعلومات');
        }
    }

    public function getContract($contract)
    {
        # get single contract info if $reuest has id
        try {
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

            $student = Student::select('students.*', 'class_rooms.class_name', 'nationalities.nationality_name', 'class_rooms.class_name')
                ->leftjoin('contracts', 'contracts.student_id', 'students.id')
                ->leftjoin('class_rooms', 'class_rooms.id', 'contracts.class_id')
                ->leftjoin('nationalities', 'nationalities.id', 'students.nationality_id')
                ->where('students.guardian_id', Auth::id())
                ->findOrFail($contract->student_id);

            $guardian = User::select('users.*', 'countries.country_name', 'categories.category_name', 'categories.color', 'nationalities.nationality_name', 'guardians.national_id', 'guardians.city_name')
                ->leftjoin('countries', 'countries.id', 'users.country_id')
                ->leftjoin('guardians', 'guardians.guardian_id', 'users.id')
                ->leftjoin('categories', 'categories.id', 'guardians.category_id')
                ->leftjoin('nationalities', 'nationalities.id', 'guardians.nationality_id')
                ->findOrFail($student->guardian_id);

            $term = ContractTerms::find($contract->terms_id) ?? ContractTerms::where('is_default',true)->first();

            $terms = $term->content;
            $logo_url = $this->getContractTempleteImg('logo');
            $html =  view('admin.contracts.print', compact('student', 'contract', 'guardian', 'logo_url', 'terms'))->render();
            $file_name = sprintf('عقد_%s_%s.pdf', $contract->id, $student->student_name);

            $mpdf = $this->getPdf($html, 'P')->setWaterMark($this->getContractTempleteImg());
            return response($mpdf->Output($file_name, "S"), 200, ['Content-Type', 'application/pdf']);
        } catch (\Throwable $th) {
            info($th);

            return $this->ApiErrorResponse('خطا غير متوقع اثناء استعادة المعلومات');
        }
    }
}
