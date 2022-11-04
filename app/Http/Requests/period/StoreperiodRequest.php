<?php

namespace App\Http\Requests\period;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class StoreperiodRequest extends GeneralRequest
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
    public function rules()
    {
        return [
            'period_name' => 'required|string|'. Rule::unique('periods')->where('academic_year_id', $this->year),
            'apply_start' => 'required|date|before:apply_end',
            'apply_end' => 'required|date|after:apply_start',
            'points_effect'=> 'required|digits_between:-2,2'

        ];
    }

    public function attributes()
    {
        return [
            'period_name' => 'اسم الفترة',

            'apply_start' => 'تاريح البدء',

            'apply_end' => 'تاريخ الأنتهاء',

            'academic_year_id' => 'السنة الدراسية',

            'points_effect' => 'النقاط المتكسبة'

        ];
    }


    // public function messages()
    // {
    //     return [
    //         'year_name.required' => 'اسم الفصل الدراسي مطلوب',
    //         'year_name.unique' => 'اسم الفصل الدراسي مسجل مسبقا',

    //         'semester_start.required' => 'تاريخ بداية الفصل الدراسي مطلوب ',
    //         'semester_start.date' => 'صيغة تاريخ  بداية الفصل الدراسي غير صحيحة ',
    //         'semester_start.before' => 'تاريخ بداية الفصل الدراسي يجب ان يكون قبل تاريخ نهاية الفصل الدراسي ',

    //         'semester_end.required' => 'تاريخ نهاية الفصل الدراسي مطلوب',
    //         'semester_end.date' => 'صيغة تاريخ  نهاية الفصل الدراسي  غير صحيحة',
    //         'semester_end.before' => 'تاريخ نهاية الفصل الدراسي يجب ان يكون بعد تاريخ بدايةالفصل الدراسي',

    //         'semester_in_fees.required' => 'نسبة رسوم الفصل الدراسي مطلوبة',
    //         'semester_in_fees.numeric' => 'نسبة رسوم الفصل الدراسي يجب ان تكون ارقام فقط',

    //         'semester_out_fees.required' => 'نسبة رسوم الانسحاب من الفصل الدراسي مطلوبة',
    //         'semester_out_fees.numeric' => 'نسبة  رسوم الانسحاب من الفصل الدراسي يجب ان تكون ارقام فقط',

    //         'year_id.required' => 'رجاء اختيار العام الدارسي',
    //         'year_id.exists' => 'العام الدارسي غير مسجل بالنظام .. رجاء الاختيار من القائمة',

    //     ];
    // }

}

