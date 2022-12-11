<?php

namespace App\Http\Requests\gender;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class UpdategenderRequest extends GeneralRequest
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
            'school_id' => 'required|exists:schools,id',
            'gender_name' => 'required|' . Rule::unique('genders')->where('school_id', $request->school_id)->ignore($request->gender),
            'odoo_product_id' => 'Nullable|string',
            'odoo_account_code' => 'Nullable|string',
            'gender_type' => 'required|string|',
            'grade_name_noor' => 'required|string'
        ];
    }

    public function messages()
    {
        return  [
            'school_id.required' => 'رجاء النظام التعليمي',
            'school_id.exists' => 'رجاء اختيار النظام التعليمي من القائمة',
            'gender_name.required' => 'اسم القسم مطلوب',
            'gender_name.unique' => 'اسم القسم مسجل مسبقا في نفس المدرسة',

            'gender_type.required' => 'النوع مسجل مسبقا ينفس المسار',
            'gender_type.string' => 'اسم النوع يجب ان يكون حروف فقط',
            'gender_type.unique' => 'النوع مسجل مسبقا ضمن نفس النظام التعليمي',

            'grade_name_noor.required' => 'اسم المرحلة التعليمية بنظام نور مطلوب',
            'grade_name_noor.string' => 'اسم المرحلة التعليمية بنظام نور يجب ان يكون حروف فقط',
        ];
    }

    public function attributes()
    {
        return  [
            'school_id' => 'النظام التعليمي',
            'gender_type' => 'النوع',
        ];
    }

}
