<?php

namespace App\Services;

use App\Exceptions\SystemConfigurationError;
use App\Http\Traits\ContractTrait;
use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Discount;
use App\Models\Level;
use App\Models\nationality;
use App\Models\PaymentAttempt;
use App\Models\Period;
use App\Models\Plan;
use App\Models\TransferRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RenewContractServices
{
    use ContractTrait;

    protected $oldContract;
    protected $transfer_request;
    protected $debtInfo = [];

    /**
     * @param \App\Models\Plan $plan
     * @param \App\Models\semester $semesters
     * @return double|int;
     */
    public function __construct($oldContract, $transfer_request, $plan, $level, $period, $category, $nationality, $year, $user = null)
    {
        $this->level = $level instanceof Level ? $level : Level::findOrFail($level);
        $this->category = $category instanceof Category ? $category : Category::findOrFail($category);
        $this->nationality = $nationality instanceof nationality ? $nationality : nationality::findOrFail($nationality);
        $this->year = $year instanceof AcademicYear ? $year : AcademicYear::findOrFail($year);
        $this->plan = $plan instanceof Plan ? $plan : Plan::findOrFail($plan);
        $this->period = $period instanceof Period ? $period : Period::find($period);
        $this->semesters = match_semesters($this->year, Carbon::now());

        $this->oldContract = $oldContract instanceof Contract ? $oldContract : Contract::select('contracts.*', 'levels.next_level_id', 'students.nationality_id', 'students.guardian_id', 'academic_years.year_name')
            ->leftJoin('students', 'students.id', 'contracts.student_id')
            ->leftJoin('levels', 'levels.id', 'contracts.level_id')
            ->leftJoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->where('contracts.id', $transfer_request->contract_id)
            ->with('transactions', function ($query) {
                $query->where('residual_amount', '>', 0)->orderBy('residual_amount');
            })
            ->firstOrFail();;

        $this->transfer_request = $transfer_request instanceof  TransferRequest ?  $transfer_request : TransferRequest::whereIn('status', ['new', 'pending'])->findOrFail($transfer_request);
        $this->tuition_fees = semesters_tuition_fees($this->level, $this->semesters);

        if (is_null($this->level)) {
            throw new SystemConfigurationError("لم يتم العثور علي  الصف الدراسي التالي  .. تأكد من اعدادات الصف الدراسي بشكل ضحيح");
        }

        if (is_null($this->oldContract->next_level_id)) {
            throw new SystemConfigurationError('لم يتم العثور علي الصف الدراسي التالي .. رجاء التأكد من اعدادات النظام');
        }

        if (is_null($user)) {
            $this->user = auth()->user();
        } else {
            $this->user = $user instanceof User ? $user : User::findOrFail($this->oldContract->guardian_id);
        }

        $this->period_id = $this->period->id ?? null;

        $discount = Discount::where('level_id', $this->level->id)->where('plan_id', $this->plan->id)->where('period_id', $this->period_id)->where('category_id', $this->category->id)->first();

        $this->period_discount_rate = $discount ? $discount->rate : 0;


        $this->getContractPayments();
    }

    public function ConfirmTransferRequest($request)
    {
        $data = [
            'plan_id' => $this->transfer_requestr->plan_id,
            'transportation_id' => $this->transfer_requestr->transportation_id,
            'transportation_payment_id' => $this->transfer_requestr->transportation_payment,
        ];

        $newContractArray = $this->TransferContract($data);

        $newContract = DB::transaction(function () use ($request, $newContractArray) {

            // add paid debt part to old contract
            if ($this->oldContract->transactions && $this->transfer_requestr->total_debt && $this->transfer_requestr->dept_paid > 0) {
                $this->payDebt($this->oldContract, $this->transfer_requestr->dept_paid);
            }

            // prepare new contract data
            $newContractData = [
                'academic_year_id' => $newContractArray['next_school_year_id'],
                'plan_id' => $newContractArray['plan_id'],
                'level_id' => $newContractArray['next_level_id'],
                'applied_semesters' => $newContractArray['tuition_fees']['semesters'], //->pl
                'user_id' => $this->user->id,
                'old_contract_id' => $this->oldContract->id,
            ];

            //store new contract sontract
            $newContract = $this->CreateNewContract($newContractData, $this->oldContract->student_id, 1);

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
                        $data['reference'] = $this->transfer_requestr->payment_ref;

                        $this->CreateConfirmedPaymentAttempt($transaction, $request, $this->oldContract->guardian_id, $data);

                        // check if user request transporttation 
                        if ($transaction->transaction_type == 'bus' && $this->transfer_requestr->transportation_id && $this->transfer_requestr->transportation_payment && $this->transfer_requestr->bus_fees) {
                            # store transportation plan
                            $this->CreateStudentTransportation($this->transfer_requestr->transportation_id, $this->transfer_requestr->transportation_payment, $newContract->student_id, $newContract->id, $transaction, $this->user->id);
                        }
                    }
                }

                //transfer debt froom old to new transaction 
                $this->TransferDebToNewContract($this->oldContract, $newContract);

                return $newContract;
            }
        });

        return $newContract;
    }

    /**
     * calculate contract debt and minimum payment
     * @return array $data[]
     */
    public function getContractDebt()
    {
        $debt = $this->oldContract->total_fees - $this->oldContract->total_paid;

        if ($debt > 1 && $this->year->min_debt_percent) {
            $this->debtInfo['debt'] = $debt;
            $this->debtInfo['minumim_debt'] = $this->year->min_debt_percent < 100 ? round($this->debtInfo['debt'] / 100 * $this->year->min_debt_percent, 2) : $this->debtInfo['debt'];
        }

        return $this->debtInfo;
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

    protected function TransferContract($data, $withTransportation = true)
    {

        $debt = $this->getContractDebt($this->oldContract);

        if ($debt) {
            $data['debt'] = $debt;
        }

        $data['exam_result'] = $this->contract->exam_result;
        $data['next_school_year_id'] = $this->year->id;
        $data['next_level_id'] = $this->contract->exam_result == 'pass' ? $this->contract->next_level_id : $this->contract->level_id;

        if ($data['plan_id']) {
            $tuition_fees = $this->getPayments();
            $data['tuition_fees'] = $this->calculateTuitionFees();
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

            $path = Storage::disk('public')->putFileAs(
                'receipts',
                $file,
                $filename
            );
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
}
