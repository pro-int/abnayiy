<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Plan;
use App\Models\semester;

final class ContractDownPaymentServices
{
    protected $plan;
    protected $semesters;
    protected $downPayment = 0;
    
    /**
     * @param \App\Models\Plan $plan
     * @param \App\Models\semester $semesters
     * @return double|int;
     */
    public function __construct(Plan $plan, semester $semesters)
    {
        $this->plan = $plan;
        $this->semesters = $semesters;

        $this->calculatePlanDownPayment();
    }

    public function getDownPayment()
    {
        return $this->downPayment;
    }

    private function calculatePlanDownPayment()
    {
        switch ($this->getPlanBase()) {
            case 'total':
                // downpayment is total fees
                $this->downPayment = 100;
                break;

            case 'semester':
                // downpayment is first semester
                $this->downPayment = $this->semesters->first()->semester_in_fees;
                break;

            default:
                # based on fixed rate
                $this->downPayment = $this->plan->down_payment ?? 0;
                break;
        }
    }
    private function getPlanBase()
    {
        return $this->plan->plan_based_on;
    }
}
