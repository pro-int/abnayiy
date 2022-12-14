<?php

namespace App\Http\Traits;

use App\Helpers\FeesCalculatorClass;
use App\Helpers\TuitionFeesClass;
use App\Models\Application;
use App\Models\Contract;
use App\Models\Discount;
use App\Models\guardian;
use App\Models\Plan;
use App\Models\Student;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait ContractInstallments
{
    use OdooIntegrationTrait;

    private $plan;
    private $category;
    private $contract;
    private $guardian;
    private $period;
    private $ammount = [];
    private $transportation = [];

    private $odooIntegrationKeys = [];
    private $odooIntegrationTransportationKey = [];
    private $odooIntegrationJournalKey = [];

    /**
     * calculate transaction ammounts.
     * @param \App\Models\Contract $contract
     * @param int $guardian_id
     * @return boolean
     */

    public function CreateInstallments($contract, $student)
    {
        $this->contract = $contract;
        $this->period  = currentPeriod($this->year);

        $this->plan = Plan::findOrFail($contract->plan_id);

        // $this->guardian = guardian::firstOrFail($student->guardian_id)->category;
        $this->category = guardian::findorFail($student->guardian_id)->category;

        // $tuition_fees = new TuitionFeesClass($this->plan, $contract->level_id, $period, $this->category, $student->nationality_id, $contract->academic_year_id, $student->guardian_id);
        // $tuition_fees = $tuition_fees->calculateTuitionFees();

        $fees = new FeesCalculatorClass($this->plan, $contract->level_id, $this->period, $this->category, $student->nationality_id, $contract->academic_year_id);

        $installments =  $fees->getContractPayments()->getPayments();

        if ($this->plan && $this->category) {

            foreach ($installments as $installment) {
                if (! $this->plan->fixed_discount) {
                    $installment['period_discount'] = 0;
                    $installment['amount_after_discount'] = $installment['amount_before_discount'];
                    $installment['residual_amount'] = $installment['amount_before_discount'] + $installment['vat_amount'];
                }
                $this->StoreNewTransaction($installment + ['contract_id' => $this->contract->id]);
            }

            $contract->update_total_payments();

            $this->setOdooKeys($contract);
            $this->createInvoiceInOdoo($this->odooIntegrationKeys, $contract->id, $this->odooIntegrationTransportationKey, $this->odooIntegrationJournalKey);

            return true;
        } else {
            return false;
        }
    }

    public function setOdooKeys($contract){
        $this->odooIntegrationKeys["student_id"] = $contract->student_id;
        $this->odooIntegrationKeys["invoice_code_abnai"] = $contract->id;
        $this->odooIntegrationKeys["date"] = Carbon::parse($contract->created_at)->toDateString();
        $this->odooIntegrationKeys["global_order_discount"] =  $contract->period_discounts + $contract->coupon_discounts;

        $application = Contract::select('genders.odoo_product_id_study',
            'genders.odoo_account_code_study',
            'genders.odoo_product_id_transportation',
            'genders.odoo_account_code_transportation',
            'transportations.id as transportation_id',
            'transactions.period_discount','transactions.coupon_discount',
            'genders.id as gender_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin("plans", "plans.id", "contracts.plan_id")
            ->leftjoin("students", "students.id", "contracts.student_id")
            ->leftjoin("student_transportations", "student_transportations.student_id", "students.id")
            ->leftjoin("transportations", "transportations.id", "student_transportations.transportation_id")
            ->leftjoin("transactions", "transactions.id", "student_transportations.transaction_id")
            ->where("contracts.id", $contract->id)->first();

        if($application && $application->transportation_id){
            $this->odooIntegrationTransportationKey["product_id"] = (int)$application->odoo_product_id_transportation;
            $this->odooIntegrationTransportationKey["name"] = '???????? ??????';
            $this->odooIntegrationTransportationKey["account_code"] = $application->odoo_account_code_transportation;
            $this->odooIntegrationTransportationKey["price_unit"] = $contract->bus_fees;
            $this->odooIntegrationTransportationKey["is_fees_transport"] = "2";
            $this->odooIntegrationTransportationKey["tax_ids"] = [1];
            $this->odooIntegrationTransportationKey["global_order_discount"] = $application->period_discounts + $application->coupon_discounts;
        }else{
            $this->odooIntegrationTransportationKey = [];
        }

        if ($application){
            $this->odooIntegrationKeys["global_order_discount"] =  $contract->period_discounts + $contract->coupon_discounts;
            $this->odooIntegrationKeys["product_id"] = (int)$application->odoo_product_id_study;
            $this->odooIntegrationKeys["name"] = '???????? ????????????';
            $this->odooIntegrationKeys["account_code"] = $application->odoo_account_code_study;
            $this->odooIntegrationKeys["price_unit"] = $contract->tuition_fees;
            $this->odooIntegrationKeys["is_fees_transport"] = "1";
            $student = Student::select("nationality_id")->where("id",$contract->student_id)->first();
            if($student->nationality_id != 1){
                $this->odooIntegrationKeys["tax_ids"] = [1];
            }else{
                $this->odooIntegrationKeys["tax_ids"] = [4];
            }
        }

        $this->odooIntegrationKeys["quantity"] = 1;

        if($contract->debt !=0) {
            $this->odooIntegrationJournalKey["date"] = Carbon::parse($contract->created_at)->toDateString();
            $this->odooIntegrationJournalKey["ref"] = "???????????????? ????????????";
            $this->odooIntegrationJournalKey["journal_id"] = 3;
            $this->odooIntegrationJournalKey["journals"] = [
                [
                    "account_id" => config("odoo_configuration")['db'] == "Live" ? 7686:7684,
                    "student_id" => $contract->student_id,
                    "name" => "new",
                    "debit" => $contract->debet > 0 ? $contract->debt : 0,
                    "credit" => $contract->debet > 0 ? 0 : $contract->debt,
                ],
                [
                    "account_id" => config("odoo_configuration")['db'] == "Live" ? 7687:7685,
                    "student_id" => "0000",
                    "name" => "new",
                    "debit" => $contract->debet > 0 ? 0 : $contract->debt,
                    "credit" => $contract->debet > 0 ? $contract->debt : 0,
                ]
            ];
        }else{
            $this->odooIntegrationJournalKey = [];
        }
    }

    /**
     * calculate transaction ammounts.
     * @return array
     */
    public function CalculateTransactionAmounts()
    {
        $discount_rate = 0;
        if ($this->plan->fixed_discount) {
            $period_id = $this->period->id ?? null;

            $discount = Discount::where('level_id', $this->contract->level_id)->where('plan_id', $this->plan->id)->where('period_id', $period_id)->where('category_id', $this->category->id)->first();

            $discount_rate = $discount ? $discount->rate : 0;
        }

        $amount_before_discount = $this->plan->installments > 0 ?  $this->contract->tuition_fees / $this->plan->installments : $this->contract->tuition_fees;

        $vat_amount = $this->contract->vat_rate ? ($amount_before_discount / 100) * $this->contract->vat_rate : 0;

        $amount_after_vat = $amount_before_discount + $vat_amount;

        $period_discount = $discount_rate ? ($amount_after_vat  / 100) * $discount_rate : 0;

        $amount_after_discount = $amount_before_discount - $period_discount;


        return [
            'amount_before_discount' => $amount_before_discount,
            'vat_amount' => $vat_amount,
            'discount_rate' => $discount_rate,
            'period_discount' => $period_discount,
            'amount_after_discount' => $amount_after_discount,
            'residual_amount' => $amount_after_discount + $vat_amount,
        ];
    }


    /**
     * Execute the console command.
     * @param int $num_of_installments
     * @param int $i installment index
     * @return string
     */
    public function installment_name($num_of_installments, $i)
    {
        $names = [
            '????????????',
            '??????????????',
            '??????????????',
            '??????????????',
            '??????????????',
            '??????????????',
            '??????????????',
            '??????????????',
        ];

        return $num_of_installments > 1 ? (isset($names[$i]) ? '???????????? ' . $names[$i] : '???????????? ?????? ' . $i) :  '?????????????????? ????????????????';
    }

        /**
     * @param array $transactionArray --transaction data to store
     * @return \App\Models\Transaction $transaction -- created transaction
     */
    protected function StoreNewTransaction(array $transactionArray)
    {
        $transaction = Transaction::create($transactionArray + ['admin_id' => Auth::id()]);

        if (!$transaction) {
            throw new \Exception("?????? ?????????? ?????????? ????????????  : " . $transactionArray['installment_name'], 1);
        }
        return $transaction;
    }
}
