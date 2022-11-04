<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\GeneralRequest;

class StoreAdminRequest extends GeneralRequest
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
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'phone'         => 'required|string|digits:12|unique:users',
            'email'         => 'required|string|email|max:255|unique:users',
            'country_id'    => 'required',
            'password'      => 'required|min:8|confirmed',
            'roles'         => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'first_name'    => 'الاسم الاول',
            'last_name'     => 'الاسم الاخير',
            'phone'         => 'رقم الجوال',
            'email'         => 'البريد الألكتروني',
            'country_id'    => 'الدولة',
            'password'      => 'كلمة المرور',
            'roles'         => 'الدور',
        ]; 
    }

    public function messages()
    {
        return  [
            'phone.digits' => 'ادخل رقم الجوال بالصيغة الدولية مثال - 966500000313',
        ];
    }

}
