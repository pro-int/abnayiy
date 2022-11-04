<?php

namespace App\Http\Requests\ClassRoom;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class UpdateClassRoomRequest extends GeneralRequest
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
            'class_name' => 'required|string|' . Rule::unique('class_rooms')->where('level_id', $this->level_id)->where('academic_year_id', $this->year)->ignore($this->classroom->id),
            'level_id' => 'required|exists:levels,id',
            'school_id' => 'required|exists:types,id',
            'gender_id' => 'required|exists:genders,id',
            'grade_id' => 'required|exists:grades,id',
        ];
    }

    public function messages()
    {
        return  [
            'class_name.required' => 'اسم الفصل مطلوب',
            'class_name.string' => 'اسم الفصل يجب ان يكون حروف فقط',
            'class_name.unique' => 'اسم الفصل مسجل مسبقا',

            'level_id.required' => 'رجاء النظام المرحلة الدراسية',
            'level_id.exists' => 'رجاء اختيار النظام المرحلة الدراسية من القائمة',

            'school_id.required' => 'رجاء النظام التعليمي',
            'school_id.exists' => 'رجاء اختيار النظام التعليمي من القائمة',

            'gender_id.required' => 'رجاء اختيار االنوع',
            'gender_id.exists' => 'رجاء اختيار النوع من القائمة',

            'grade_id.required' => 'اسم المرحلة التعليمية مطلوب',
            'gender_id.exists' => 'رجاء اختيار المرحلة من القائمة',
        ];
    }
}
