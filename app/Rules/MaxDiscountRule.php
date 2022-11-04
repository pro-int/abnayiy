<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxDiscountRule implements Rule
{
    public $max_value;
    public $coupon_type;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($coupon_type ,$max_value = 100)
    {
        $this->max_value =  $max_value;
        $this->coupon_type =  $coupon_type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->coupon_type || $value <= 100;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'لا يمكن ان تكون قيمة الخصم اكبر من 100 في حالة النسبة المئوية';
    }
}
