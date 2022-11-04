<?php

namespace App\Http\Traits;

use App\Models\Coupon;
use App\Models\CouponClassification;
use App\Models\CouponUsage;
use App\Models\guardian;
use App\Models\Student;
use Carbon\Carbon;
use App\Models\Transaction;

trait CouponeTrait
{
    public $coupon;
    public $used_value;

    /**
     * @param String $coupone_code
     * @param \App\Models\Transaction $transaction
     * @return array $this->transaction_data
     */

    public function has_Coupone()
    {
        $this->transaction_data += ['coupon_discount' => 0, 'coupon_code' => null, 'is_coupon_valid' =>  false];

        !empty($this->coupon_code) ?
            $this->getCoupon()
            : $this->calculate_amount();
    }

    protected function getCoupon()
    {
        $coupon = Coupon::where('code', $this->coupon_code);

        if ($this->check_coupon) {
            $coupon = $coupon
                ->whereDate('available_at', '<=', Carbon::now())
                ->whereDate('expire_at', '>=', Carbon::now())
                ->where('active', true);
        }

        $this->coupon = $coupon->first();

        if ($this->coupon) {
            // coupon founded
            return $this->CheckTransacationType();
        }

        $this->transaction_data['coupon_code'] = $this->coupon_code;
        $this->transaction_data['message'] = 'قسيمة غير صالحة';

        return $this->calculate_amount();  
     }

    public function CheckTransacationType()
    {

        $allowed_types = ['tuition'];

        if ($this->coupon->classification_id) {
            $classification = CouponClassification::find($this->coupon->classification_id);
            $allowed_types = $classification->allowed_types;
        }

        if (! in_array($this->transaction->transaction_type, $allowed_types)) {
            switch ($this->transaction->transaction_type) {
                case 'tuition':
                    $transaction_text = 'الرسوم الدراسية';
                    break;
                case 'debt':
                    $transaction_text = 'المديونيات';
                    break;
                case 'bus':
                    $transaction_text = 'رسوم النقل';
                    break;
                default:
                    $transaction_text = 'هذة الدفعة';
                    break;
            }
            $this->transaction_data['coupon_code'] = $this->coupon_code;
            $this->transaction_data['message'] = 'لا يمكن تطبيق هذة القسيمة علي  ' . $transaction_text;
            return $this->calculate_amount();
        }
        return $this->check_usage_Limit();
    }

    /**
     * @param App\Modeals\coupon $coupon
     * @param App\Modeals\Transaction $transaction
     * @return 
     */
    public function check_usage_Limit()
    {
        // $guardian_id = $this->transaction->guardian_id;
        $this->transaction_data['is_coupon_valid'] = true;

        if ($this->coupon->used_value >= $this->coupon->coupon_value) {
            $this->transaction_data['is_coupon_valid'] = false;
            $this->transaction_data['message'] = 'تم استخدام اجمالي رصيد القسيمة';
        }

        if (!is_null($this->coupon->level_id) && $this->coupon->level_id != $this->transaction->level_id) {
            $this->transaction_data['is_coupon_valid'] = false;
            $this->transaction_data['message'] = 'للأسف .. القسيمة غير صالحة للصف الدراسي المقيد بالطالب';
        }

        if ($this->coupon->academic_year_id != $this->transaction->academic_year_id) {
            $this->transaction_data['is_coupon_valid'] = false;
            $this->transaction_data['message'] = 'للأسف .. القسيمة غير صالحة للعام الدراسي المقيد بة الطالب';
        }

        // if ($this->coupon->min_students > 0 && Student::where('guardian_id', $guardian_id)->count() < $this->coupon->min_students) {
        //     $this->transaction_data['is_coupon_valid'] = false;
        //     $this->transaction_data['message'] = sprintf('هذة القسيمة تصلح لمن لديهم %s طالب مسجل علي الاقل', $this->coupon->min_students);
        // }

        // $guardian = guardian::where('guardian_id', $guardian_id)->first();

        // if (!in_array($guardian->category_id, $this->coupon->categories->pluck('category_id')->toArray())) {
        //     $this->transaction_data['is_coupon_valid'] = false;
        //     $this->transaction_data['message'] = 'نعتذر لا يمكن استخدام هذة القسيمة';
        // }

        // $usage = CouponUsage::where('coupon_id', $this->coupon->id);
        // if ($this->coupon->limit_type == 'user') {
        //     $usage = $usage->where('guardian_id', $guardian_id);
        // } else if ($this->coupon->limit_type == 'student') {
        //     $usage = $usage->where('student_id', $this->transaction->student_id);
        // }

        // $usage = $usage->get();

        // if ($usage->count() >= $this->coupon->limit_per_type) {
        //     $this->transaction_data['is_coupon_valid'] = false;
        //     $this->transaction_data['message'] = 'عفوا لقد نفذت القسائم المتاحة';
        // }

        if (!$this->transaction_data['is_coupon_valid']) {
            return  $this->calculate_amount();
        }
        return $this->calculate_discount();
    }

    /**
     * @param App\Modeals\coupon $coupon
     * @param App\Modeals\Transaction $transaction
     * @return array $data
     */
    public function calculate_discount()
    {
        $discount_value = round($this->max_discount(), 2);

        $this->transaction_data['coupon_discount'] =  $discount_value;

        $this->transaction_data['coupon_code'] = $this->coupon->code;
        $this->transaction_data['is_coupon_valid'] = true;

        $this->transaction_data['message'] = sprintf('تهانينا لقد حصلت علي خصم %s ر.س', $this->used_value);

        return $this->calculate_amount();
    }

    /**
     * @param double $ammount
     * @return double $new_value
     */
    public function max_discount()
    {
        $residual_amount =  $this->transaction->residual_amount - $this->transaction_data['new_period_discount'];
        $unused = $this->getUnUsedValue();

        if ($unused > $residual_amount) {
            $this->used_value = $residual_amount;
            return $residual_amount;
        }

        $this->used_value = $unused;
        return $unused;
    }

    public function getUnUsedValue()
    {
        return $this->coupon->coupon_value - $this->coupon->used_value;
    }


    /**
     * @param String $coupon_code
     * @return Void
     */
    protected function UpdatecouponUsage(string $coupon_code)
    {
        if (!empty($coupon_code)) {
            $coupon = Coupon::where('code', $coupon_code)->first();
            if ($coupon) {
                // $coupon->used_coupon = 1;
                $coupon->used_value +=  $this->used_value;
                $coupon->used_coupon = $coupon->used_value >= $this->used_value;
                $coupon->save();
            }
        }
    }
}
