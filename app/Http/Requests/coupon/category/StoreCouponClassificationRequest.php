<?php

namespace App\Http\Requests\coupon\category;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class StoreCouponClassificationRequest extends GeneralRequest
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
            'classification_name' => 'required|' . Rule::unique('coupon_classifications')->where('academic_year_id', $this->academic_year_id),
            'classification_prefix' => 'required|regex:/(^([a-zA-Z]+)?$)/u|min:2|size:2|' . Rule::unique('coupon_classifications')->where('academic_year_id', $this->academic_year_id),
            'limit' => 'required|numeric|min:1',
            'color_class' => 'required',
            'allowed_types' => 'required',
            'academic_year_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'classification_prefix.regex' => 'بادئة القسائم يجب ان تكون حرفين باللغة الأنكليزية'
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
