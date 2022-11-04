<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name'        => 'required|min:3|max:20',
            'last_name'         => 'required|min:3|max:20',
            'phone'             => 'required|numeric|unique:users|digits:12',
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
            'first_name.required'       => 'يجب ادخال الاسم الاول بشكل صحيح !!',
            'first_name.string'         => 'الاسم الاول يجب ان يكون حروف فقط !!',
            'first_name.max'            => 'الاسم الاول لا يمكن ان يكون اكبر من 20 حرف !! ',
            'first_name.min'            => 'الاسم الاول لا يمكن ان يكون اقل من 3 احرف !! ',


            'last_name.required'       => 'يجب ادخال الاسم الاخير بشكل صحيح !!',
            'last_name.string'         => 'الاسم الاخير يجب ان يكون حروف فقط !!',
            'last_name.max'            => 'الاسم الاخير لا يمكن ان يكون اكبر من 20 حرف !! ',
            'last_name.min'            => 'الاسم الاخير لا يمكن ان يكون اقل من 3 احرف !! ',

            'email.required'         => 'البريد الألكتروني مطلوب',
            'email.email'         => 'ادخل البريد الألكتروني بشكل صحيح',
            'email.unique'         => 'البريد الأليكتروني مسجل لدينا بالفعل',
            'email.max'         => 'البريد الأليكتروني يجب ان يكون اقل من 50 حرف',


            // 'country_id.required'         => 'رجاء اختيار الدولة',

            'password.required'         => 'كلمة المرور مطلوبة',
            'password.confirmed'         => 'كلمة المرور غير متطابقة',
            'password.min'         => 'كلمة المرور يجب ان تكون 8 احرف علي الاـقل',

            'phone.required'         => 'رقم الجوال مطلوب',
            'phone.unique'         => 'رقم الجوال مسجل لدينا بالفعل',
            'phone.numeric'         => 'رقم الجوال يجب ان يكون ارقام فقط',
            'phone.digits'         => 'رجاء ادخال رقم الجوال بالصيغة الدولية',

        ];
    }

     protected function prepareForValidation()
    {
     $this->merge([
         'phone' => preg_replace('/\D/', '', $this->phone),
        ]);
    }
}