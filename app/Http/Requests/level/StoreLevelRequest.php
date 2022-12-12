<?php

namespace App\Http\Requests\level;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreLevelRequest extends GeneralRequest
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
            'level_name' => 'required|string|'. Rule::unique('levels')->where('grade_id', '=', $request->grade_id),
            'school_id' => 'required|exists:types,id',
            'gender_id' => 'required|exists:genders,id',
            'grade_id' => 'required|exists:grades,id',
            'tuition_fees' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return  [
            'level_name.required' => 'اسم الصف مطلوب',
            'level_name.string' => 'اسم الصف يجب ان يكون حروف فقط',
            'level_name.unique' => 'اسم الصف مسجل مسبقا',

            'school_id.required' => 'رجاء النظام التعليمي',
            'school_id.exists' => 'رجاء اختيار النظام التعليمي من القائمة',

            'gender_id.required' => 'رجاء اختيار القسم',
            'gender_id.exists' => 'رجاء اختيار القسم من القائمة',

            'grade_id.required' => 'اسم المرحلة التعليمية مطلوب',
            'gender_id.exists' => 'رجاء اختيار المرحلة من القائمة',

            'tuition_fees.required' => 'الرسوم الدراسية مطلوبة',
            'tuition_fees.numeric' => 'الرسوم الدراسية يمكن ان تكون ارقام فقط',

        ];
    }
}
