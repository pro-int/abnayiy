<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmail extends FormRequest
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
            'first_name'    => 'required|string|min:3|max:50',
            'last_name'     => 'required|string|min:3|max:50',
            'email'         => 'required|email|unique:users|max:50',
            'phone'         => 'required|min:7|max:10',
            'country_id'    => 'required|exists:countries,id',
            'password'      => 'required|min:6|confirmed',
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
            'first_name.max'            => 'الاسم الاول لا يمكن ان يكون اكبر من 50 حرف !! ',
            'first_name.max'            => 'الاسم الاول لا يمكن ان يكون اقل من 3 احرف !! ',

            'last_name.required'        => 'يجب ادخال اسم العائلة بشكل صحيح !!',
            'last_name.string'          => 'اسم العائلة يجب ان يكون حروف فقط !!',
            'last_name.max'             => 'اسم العائلة لا يمكن ان يكون اكبر من 50 حرف !! ',
            'last_name.max'             => 'اسم العائلة لا يمكن ان يكون اقل من 3 احرف !! ',

            'email.required'            => 'يجب ادخال البريد الأيكتروني بشكل صحيح !!',
            'email.string'              => 'البريد الألكتروني يجب ان يكون حروف و ارقام فقط !!',
            'email.max'                 => 'البريد الألكتروني لا يمكن ان يكون اكبر من 50 حرف !! ',
            'email.unique'              => 'البريد الألكتروني مسجل لدينا بالفعل !!',
            
            'country_id.required'       => 'رجاء اختيار رمز الدولة',
            'country_id.exists'         => 'اختر رمز الدولة',

            'phone.required'            => 'رجاء ادخال رقم الموبايل',
            'phone.numeric'             => 'رقم الجوال يجب ان يكون مكون من ارقام فقط',
            'phone.digits'              => 'رقم الموبايل يجب ان يكون مكون من 11 رقم',
            
            'password.required'         => 'يجب ادخال كلمة المرور !!',
            'password.min'              => 'لا يمك ان تكون اقل من 6 احرف !!',
            'password.confirmed'        => 'كلمة المرور غير متطابقة !!',
        ];
    }
}
