<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Exports\GuardianDebtDetailsExport;
use App\Exports\GuardianDebtsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\StudentDebtsRequest;
use App\Imports\StudentsDebtsImport;
use App\Models\Contract;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AdminGuardianDebtController extends Controller
{
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
        $debts =  DB::table('contracts')
            ->select(DB::raw('CONCAT(users.first_name, " " ,users.last_name) as guardian_name'), 'users.phone', DB::raw('sum(contracts.total_fees - contracts.total_paid) as total_debt'), 'students.guardian_id')
            ->leftJoin('students', 'students.id', '=', 'contracts.student_id')
            ->leftJoin('users', 'users.id', '=', 'students.guardian_id')
            ->join('guardians', 'guardians.guardian_id', '=', 'students.guardian_id')
            ->whereIn('contracts.id', function ($query) {
                $query->from('contracts')
                ->select(DB::raw('max(contracts.id) as id'))
                    ->groupBy('contracts.student_id')->pluck('id')->toArray();
            })
            ->groupBy('students.guardian_id');

            
            if ($request->filled('with_current_year_fees')) {
                $debts = $debts->where('transactions.transaction_type', '=', 'debt');
            }

        if ($request->has('search') && !empty($request->search)) {
            if ($request->search[0] == '=') {
                $debts = $debts->where('users.id', substr($request->search, 1));
            } else {
                if (is_numeric($request->search)) {
                    # search only numitic values
                    $debts = $debts->where(function ($query) use ($request) {
                        $query->Where('guardians.national_id', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('users.phone', 'LIKE', '%' . $request->search . '%');
                    });
                } else {
                    $debts = $debts->where(function ($query) use ($request) {
                        $query->Where(DB::raw("CONCAT(users.first_name,' ',users.last_name)"), 'LIKE', "%" . $request->search . "%");
                    });
                }
            }
        }

        if ($request->action == 'export_xlsx') {
            $expoert = new GuardianDebtsExport($debts);
            return Excel::download($expoert, 'مديونيات_اولياء_الأمور.xlsx');
        }

        $debts = $debts->get();

        return view('admin.users.guardian.debts.index', compact('debts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.guardian.debts.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Contract\StudentDebtsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentDebtsRequest $request)
    {
        try {
            $import = new StudentsDebtsImport($request->academic_year_id);
            $import->import($request->file('sheet_path'));
            $skipped_students = $import->skipped_students;
            $total_students = $import->total_students;
            $updated_students = $import->updated_students;

            $class = 'warning';

            if (!$total_students) {
                $message = 'لم يتم العثور علي طلاب في الملف المرفق';
            } else {
                if (!empty($skipped_students)) {
                    $message = sprintf('لم يتم العثور علي %s طالب/ة من اصل %s طالب/ة', count($skipped_students), $total_students);
                } else {
                    $message = sprintf('تم استيراد مديونيات  %s طالب/ة من اصل %s طالب/ة', count($updated_students), $total_students);
                    $class = 'success';
                }
            }

            session()->flash("alert-$class", $message);

            return view('admin.users.guardian.debts.create', compact('skipped_students'));
        } catch (\Throwable $th) {
            Log::debug($th);
            return back()->with('alert-danger', 'خطا اثناء قراءة ملف المديونيات .. رجاء التأكد من تنسيق الملف')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $debt)
    {
        $students = Student::where('guardian_id', $debt->id)->pluck('student_name', 'id')->toArray();
        
        $transactions =  Transaction::select('transactions.id', 'transactions.installment_name', 'transactions.contract_id', 'students.student_name', 'students.national_id', 'transactions.vat_amount', 'students.id as student_id', 'academic_years.year_name', 'students.guardian_id', 'users.phone', 'users.email', 'debt_academic_years.year_name as debt_year_name', 'transactions.created_at', 'transactions.amount_after_discount', 'transactions.residual_amount', 'transactions.paid_amount')
            ->leftJoin('contracts', 'contracts.id', '=', 'transactions.contract_id')
            ->leftJoin('students', 'students.id', '=', 'contracts.student_id')
            ->leftJoin('users', 'users.id', '=', 'students.guardian_id')
            ->leftJoin('academic_years', 'academic_years.id', '=', 'contracts.academic_year_id')
            ->leftJoin('academic_years as debt_academic_years', 'debt_academic_years.id', '=', 'transactions.debt_year_id')
            ->where('students.guardian_id', $debt->id)
            ->where('transactions.residual_amount', '>', 0)
            ->whereIn('transactions.contract_id', function ($query) {
                $query->from('contracts')
                    ->select(DB::raw('max(contracts.id) as id'))
                    ->groupBy('contracts.student_id');
            });

            if ($request->filled('with_current_year_fees')) {
                $transactions = $transactions->where('transactions.transaction_type', '=', 'debt');
            }

        $file_name = 'مديونيات_ولي_الأمر; ' . $debt->getFullName('_');

        if ($request->filled('student_id')) {
            $transactions = $transactions->where('students.id', $request->student_id);
            $file_name = 'مديونيات_الطالب_' . $students[$request->student_id];
        }

        if ($request->action == 'export_xlsx') {
            $expoert = new GuardianDebtDetailsExport($transactions, $debt, $students, $request->student_id ?? null);
            return Excel::download($expoert, $file_name  . '.xlsx');
        }

        $transactions = $transactions->get();

        return view('admin.users.guardian.debts.show', compact('transactions', 'debt', 'students'));
    }
}
