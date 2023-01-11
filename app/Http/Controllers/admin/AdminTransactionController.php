<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;

use App\Models\Transaction;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransactionController extends Controller
{
    protected LogHelper $logHelper;

    function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
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
        $contract = Contract::select('contracts.id', 'students.student_name', 'academic_years.year_name', 'contracts.student_id', 'contracts.status')
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->leftjoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->with('transportation')
            ->findOrFail($request->contract);

        $transactions = transaction::select('transactions.*', 'periods.period_name', 'categories.category_name', 'categories.color', DB::raw('CONCAT(users.first_name, " " ,users.last_name) as admin_name'))
            ->leftjoin('periods', 'periods.id', 'transactions.period_id')
            ->leftjoin('categories', 'categories.id', 'transactions.category_id')
            ->leftjoin('users', 'users.id', 'transactions.admin_id')

            ->where('transactions.contract_id', $contract->id)
            ->orderBy('transactions.id')
            ->get();

        return view('admin.student.contract.transaction.index', compact('transactions', 'contract'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoretransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param   \Illuminate\Http\Request $request
     * @return  \App\Models\PaymentAttempt  $PaymentAttempts
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentAttempt  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
    }
}
