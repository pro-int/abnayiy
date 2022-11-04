<?php

namespace App\Http\Requests\guardian;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateGuardianRequest extends GeneralRequest
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
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'phone'         => 'required|string|digits:12|' . Rule::unique('users')->ignore($request->guardian->id),
            'email'         => 'required|string|email|max:255|' . Rule::unique('users')->ignore($request->guardian->id),
            'country_id'    => 'required',
            'password'      => 'nullable|required_with:change_password|min:8|confirmed',
            'nationality_id'=> 'required|numeric',
            'national_id'   => 'required|numeric|' . Rule::unique('guardians')->ignore($request->guardian->id,'guardian_id'),
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

