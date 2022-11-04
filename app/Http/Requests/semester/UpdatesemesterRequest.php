<?php

namespace App\Http\Requests\semester;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdatesemesterRequest extends GeneralRequest
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
            'semester_name' => 'required|'. Rule::unique('semesters')->where('year_id', $request->year)->ignore($request->semester->id),
            'semester_start' => 'required|date|before:semester_end',
            'semester_end' => 'required|date|after:semester_start',
            'semester_in_fees' => 'required|numeric',
            'semester_out_fees' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'year_name.required' => 'اسم الفصل الدراسي مطلوب',
            'year_name.unique' => 'اسم الفصل الدراسي مسجل مسبقا',

            'semester_start.required' => 'تاريخ بداية الفصل الدراسي مطلوب ',
            'semester_start.date' => 'صيغة تاريخ  بداية الفصل الدراسي غير صحيحة ',
            'semester_start.before' => 'تاريخ بداية الفصل الدراسي يجب ان يكون قبل تاريخ نهاية الفصل الدراسي ',

            'semester_end.required' => 'تاريخ نهاية الفصل الدراسي مطلوب',
            'semester_end.date' => 'صيغة تاريخ  نهاية الفصل الدراسي  غير صحيحة',
            'semester_end.before' => 'تاريخ نهاية الفصل الدراسي يجب ان يكون بعد تاريخ بدايةالفصل الدراسي',

            'semester_in_fees.required' => 'نسبة رسوم الفصل الدراسي مطلوبة',
            'semester_in_fees.numeric' => 'نسبة رسوم الفصل الدراسي يجب ان تكون ارقام فقط',

            'semester_out_fees.required' => 'نسبة رسوم الانسحاب من الفصل الدراسي مطلوبة',
            'semester_out_fees.numeric' => 'نسبة  رسوم الانسحاب من الفصل الدراسي يجب ان تكون ارقام فقط',

            'year_id.required' => 'رجاء اختيار العام الدارسي',
            'year_id.exists' => 'العام الدارسي غير مسجل بالنظام .. رجاء الاختيار من القائمة',

        ];
    }
}