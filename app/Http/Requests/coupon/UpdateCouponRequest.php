<?php

namespace App\Http\Requests\coupon;

use App\Http\Requests\GeneralRequest;
use App\Rules\MaxDiscountRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends GeneralRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'coupon_value' => 'required|numeric',
            'available_at' => 'required|date|before:expire_at',
            'expire_at' => 'required|date|after:available_at',            
        ];
    }

    public function attributes()
    {
        return [
            'coupon_type' => 'رمز القسيمة',
            'coupon_value' => 'قيمة الخصم',
            'maximum_qty' => 'عدد القسائم',
            'limit_type' => 'عدد القسائم المتاحة',
            'limit_per_type' => 'الحد الاقصي',
            'min_students' => 'الحد الاقصي للاستتخدام',
            'max_discount_value' => 'اقصي قيمة للخصم',
            'available_at' => 'متاح ابتداء من',
            'expire_at' => 'تاريخ الأنتهاء',
        ];
    }
}

