<?php

namespace App\Http\Traits;

use App\Models\Application;
use App\Models\Contract;
use App\Models\Student;
use App\Models\StudentTransportation;
use App\Models\Transaction;
use App\Models\Transportation;
use Carbon\Carbon;

trait ContractTransportation
{
    protected function TransportationFees($transportation_payment, $TransportationPlan)
    {

        $TransportationPlan = $TransportationPlan instanceof Transportation ? $TransportationPlan : Transportation::findOrFail($TransportationPlan);

        $data['fees'] = 0;

        switch ($transportation_payment) {
            case 1:
                $data['fees'] = $TransportationPlan->annual_fees;
                break;
            case 2:
                $data['fees'] = $TransportationPlan->semester_fees;
                break;
            case 3:
                $data['fees'] = $TransportationPlan->monthly_fees;
                break;
            default:
                break;
        }

        $data['vat_amount'] = $data['fees'] * (env('BUS_VAT_RATE', 15) / 100);

        return $data;
    }

    protected function CreateStudentTransportation($transportation_id, $transportation_payment, $student, $contract, $transaction = null, $user_id = null)
    {
        $TransportationPlan = Transportation::findOrFail($transportation_id);

        $fees = $this->TransportationFees($transportation_payment, $TransportationPlan);

        if (is_null($transaction)) {
            # no transaction , will create one
            $transaction = transaction::create(array_merge([
                'contract_id' => $contract,
                'payment_due' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], $this->getBusTransactionInfo($fees, $TransportationPlan)));
        }

        // get user id 
        if (Auth()->check()) {
            $user_id = auth()->id();
        }

        # application request transportation 
        StudentTransportation::create([
            'student_id' => $student,
            'transportation_id' => $TransportationPlan->id,
            'payment_type' => $transportation_payment,
            'contract_id' => $contract,
            'base_fees' => $fees['fees'],
            'vat_amount' => $fees['vat_amount'],
            'total_fees' => $fees['fees'] + $fees['vat_amount'],
            'add_by' =>  $user_id,
            'transaction_id' => $transaction->id
        ]);
    }

    protected function getBusTransactionInfo($fees, $TransportationPlan)
    {
        $TransportationPlan = $TransportationPlan instanceof Transportation ? $TransportationPlan : Transportation::findOrFail($TransportationPlan);

        return [
            'installment_name' =>  'رسوم النقل ' . $TransportationPlan->transportation_type,
            'amount_before_discount' => $fees['fees'],
            'vat_amount' => $fees['vat_amount'],
            'amount_after_discount' => $fees['fees'],
            'residual_amount' => $fees['fees'] + $fees['vat_amount'],
            'transaction_type' => 'bus',
        ];
    }
}
