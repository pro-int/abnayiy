<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Exports\PaymentsExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\CreatePdfFile;
use App\Models\AcademicYear;
use App\Models\PaymentAttempt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminAccountsController extends Controller
{
    use CreatePdfFile;

    function __construct()
    {
        $this->middleware('permission:accuonts-list|accuonts-create|accuonts-edit|accuonts-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:accuonts-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:accuonts-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:accuonts-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filled('academic_year_id')) {
            $year = AcademicYear::findOrFail($request->academic_year_id);
        } else {
            $year = $this->GetAcademicYear();
        }

        $PaymentAttempts = PaymentAttempt::select(
            'payment_attempts.id',
            'payment_attempts.created_at',
            'payment_attempts.updated_at',
            'payment_attempts.attach_pathh',
            'payment_attempts.received_ammount',
            'payment_attempts.payment_method_id',
            'payment_attempts.transaction_id',
            'payment_methods.method_name',
            'banks.bank_name',
            'banks.account_number',
            'students.student_name',
            'academic_years.year_name',
            'transactions.installment_name',
            'guardians.national_id',
            'schools.school_name',
            'levels.level_name',
            'grades.grade_name',
            'payment_networks.network_name',
            'payment_networks.account_number as network_account_number',
            'genders.gender_name',
            'plans.plan_name',
            DB::raw('CONCAT(admins.first_name, " " ,admins.last_name) as admin_name'),
            DB::raw('CONCAT(parants.first_name, " " ,parants.last_name) as guardian_name'),
        )
            ->leftjoin('payment_methods', 'payment_methods.id', 'payment_attempts.payment_method_id')
            ->leftjoin('banks', 'banks.id', 'payment_attempts.bank_id')
            ->leftjoin('payment_networks', 'payment_networks.id', 'payment_attempts.payment_network_id')
            ->leftjoin('transactions', 'transactions.id', 'payment_attempts.transaction_id')
            ->leftjoin('contracts', 'contracts.id', 'transactions.contract_id')
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->leftjoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->leftjoin('users as admins', 'admins.id', 'payment_attempts.admin_id')
            ->leftjoin('users as parants', 'parants.id', 'students.guardian_id')
            ->leftjoin('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->leftjoin('plans', 'plans.id', 'contracts.plan_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')

            ->orderBy('payment_attempts.id')
            ->where('payment_attempts.approved', 1)
            ->where('payment_attempts.received_ammount', '>', 0)
            ->where('contracts.academic_year_id', $year->id);

        if ($request->filled('method_id')) {
            $PaymentAttempts = $PaymentAttempts->where('payment_attempts.payment_method_id', $request->method_id);
        }


        if ($request->filled('date_from')) {
            $PaymentAttempts = $PaymentAttempts->whereDate('payment_attempts.created_at', '>=', $request->date_from);
            $date_from = Carbon::parse($request->date_from)->format('d-m-Y');
        } else {
            $date_from = 'بداية العام';
        }

        if ($request->filled('date_to')) {
            $PaymentAttempts = $PaymentAttempts->whereDate('payment_attempts.created_at', '<=', $request->date_to);
            $date_to = Carbon::parse($request->date_to)->format('d-m-Y');
        } else {
            $date_to = 'نهاية العام';
        }

        $file_name = sprintf('حركة_الصندوق من_%s_الي_%s_%s', $date_from, $date_to, str_replace('/', '-', $year->year_name));
        if ($request->action == 'export_xlsx') {
            $PaymentAttempts = $PaymentAttempts->get();
            $export = new PaymentsExport($PaymentAttempts, $date_from, $date_to, $year->year_name);
            return count($PaymentAttempts) ? Excel::download($export, $file_name . '.xlsx') : redirect()->back()->with('alert-warning', 'لا توجد نتائج لمعاير اليحث')->withInput();
        }

        if ($request->action == 'export_pdf') {
            $PaymentAttempts = $PaymentAttempts->get();
            $year_name = $year->year_name;
            $html = view('admin.accounts.export', compact('PaymentAttempts', 'date_from', 'date_to', 'year_name'))->render();
            $pdf = $this->getPdf($html)->setWaterMark(public_path('/assets/reportLogo45d.png'));
            return count($PaymentAttempts) ?  response($pdf->output($file_name . '.pdf', "I"), 200, ['Content-Type', 'application/pdf']) : redirect()->back()->with('alert-warning', 'لا توجد نتائج لمعاير اليحث')->withInput();
        }

        $sum_payments = $PaymentAttempts->sum('received_ammount');

        $PaymentAttempts = $PaymentAttempts->paginate(config('view.PER_PAGE',30));
        return view('admin.accounts.index', compact('PaymentAttempts', 'year', 'date_to', 'date_from', 'sum_payments'));
    }
}
