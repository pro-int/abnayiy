<?php

namespace App\Http\Requests\type;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateTypeRequest extends GeneralRequest
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
            'type_name' => 'bail|required|string|' . Rule::unique('types')->ignore($request->type),
        ];
    }

    

    public function messages()
    {
        return [
            'type_name.required' => 'اس المسار التعليمي مطلوب',
            'type_name.string' => 'اسم المسار التعليمي يجب ان يكون حروف فقط',
            'type_name.unique' => 'اسم المسار التعليمي مسجل مسبقا',
        ];
    }
}
