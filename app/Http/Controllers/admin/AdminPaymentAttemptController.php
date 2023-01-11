<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\OdooIntegrationTrait;
use App\Models\PaymentAttempt;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ConfirmTransactionRequest;
use App\Http\Requests\StorePaymentAttempRequest;
use App\Http\Traits\CreatePdfFile;
use App\Http\Traits\TransactionTrait;
use App\Models\AcademicYear;
use App\Models\Contract;
use App\Models\PaymentMethod;
use finfo;
use Gtech\AbnayiyNotification\ApplySingleNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdminPaymentAttemptController extends Controller
{
    use TransactionTrait, CreatePdfFile, OdooIntegrationTrait;

    function __construct()
    {
        $this->middleware('permission:accuonts-list|accuonts-create|accuonts-edit|accuonts-delete', ['only' => ['index', 'store', 'UnConfirmedPayment']]);
        $this->middleware('permission:accuonts-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:accuonts-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:accuonts-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Student $student, $contract, $transaction, PaymentAttempt $attemptum)
    {
        $transaction = $this->Get_transactions($transaction);
        $year = AcademicYear::where('current_academic_year', 1)->first();
        $contractAcademicYear = Contract::select("academic_year_id")->where("id",$contract)->first();

        $PaymentAttempts = PaymentAttempt::select(
            'payment_attempts.id',
            'payment_attempts.approved',
            'payment_attempts.reference',
            'payment_attempts.created_at',
            'payment_attempts.updated_at',
            'payment_attempts.attach_pathh',
            'payment_attempts.requested_ammount',
            'payment_attempts.received_ammount',
            'payment_attempts.payment_method_id',
            'payment_attempts.transaction_id',
            'payment_attempts.coupon',
            'payment_attempts.approved',
            'payment_attempts.coupon_discount',
            'payment_attempts.odoo_sync_status',
            'payment_attempts.odoo_message',
            'payment_attempts.odoo_sync_delete_status',
            'payment_attempts.odoo_delete_message',
            'periods.period_name',
            'payment_attempts.period_discount',
            'payment_attempts.transaction_id',
            'payment_methods.method_name',
            'banks.bank_name',
            'payment_networks.network_name',
            'payment_networks.account_number as network_account_number',
            'banks.account_number',
            DB::raw('CONCAT(admins.first_name, " " ,admins.last_name) as admin_name'),
        )
            ->leftjoin('payment_methods', 'payment_methods.id', 'payment_attempts.payment_method_id')
            ->leftjoin('banks', 'banks.id', 'payment_attempts.bank_id')
            ->leftjoin('payment_networks', 'payment_networks.id', 'payment_attempts.payment_network_id')
            ->leftjoin('periods', 'periods.id', 'payment_attempts.period_id')
            ->leftjoin('users as admins', 'admins.id', 'payment_attempts.admin_id')
            ->where('transaction_id', $transaction->id)
            ->orderBy('payment_attempts.id')
            ->get();

        return view('admin.student..contract.transaction.attempt.index', compact('PaymentAttempts', 'student', 'contract', 'transaction','year','contractAcademicYear'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $student, $contract, $transaction)
    {

        $transaction =  $this->Get_transactions($transaction);

        if ($msg = $this->CheckNewPaymentStatus($transaction->academic_year_id, $contract)) {
            return redirect()->back()->with('alert-danger', $msg);
        }

        $coupon_code = $request->filled('coupon_code') ? $request->coupon_code : null;

        $transaction_info = $this->getTransactionAmounts($transaction, $coupon_code);

        return view('admin.student.contract.transaction.attempt.create', compact('transaction', 'student', 'contract', 'transaction_info'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorenationalityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentAttempRequest $request, Student $student, $contract, $transaction)
    {
        $transaction = $this->Get_transactions($transaction);

        if ($msg = $this->CheckNewPaymentStatus($transaction->academic_year_id, $contract)) {
            return redirect()->back()->with('alert-danger', $msg);
        }

        $PaymentAttempt = $this->CreatePaymentAttempt($transaction, $request, [], $student->guardian_id);
        if ($PaymentAttempt) {

            if ($request->filled('is_confirmed')) {

                $amount = $request->requested_ammount ?? $transaction->residual_amount;
                $request->request->add(['requested_ammount' => $amount]); //add request

                if (!$this->confirmPaymentAttempt($PaymentAttempt, $transaction, $request)) {
                    return redirect()->back()->with('alert-danger', 'خطأ اثناء محاولة تأكيد الدفعة');
                }
            }

            return redirect()->route('students.contracts.transactions.attempts.index', ['student' => $student, 'contract' => $contract, 'transaction' => $transaction->id])
                ->with('alert-success', 'تم اضافه الدفعه بنجاح');
        } else {
            return redirect()->back()->with('alert-danger', 'خطأ اثناء تسجيل الدفعة');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentAttempt  $attempt
     * @return \Illuminate\Http\Response
     */
    public function show($student, $contract, $transaction, $attempt)
    {
        $attempt = PaymentAttempt::select(
            'payment_attempts.*',
            'transactions.installment_name',
            'transactions.transaction_type',
            'payment_methods.method_name',
            DB::raw('CONCAT(users.first_name, " " ,users.last_name) as guardian_name'),
            DB::raw('CONCAT(admins.first_name, " " ,admins.last_name) as admin_name'),
            'students.national_id',
            'students.student_name',
            'guardians.national_id as guardian_national_id',
            'nationalities.nationality_name',
            'academic_years.year_name',
            'schools.school_name',
            'levels.level_name',
            'grades.grade_name',
            'transactions.residual_amount',
            'students.guardian_id',
            'banks.bank_name',
            'contracts.id as contract_id'
        )
            ->leftJoin('transactions', 'transactions.id', 'payment_attempts.transaction_id')
            ->leftJoin('contracts', 'contracts.id', 'transactions.contract_id')
            ->leftJoin('students', 'students.id', 'contracts.student_id')
            ->leftJoin('users', 'users.id', 'students.guardian_id')
            ->leftJoin('users as admins', 'admins.id', 'payment_attempts.admin_id')
            ->leftJoin('banks', 'banks.id', 'payment_attempts.bank_id')
            ->leftJoin('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->leftJoin('nationalities', 'nationalities.id', 'guardians.nationality_id')
            ->leftJoin('payment_methods', 'payment_methods.id', 'payment_attempts.payment_method_id')
            ->leftJoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->where('payment_attempts.approved', true)
            ->findOrFail($attempt);

        $students = Student::where('guardian_id', $attempt->guardian_id)->pluck('id')->toArray();

        $contracts = Contract::select('contracts.*', 'students.student_name', 'academic_years.year_name', DB::raw('sum(contracts.total_fees - contracts.total_paid) as residual_amount'))
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->leftjoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->groupBy('contracts.id')
            ->whereIn('student_id', $students)->get();

        $content = view('admin.student.contract.transaction.attempt.receipt', compact('attempt', 'contracts'))->render();
        $mpdf = $this->getPdf($content, 'P')->setWaterMark(public_path('/assets/alnoballaLogo2.jpeg'),0.1);

        return  response($mpdf->Output(sprintf('ايصال_سداد_%s_%s.pdf', $attempt->contract_id, str_replace(' ', '_', $attempt->student_name)), "I"), 200, ['Content-Type', 'application/pdf']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentAttempt $attempt)
    {
        return view('admin.nationality.edit', compact('nationality'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatenationalityRequest  $request
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentAttempt  $attempt
     * @return \Illuminate\Http\Response
     */
    public function destroy($student, Contract $contract, transaction $transaction, PaymentAttempt $attempt)
    {
            // check contract status - not closed
        ;
        if ($msg = $this->CheckNewPaymentStatus($contract->academic_year_id, $contract->id)) {
            return redirect()->back()->with('alert-danger', $msg);
        }

        $result = $this->deletePaymentInOdoo(["payment_code_abnai" => $attempt->id]);

        if(!$result['status']){
            return redirect()->back()
                ->with('alert-danger', $result['message']);
        }

        if ($attempt->delete()) {
            $transaction->update_transaction($attempt);

            return redirect()->route('students.contracts.transactions.index', [$student, $contract, $transaction])
                ->with('alert-success', 'تم حذف الدقغة ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'فشل حذف الدقغة  ');
    }

    public function confirmPaymentAttempt($PaymentAttempt, $transaction, $request)
    {
        $result = DB::transaction(function () use ($PaymentAttempt, $transaction, $request) {

            $received_ammount =  $request->filled('received_ammount') ? $request->received_ammount : $PaymentAttempt->requested_ammount;

            if ($received_ammount <> $PaymentAttempt->requested_ammount) {
                $transaction_data =  $this->getTransactionAmounts($transaction, $PaymentAttempt->coupon, $received_ammount);

                $PaymentAttempt->coupon_discount = $transaction_data['coupon_discount'];
                $PaymentAttempt->period_discount = $transaction_data['new_period_discount'];
            }

            $PaymentAttempt->approved = 1;
            $PaymentAttempt->admin_id = Auth::id();
            $PaymentAttempt->received_ammount = $received_ammount;

            if ($PaymentAttempt->save()) {
                if ($request->has('notifyuser') && $request->notifyuser) {
                    $nNotification = new ApplySingleNotification($PaymentAttempt, 3, $transaction->guardian_id);
                    $nNotification->fireNotification();
                }

                if (!empty($PaymentAttempt->coupon)) {
                    $this->UpdatecouponUsage($PaymentAttempt->coupon);
                }
                return $transaction->update_transaction();
            }
        });

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ConfirmTransactionRequest  $request
     * @param  \App\Models\PaymentAttempt  $paymentAttempt
     * @return \Illuminate\Http\Response
     */
    public function confirmTransaction(ConfirmTransactionRequest $request)
    {

        try {
            // find payentattempet
            $paymentAttempt = PaymentAttempt::findOrFail($request->paymentAttempt_id);
            $transaction = $this->Get_transactions($paymentAttempt->transaction_id);
            $this->CheckNewPaymentStatus($transaction->academic_year_id, $transaction->contract_id);

            if ($this->confirmPaymentAttempt($paymentAttempt, $transaction, $request)) {
                return redirect()->back()
                    ->with('alert-success', 'تم تأكيد الدفعة بنجاح');
            }
            return redirect()->back()
                ->with('alert-danger', 'فشل تأكيد الدقغة .. رجاء المحاولة مرة اخري');
        } catch (\Throwable $th) {
            Log::debug($th);
            return redirect()->back()
                ->with('alert-danger', 'فشل تأكيد الدقغة .. رجاء المحاولة مرة اخري');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @param  \App\Models\PaymentAttempt  $paymentAttempt
     * @return \Illuminate\Http\Response
     */
    public function refuseTransaction(Request $request)
    {
        $paymentAttempt = PaymentAttempt::findOrFail($request->paymentAttempt_id);


        $paymentAttempt->approved = 2;
        $paymentAttempt->reason = $request->reason;
        $paymentAttempt->admin_id = Auth::id();

        if ($paymentAttempt->save()) {
            if ($request->input('notifyuser') == 1 && $request->filled('reason')) {

                $nNotification = new ApplySingleNotification($paymentAttempt, 4);
                $nNotification->fireNotification();
                // Mobile::Send_text_msg($request->reason, $paymentAttempt->guardian_id);
            }
            return redirect()->back()
                ->with('alert-success', 'تم رفض الدفعة بنجاح');
        }


        return redirect()->back()
            ->with('alert-danger', 'تم رفض الدفعة بنجاح');
    }

    public function UnConfirmedPayment()
    {

        $PaymentAttempts = PaymentAttempt::select('payment_attempts.id', 'payment_attempts.requested_ammount', 'payment_attempts.created_at', 'payment_attempts.updated_at', 'plans.plan_name', 'students.student_name', 'contracts.student_id', 'contracts.id as contract_id', 'transactions.id as transaction_id')
            ->leftjoin('transactions', 'transactions.id', 'payment_attempts.transaction_id')
            ->leftjoin('contracts', 'contracts.id', 'transactions.contract_id')
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->leftjoin('plans', 'plans.id', 'contracts.plan_id')
            ->where('payment_attempts.approved', 0)
            ->whereIn('payment_attempts.payment_method_id', PaymentMethod::where('require_approval', 1)->pluck('id')->toArray())
            ->distinct('contracts.id')
            ->get();

        return view('admin.student..contract.transaction.attempt.view', compact('PaymentAttempts'));
    }

    protected function CheckNewPaymentStatus(int $academic_year_id, int $contract_id)
    {
       $contract = Contract::select('contracts.id', 'levels.next_level_id', 'contracts.status','students.allow_late_payment')
        ->join('levels', 'levels.id', 'contracts.level_id')
        ->join('students', 'students.id', 'contracts.student_id')
        ->findOrFail($contract_id);

        if (! $contract->allow_late_payment) {
            $year = AcademicYear::findOrfail($academic_year_id);
            // check contract status - not closed
            if (!$year->fiscalYearStatus() && $contract->next_level_id) {
                # refuse to enter page if theres next level id , so student can
                return sprintf('تنتهي السنة المالية لهذا التعاقد في %s ولا يمكن او حذف اي دفعات اخري بعد هذا التاريخ', $year->fiscal_year_end->format('d-m-Y'));
            }

            if ($contract->status == 2 && $contract->next_level_id) {
                return sprintf('تم اغلاق هذا التعاقد ربما يكون الطالب قد ترم ترحيلة الي العام الدراسي التالي او ان ولي الامر قام بتقديم طلب تجديد تعاقد ', $year->fiscal_year_end->format('d-m-Y'));
            }
        }
    }

    public function storePaymentInOdoo(Request $request)
    {
        $payment = PaymentAttempt::findOrFail($request->get('id'));

        return $this->createPaymentInOdoo($payment->getOdooKeys(), $payment->id);

    }

    public function storeInversePaymentInOdoo(Request $request)
    {
        $payment = PaymentAttempt::findOrFail($request->get('id'));
        $transaction = Transaction::findOrFail($payment->transaction_id);
        $contract = Contract::findOrFail($transaction->contract_id);
        if($transaction->transaction_type == "withdrawal" && $payment->requested_ammount >= 0
            && $contract->odoo_sync_update_invoice_status == 0){
            return $this->updateInvoiceInOdoo(["invoice_code_abnai" => $contract->id, "price_unit" => $contract->total_fees]);
        }elseif ($transaction->transaction_type == "withdrawal" && $payment->requested_ammount < 0
                && ($contract->odoo_sync_update_invoice_status == 0 || $contract->odoo_sync_inverse_journal_status == 0)){
            $this->createInverseTransactionInOdoo($contract, abs($payment->requested_ammount));
            return $this->updateInvoiceInOdoo(["invoice_code_abnai" => $contract->id, "price_unit" => $contract->total_fees]);
        }
    }

}
