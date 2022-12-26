<?php

namespace App\Http\Requests\gender;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Boolean;

class StoregenderRequest extends GeneralRequest
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
            'gender_name' => 'required|' . Rule::unique('genders')->where('school_id', $request->school_id),
            'gender_type' => 'required|integer',
            'odoo_product_id_study' => 'Nullable|string',
            'odoo_account_code_study' => 'Nullable|string',
            'odoo_product_id_transportation' => 'Nullable|string',
            'odoo_account_code_transportation' => 'Nullable|string'
        ];
    }

    public function messages()
    {
        return  [
            'school_id.required' => 'رجاء اختيار المدرسة',
            'school_id.exists' => 'رجاء اختيار اختيار المدرسة من القائمة',

            'gender_name.required' => 'اسم القسم مطلوب',
            'gender_name.unique' => 'اسم القسم مسجل مسبقا في نفس المدرسة',
            'gender_type.required' => 'القسم مسجل مسبقا ينفس المسار',
            'gender_type.string' => 'اسم القسم يجب ان يكون حروف فقط',
            'gender_type.unique' => 'القسم مسجل مسبقا ضمن نفس اختيار المدرسة',
        ];
    }
}
