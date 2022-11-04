<?php

namespace App\Http\Requests\coupon\category;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class UpdateCouponClassificationRequest extends GeneralRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'classification_name' => 'required|'. Rule::unique('coupon_classifications')->where('academic_year_id',$this->classification->academic_year_id)->ignore($this->classification->id),
            'limit' => 'required|numeric|min:1',
            'color_class' => 'required',
            'allowed_types' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'classification_name' => 'اسم التصنيف',
            'classification_prefix' => 'بادئة التصنيف',
            'limit' => 'الحد الأقصي للخصومات',
            'color_class' => 'اللون المميز',
            'allowed_types' => 'انوع الدفعات',
            'academic_year_id' => 'العام الدراسي'
        ];
    }

}
