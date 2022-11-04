<?php

namespace App\Services;

use App\Exceptions\SystemConfigurationError;
use App\Http\Traits\ContractTrait;
use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Level;
use App\Models\nationality;
use App\Models\Period;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;

final class NewContractServices
{
    use ContractTrait;

    public function __construct($plan, $level, $period, $category, $nationality, $year, $user = null)
    {
        $this->level = $level instanceof Level ? $level : Level::findOrFail($level);
        $this->category = $category instanceof Category ? $category : Category::findOrFail($category);
        $this->nationality = $nationality instanceof nationality ? $nationality : nationality::findOrFail($nationality);
        $this->year = $year instanceof AcademicYear ? $year : AcademicYear::findOrFail($year);
        $this->plan = $plan instanceof Plan ? $plan : Plan::findOrFail($plan);
        $this->period = $period instanceof Period ? $period : Period::find($period);
        $this->semesters = match_semesters($this->year, Carbon::now());

        $this->tuition_fees = semesters_tuition_fees($this->level, $this->semesters);

        if (is_null($this->level)) {
            throw new SystemConfigurationError("لم يتم العثور علي  الصف الدراسي التالي  .. تأكد من اعدادات الصف الدراسي بشكل ضحيح");
        }

        if (is_null($user)) {
            $this->user = auth()->user();
        } else {
            $this->user = $user instanceof User ? $user : User::findOrFail($user);
        }

        $this->period_id = $this->period->id ?? null;

        $discount = Discount::where('level_id', $this->level->id)->where('plan_id', $this->plan->id)->where('period_id', $this->period_id)->where('category_id', $this->category->id)->first();

        $this->period_discount_rate = $discount ? $discount->rate : 0;
        
        $this->getContractPayments();
    }

}
