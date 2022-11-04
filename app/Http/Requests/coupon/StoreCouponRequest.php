<?php

namespace App\Http\Requests\coupon;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class StoreCouponRequest extends GeneralRequest
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
            'code' => 'required|string|max:20|unique:coupons',
            'coupon_value' => 'required|numeric',
            'level_id' => 'requiredif:classification_id,!=,null',
            'academic_year_id' => 'required',
            'available_at' => 'required|date|before:expire_at',
            'expire_at' => 'required|date|after:available_at',            
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'رمز القسيمة',
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

    protected function prepareForValidation()
    {
        $this->merge([
            'code' => $this->code ??  Str::upper(Str::random(6)),
            'classification_id' => $this->classification_id == '' ? null : $this->classification_id,
            'coupon_type' => $this->classification_id ? 'special' : 'general',
            'active' => (bool) $this->active]);
    }

}

