<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'oldPassword'                       => 'required',
            'password'                          => 'required|confirmed|min:6',
            'password_confirmation'             => 'required',
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
            'oldPassword.required'              => 'كلمة المرور الحالية مطلوبة',

            'password.required'                 => 'كلمة المرور الجديدة مطلوبة',
            'password.confirmed'                => 'كلمة المرور الجديدة مغير متطابقة',
            'password.min'                      => 'كلمة المرور لا يمكن ان يكون اقل من 6 حروف',

            'password_confirmation.required'    => 'تأكيد كلمة المرور مطلوب',
        ];
    }
}
