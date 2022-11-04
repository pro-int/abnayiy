<?php

namespace App\Http\Requests\grade;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreGradeRequest extends GeneralRequest
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
        info($request);

        return [
            'school_id' => 'required|exists:types,id',
            'gender_id' => 'required|exists:genders,id',
            'grade_name' => 'required|string|' . Rule::unique('grades')->where('gender_id', $request->gender_id),
        ];
    }

    public function messages()
    {
        return  [
            
            'school_id.required' => 'رجاء المسار التعليمي',
            'school_id.exists' => 'رجاء اختيار النظام التعليمي من القائمة',

            'gender_id.required' => 'رجاء اختيار االنوع',
            'gender_id.exists' => 'رجاء اختيار النوع من القائمة',

            'grade_name.required' => 'اسم المرحلة التعليمية مطلوب',
            'grade_name.string' => 'اسم المرحلة التعليمية يجب ان يكون حروف فقط',
            'grade_name.unique' => 'اسم المرحلة التعليمية مسجل مسبقا',
        ];
    }
}