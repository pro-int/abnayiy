<?php

namespace App\Http\Requests\nationality;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdatenationalityRequest extends GeneralRequest
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
            'nationality_name' => 'required|'. Rule::unique('nationalities')->ignore($request->nationality),
            'vat_rate' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return  [

            'nationality_name.required' => 'اسم الدولة مسجل مسبقا',
            'nationality_name.string' => 'اسم الدولة يجب ان يكون حروف فقط',
            'nationality_name.unique' => 'اسم الدولة مسجل مسبقا',

            'vat_rate.required' => 'قيمة الضرائب مطلوبة',
            'vat_rate.numeric' => 'قيمة الضرائب يجب ان يكون ارقام فقط',
            'vat_rate.min' => 'قيمة الضرائب لا يمكن ان تكون اقل من 0',

        ];
    }
}

