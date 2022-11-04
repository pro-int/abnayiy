<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'plan_id',
        'period_id',
        'category_id',
        'updated_by',
        'rate',
    ];

    public static function filter($discounts, $plan_id, $level_id, $category_id,$period_id)
    {
        // @php $r = $discounts->where('plan_id',$plan->id)->where('level_id',$level->id)->where('category_id',$category->id)->pluck('rate','id') @endphp
        $collection = $discounts;
        $res = $collection->where('period_id',$period_id)->Where('plan_id', $plan_id)->Where('level_id', $level_id)->Where('category_id', $category_id)->first();

        if ($res) {
            return $res->rate;
        }
        return '0';
    }

    
    /**
     * calculate transaction ammounts.
     * @param App\Modals\Contract $contract 
     * @param App\Modals\period $period 
     * @param App\Modals\plan $plan 
     * @param App\Modals\category $category 
     * @return array $data
     */
    public static function calculate_discount($contract, $period, $plan, $category)
    {
        $discount = Discount::where('level_id', $contract->level_id)->where('plan_id', $plan->id)->where('period_id', $period->id)->where('category_id', $category->id)->first();
            if ($discount) {
                $discount_rate = $discount->rate;
            } else {
                $discount_rate = 0;
            }

            $amount_before_discount = $contract->tuition_fees / $plan->installments;
         
            $period_discount = ($amount_before_discount / 100) * $discount_rate;
            $amount_after_discount = $amount_before_discount - $period_discount;
            $vat_amount = ($amount_after_discount / 100) * $contract->vat_rate;

            $data =[
                'amount_before_discount' => $amount_before_discount, 
                'period_discount' => $period_discount, 
                'discount_rate' => $discount_rate, 
                'amount_after_discount' => $amount_after_discount, 
                'vat_amount' => $vat_amount, 
                'residual_amount' => $amount_after_discount + $vat_amount, 
            ];
            
        return $data;
    }

        /**
     * calculate transaction ammounts.
     * @param App\Modals\Contract $contract 
     * @param App\Modals\period $period 
     * @param App\Modals\plan $plan 
     * @param App\Modals\category $category 
     * @return array $data
     */
    public static function calculate_installments($contract, $period, $plan, $category)
    {         
        $discount = Discount::where('level_id', $contract->level_id)->where('plan_id', $plan->id)->where('period_id', $period->id)->where('category_id', $category->id)->first();
       info($discount);
        if ($discount) {
            $discount_rate = $discount->rate;
        } else {
            $discount_rate = 0;
        }

            $amount_before_discount = $contract->tuition_fees / $plan->installments;

            $period_discount = ($amount_before_discount  / 100) * $discount_rate;
         
            $amount_after_discount = $amount_before_discount - $period_discount;

            $vat_amount = ($amount_after_discount / 100) * $contract->vat_rate;

            $amount_after_discount += $vat_amount;
           
            $data =[
                'amount_before_discount' => $amount_before_discount, 
                'period_discount' => $period_discount,
                'discount_rate' => $discount_rate, 
                'vat_amount' => $vat_amount,
                'amount_after_discount' => $amount_after_discount, 
                'residual_amount' => $amount_after_discount, 
            ];
            
        return $data;
    }

    /**
    * @param int $level_id
    * @param int $plan_i*d
    * @param int $period_i*d
    * @param int $category_id
    * @return App\Modals\Discount
    */
    public static function Get_discounts_info($level_id,$plan_id,$period_id, $category_id)
    {
        return  Discount::where('level_id', $level_id)->where('plan_id', $plan_id)->where('period_id', $period_id)->where('category_id', $category_id)->first();
    }
}
