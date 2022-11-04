<?php

namespace App\Http\Requests\guardian;

use App\Http\Requests\GeneralRequest;

class StoreGuardianRequest extends GeneralRequest
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
            'nationality_id' => 'required|numeric',
            'national_id'   => 'required|numeric|unique:guardians',
            'city_name'     => 'nullable|string',
            'address'       => 'required|string',
        ];
    }

    function attributes()
    {
        return [
            'الاسم الأول',
            'الاسم الاخير',
            'رقم الجوال',
            'البريد الاليكتروني',
            'الدولة',
            'كلمة المرور',
            'الجنسية',
            'رقم الخوية',
            'المدينة',
            'العنوان'
        ];
    }
}
