<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'phone'             => 'required',
            'password'          => 'required|min:8',
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
            'password.required'         => 'كلمة المرور مطلوبة',
            'password.confirmed'        => 'كلمة المرور غير متطابقة',
            'password.min'              => 'كلمة المرور يجب ان تكون 8 احرف علي الاـقل',
            'phone.required'            => 'رقم الجوال مطلوب',
            'phone.digits'              => 'رقم الجوال يجب ان يكون 11 رقم',
        ];
    }
}
