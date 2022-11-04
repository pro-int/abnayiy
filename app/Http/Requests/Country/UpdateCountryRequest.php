<?php

namespace App\Http\Requests\Country;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends GeneralRequest
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
            'country_name' => 'required|' . Rule::unique('countries')->ignore($request->country),
            'country_code' => 'required|' . Rule::unique('countries')->ignore($request->country),
        ];
    }

    public function messages()
    {
        return  [
            'country_name.required' => 'اسم الدولة مطلوب',
            'country_name.string' => 'اسم الدولة يجب ان يكون حروف فقط',
            'country_name.unique' => 'اسم الدولة مسجل مسبقا',

            'country_code.required' => 'اسم كود الدولة مطلوب',
            'country_code.numbers' => 'اسم كود الدولة يجب ان يكون ارقام فقط',
            'country_code.unique' => 'اسم كود الدولة مسجل مسبقا',
        ];
    }
}
