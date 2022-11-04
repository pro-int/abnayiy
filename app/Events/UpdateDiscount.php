<?php

namespace App\Events;

use App\Models\Contract;
use App\Models\Coupon;
use App\Models\CouponClassification;
use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UpdateDiscount
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $classification;
    public $level_id;
    public $year_id;

    /**
     * Create a new event instance.
     * @param  \App\Models\Contract  $contract     
     * * @return void
     */

    public function __construct($level_id, $year_id, $classification = null)
    {
        $this->classification = $classification;
        $this->level_id = $level_id;
        $this->year_id = $year_id;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ContractCreated  $event
     * @return void
     */
    public function handle()
    {


        $year = $this->year_id;
        if (is_null($this->classification)) {
            if ($this->level_id && $level = Level::find($this->level_id)) {

                $contracts = Contract::where('level_id', $level->id)->where('academic_year_id', $year);

                $level_fees = $contracts->sum(DB::raw('vat_amount + tuition_fees'));
                $period_discounts = $contracts->sum('period_discounts');

                $discount_limits = Cache::get('discount_limits', []);

                $coupon_discounts = Coupon::where('code', 'not like', 'NL%')->where('level_id', $level->id)->where('academic_year_id', $year)->where('used_value','>', 0)->sum('used_value');

                $unused_discounts = Coupon::where('code', 'not like', 'NL%')->where('level_id', $level->id)->where('academic_year_id', $year)->whereDate('expire_at', '>', Carbon::now())->sum(DB::raw('coupon_value - used_value'));

                $discount_limits[$year][$level->id]['level_name'] = $level->level_name;
                $discount_limits[$year][$level->id]['total_fees'] = $level_fees;
                $discount_limits[$year][$level->id]['coupon_discounts'] = $coupon_discounts;
                $discount_limits[$year][$level->id]['period_discounts'] = $period_discounts;
                $discount_limits[$year][$level->id]['max_coupon_discounts'] = ($level->coupon_discount_persent / 100) * $level_fees;
                $discount_limits[$year][$level->id]['max_period_discounts'] = ($level->period_discount_persent / 100) * $level_fees;

                $discount_limits[$year][$level->id]['max_coupon_discounts_percent'] = $level->coupon_discount_persent;
                $discount_limits[$year][$level->id]['max_period_discounts_percent'] = $level->period_discount_persent;

                $discount_limits[$year][$level->id]['unused_coupon_discounts'] = $unused_discounts;

                $discount_limits[$year][$level->id]['remain_coupon_discounts'] = $discount_limits[$year][$level->id]['max_coupon_discounts'] - $discount_limits[$year][$level->id]['coupon_discounts'] - $unused_discounts;

                $discount_limits[$year][$level->id]['remain_period_discounts'] = $discount_limits[$year][$level->id]['max_period_discounts'] - $discount_limits[$year][$level->id]['period_discounts'];

                Cache::forever('discount_limits', $discount_limits);
            }
        } else {
            
            $contracts = Contract::where('academic_year_id', $year);
            $total_fees = $contracts->sum(DB::raw('vat_amount + tuition_fees'));

            $classification_code = $this->classification->classification_prefix;


            $discount_limits = Cache::get('special_discount_limits', []);

            $coupon_discounts = Coupon::where('code', 'like', 'NL'.$classification_code.'%')->where('academic_year_id', $year)->sum('used_value');

            $unused_discounts = Coupon::where('code', 'like', 'NL'.$classification_code.'%')->where('academic_year_id', $year)->whereDate('expire_at', '>=', Carbon::now())->sum(DB::raw('coupon_value - used_value'));

            $discount_limits[$year][$classification_code]['total_fees'] = $total_fees;

            $discount_limits[$year][$classification_code]['coupon_discounts'] = $coupon_discounts;
            $discount_limits[$year][$classification_code]['max_coupon_discounts'] = $this->classification->limit;

            $discount_limits[$year][$classification_code]['max_coupon_discounts_percent'] = round($this->classification->limit / $total_fees * 100,2);

            $discount_limits[$year][$classification_code]['unused_coupon_discounts'] = $unused_discounts;

            $discount_limits[$year][$classification_code]['remain_coupon_discounts'] = $discount_limits[$year][$classification_code]['max_coupon_discounts'] - $discount_limits[$year][$classification_code]['coupon_discounts'] - $unused_discounts;

            Cache::forever('special_discount_limits', $discount_limits);
        }
    }
}
