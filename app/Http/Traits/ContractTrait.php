<?php

namespace App\Http\Traits;

use App\Exceptions\SystemConfigurationError;
use App\Helpers\FeesCalculatorClass;
use App\Helpers\Helpers;
use App\Helpers\TuitionFeesClass;
use App\Models\AcademicYear;
use App\Models\Contract;
use App\Models\PaymentAttempt;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\TransferRequest;
use App\Models\User;
use Carbon\Carbon;
use Gtech\AbnayiyNotification\ApplySingleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait ContractTrait
{
    use TransactionTrait, ContractTransportation;

    /**
     * Create New Contract For student
     * @param array $contractArray
     * @param \App\Models\Student|int $student
     * @return \App\Models\Contract $contract
     */
    public function CreateNewContract($contractArray, $student , $contract_status = 0): Contract
    {
        $student = $student instanceof Student ? $student : Student::findOrFail($student);

        return Contract::create([
            'student_id' => $student->id,
            'application_id' => $contractArray['application_id'] ?? null,
            'academic_year_id' => $contractArray['academic_year_id'],
            'plan_id' => $contractArray['plan_id'],
            'level_id' => $contractArray['level_id'],
            'applied_semesters' => $contractArray['applied_semesters'], //->pluck('id'),
            'tuition_fees' => 0,
            'vat_rate' => 0,
            'vat_amount' => 0,
            'debt' => 0,
            'total_fees' => 0,
            'terms_id' => current_contract_term()->id,
            'status' => $contract_status,
            'old_contract_id' => $contractArray['old_contract_id'],
            'admin_id' => $contractArray['user_id']
        ]);
    }

    /**
     * calculate contract debt and minimum payment
     * @param \App\Models\Contract $contract
     * @param \App\Models\AcademicYear $year optional
     * @return array $data[]
     */
    public function calculateDebt(Contract $contract, $year = null)
    {
        $data = [];
        if (!$year instanceof AcademicYear) {
            $year = GetAdmissionAcademicYear();
        }

        $debt = $contract->total_fees - $contract->total_paid;

        if ($debt > 1 && $year->min_debt_percent) {
            $data['debt'] = $debt;
            $data['minumim_debt'] = $year->min_debt_percent < 100 ? round($data['debt'] / 100 * $year->min_debt_percent, 2) : $data['debt'];
        }

        return $data;
    }

    /**
     * @param \App\Models\Contract $oldContract - old contract
     * @param \App\Models\Contract $newContract - new created contract
     * @return void
     */
    protected function TransferDebToNewContract(contract $oldContract, Contract $newContract)
    {

        foreach ($oldContract->transactions as $transaction) {
            if ($transaction->residual_amount > 0) {
                $newTransaction = [
                    'contract_id' => $newContract->id,
                    'installment_name' => $transaction->transaction_type == 'debt' ? $transaction->installment_name : 'مدونية عام' . $oldContract->year_name,
                    'amount_before_discount' => $transaction->residual_amount,
                    'discount_rate'  => 0,
                    'period_discount' => 0,
                    'coupon_discount' => 0,
                    'amount_after_discount' => $transaction->residual_amount,
                    'vat_amount' => 0,
                    'residual_amount' => $transaction->residual_amount,
                    'paid_amount' => 0,
                    'transaction_type' => 'debt',
                    'debt_year_id' => $transaction->transaction_type == 'debt' ? $transaction->debt_year_id : $oldContract->academic_year_id,
                    'payment_due' => Carbon::now()
                ];

                $this->StoreNewTransaction($newTransaction);
            }
        }
    }

    /**
     * @param array $transactionArray --transaction data to store
     * @return \App\Models\Transaction $transaction -- created transaction
     */
    protected function StoreNewTransaction(array $transactionArray)
    {
        $transaction = Transaction::create($transactionArray);
        if (!$transaction) {
            throw new \Exception("خطأ اثناء تسجيل الدفعة  : " . $transactionArray['installment_name'], 1);
        }
        return $transaction;
    }

    /**
     * @param \App\Models\Contract $contract -- must to be wwith transaction
     * @param double|int $amount -- amount to pay
     * @return bool
     */
    protected function payDebt(contract $contract, $amount)
    {
        $remain_amount = $amount;

        foreach ($contract->transactions as $transaction) {
            if ($transaction->residual_amount) {
                $request = request();

                if ($remain_amount > 0 && $remain_amount < $transaction->residual_amount) {
                    $request->request->add(['requested_ammount' =>  $remain_amount]); //add request
                }

                $data['reason'] = "تم دفع المبلغ اثناء ترفيع الطالب الي الصف الدراسي التالي";
                $PaymentAttempt = $this->CreateConfirmedPaymentAttempt($transaction, $request, $contract->guardian_id, $data);
                $remain_amount -= $PaymentAttempt->requested_ammount;


                if ($remain_amount <= 0) {
                    break;
                }
            }
        }

        return $remain_amount;
    }

    protected function TransferContract(Contract $contract, $data, $withTransportation = true)
    {
        $user = User::with('guardian')->findOrFail($contract->guardian_id);

        if (is_null($contract->next_level_id)) {
            throw new SystemConfigurationError('لم يتم العثور علي الصف الدراسي التالي .. رجاء التأكد من اعدادات النظام');
        }

        $year = GetAdmissionAcademicYear();
        $period = currentPeriod($year);

        $debt = $this->calculateDebt($contract, $year);

        if ($debt) {
            $data['debt'] = $debt;
        }

        $data['exam_result'] = $contract->exam_result;
        $data['next_school_year_id'] = $year->id;
        $data['next_level_id'] = $contract->exam_result == 'pass' ? $contract->next_level_id : $contract->level_id;

        if ($data['plan_id']) {

            $fees = new FeesCalculatorClass($data['plan_id'], $data['next_level_id'], $period, $user->guardian->category_id, $contract->nationality_id, $year);

            $data['tuition_fees']['installments'] =  $fees->getContractPayments()->getPayments();
            $data['tuition_fees']['semesters'] =  $fees->getContractPayments()->getRegisteredSemester()->pluck('id');

            // $tuition_fees = new TuitionFeesClass($data['plan_id'],  $data['next_level_id'], $period, $user->guardian->category_id, $contract->nationality_id, $year, $user);
            // $data['tuition_fees'] = $tuition_fees->calculateTuitionFees();
        }


        if ($withTransportation && $data['transportation_payment_id'] && $data['transportation_id']) {
            $data['transportation'] = $this->TransportationFees($data['transportation_payment_id'], $data['transportation_id']);
            $busTransaction = $this->getBusTransactionInfo($data['transportation'], $data['transportation_id']);
            if (isset($data['tuition_fees'])) {
                $busTransaction['order'] = count($data['tuition_fees']['installments']);
                array_push($data['tuition_fees']['installments'], $busTransaction);
            }
        }

        return $data;
    }

    protected function CreateConfirmedPaymentAttempt($transaction, Request $request, $guardian_id, $data = [])
    {
        $requested_ammount = $request->filled('requested_ammount') ? $request->requested_ammount : null;

        if (!$requested_ammount) {
            $requested_ammount = $transaction->residual_amount;
        }

        $location = null == $guardian_id ? 'byUser-U' : 'byAdmin-U';
        $file_path = [];

        if ($request->has('receipt')) {
            $file = $request->file('receipt');

            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = $guardian_id . '/receipt-' . $location . $guardian_id . '-T' . $transaction->id . '-' . time() . '.' . $file->getClientOriginalExtension();

            $path = upload($file,'s3','receipts',$filename);

            $file_path = ['attach_pathh' => $path];
        }

        //confirm payment
        $PaymentAttempt = PaymentAttempt::create($file_path + [
            'transaction_id' => $transaction->id,
            'payment_method_id' => $request->method_id,
            'requested_ammount' => $requested_ammount,
            'approved' => 1,
            'admin_id' => Auth::id(),
            'received_ammount' => $requested_ammount,
            'bank_id' => $request->bank_id
        ] + $data);

        $transaction->update_transaction();

        return $PaymentAttempt;
    }

    protected function ConfirmTransferRequest($transfer, $request) {

        $transfer = $transfer instanceof  TransferRequest ?  $transfer : TransferRequest::whereIn('status', ['new','pending'])->findOrFail($transfer);

        $oldContract = Contract::select('contracts.*', 'levels.next_level_id', 'students.nationality_id', 'students.guardian_id', 'academic_years.year_name')
            ->leftJoin('students', 'students.id', 'contracts.student_id')
            ->leftJoin('levels', 'levels.id', 'contracts.level_id')
            ->leftJoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->where('contracts.id', $transfer->contract_id)
            ->with('transactions', function ($query) {
                $query->where('residual_amount', '>', 0)->orderBy('residual_amount');
            })
            ->firstOrFail();

        $data = [
            'plan_id' => $transfer->plan_id,
            'transportation_id' => $transfer->transportation_id,
            'transportation_payment_id' => $transfer->transportation_payment,
        ];

        $newContractArray = $this->TransferContract($oldContract, $data);

        $newContract = DB::transaction(function () use ($request, $transfer, $oldContract, $newContractArray) {

            // add paid debt part to old contract
            if ($oldContract->transactions && $transfer->total_debt && $transfer->dept_paid > 0) {
                $this->payDebt($oldContract, $transfer->dept_paid);
            }

            // get user id
            if (Auth()->check()) {
                $user_id = auth()->id();
            } else {
                $user_id = $oldContract->guardian_id;
            }


            // prepare new contract data
            $newContractData = [
                'academic_year_id' => $newContractArray['next_school_year_id'],
                'plan_id' => $newContractArray['plan_id'],
                'level_id' => $newContractArray['next_level_id'],
                'applied_semesters' => $newContractArray['tuition_fees']['semesters'], //->pl
                'user_id' => $user_id,
                'old_contract_id' => $oldContract->id,
            ];

            //store new contract sontract
            $newContract = $this->CreateNewContract($newContractData, $oldContract->student_id, 1);

            if ($newContract) {
                // loop to add all contract installment
                foreach ($newContractArray['tuition_fees']['installments'] as $installment) {

                    unset($installment['order']);

                    $installment['contract_id'] = $newContract->id;

                    $transaction =  $this->StoreNewTransaction($installment);

                    if ((isset($installment['is_contract_payment']) && $installment['is_contract_payment'] == 1) || $installment['transaction_type'] == 'bus') {
                        $request->request->add(['requested_ammount' => $installment['residual_amount']]); //add request

                        $data['period_discount'] = isset($installment['period_discount']) ? $installment['period_discount'] : 0;
                        $data['period_id'] = isset($installment['period_id']) ? $installment['period_id'] : null;
                        $data['reason'] = "تم دفع المبلغ اثناء ترفيع الطالب الي الصف الدراسي التالي";

                        $this->CreateConfirmedPaymentAttempt($transaction, $request, $oldContract->guardian_id, $data);

                        // check if user request transporttation
                        if ($transaction->transaction_type == 'bus' && $transfer->transportation_id && $transfer->transportation_payment && $transfer->bus_fees) {
                            # store transportation plan
                            $this->CreateStudentTransportation($transfer->transportation_id, $transfer->transportation_payment, $newContract->student_id, $newContract->id, $transaction, $user_id);
                        }
                    }
                }

                //transfer debt froom old to new transaction
                $this->TransferDebToNewContract($oldContract, $newContract);


                $newContract->update_total_payments();
                return $newContract;
            }
        });

       return $newContract;
    }
}
