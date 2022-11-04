<?php

namespace App\Http\Requests\type;

use App\Http\Requests\GeneralRequest;

class StoreTypeRequest extends GeneralRequest
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
            'type_name' => 'required|string|unique:types',
            'type_name_noor' => 'required|string',
        ];
    }

    public function messages()
    {
        return  [
            'type_name.required' => 'اسم المسار التعليمي مطلوب',
            'type_name.string' => 'اسم المسار التعليمي يجب ان يكون حروف فقط',
            'type_name.unique' => 'اسم المسار التعليمي مسجل مسبقا',

            'type_name_noor.required' => 'اسم المسار التعليمي في نظام نور مطلوب',
            'type_name_noor.string' => 'اسم المسار التعليمي في نظام نور يجب ان يكون حروف فقط',
            'type_name_noor.unique' => 'اسم المسار التعليمي في نظام نور مسجل مسبقا',
        ];
    }
}
