<?php

namespace App\Http\Requests\grade;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateGradeRequest extends GeneralRequest
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
            'school_id' => 'required',
            'gender_id' => 'required|exists:genders,id',
            'grade_name' => 'required|string|' . Rule::unique('grades')->where('gender_id', $this->gender_id)->ignore($this->grade),
        ];

        // 'grade_name' => 'required|string|unique:grade_name,'. $this->grade_name .',id,grades,gender_id,'. $this->gender_id,
        // ]; //unique:office_schedules,day_of_week,' . $this->day->id . ',id,office_id,' . $this->office,
        // Rule::unique('semesters')->where('year_id', $request->year->id)->ignore($request->semester->id)

    }

    public function messages()
    {
        return  [

            'school_id.required' => 'رجاء المسار التعليمي',

            'gender_id.required' => 'رجاء اختيار االنوع',
            'gender_id.exists' => 'رجاء اختيار النوع من القائمة',

            'grade_name.required' => 'اسم المرحلة التعليمية مطلوب',
            'grade_name.string' => 'اسم المرحلة التعليمية يجب ان يكون حروف فقط',
            'grade_name.unique' => 'اسم المرحلة التعليمية مسجل مسبقا',

        ];
    }
}
