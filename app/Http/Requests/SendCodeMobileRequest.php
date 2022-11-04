<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendCodeMobileRequest extends FormRequest
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
            'phone' => 'required|numeric',
            'country_code' => 'required|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
    */
    public function messages()
    {
        return [
            'phone.required' => 'رقم الجوال مطلوب',
            'phone.numeric' => 'رقم الجوال يمكن ان يكون ارقام فقط',
            'country_code.required' => 'كود الدولة مطلوب',
            'country_code.numeric' => 'كود الدولة يمكن ان يكون ارقام فقط',
        ];
    }
}
