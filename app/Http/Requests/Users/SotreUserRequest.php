<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\GeneralRequest;

class SotreUserRequest extends GeneralRequest
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
            'email'         => 'required|string|email|max:255|unique:users',
            'country_id'    => 'required',
            'password'      => 'required|min:8|confirmed',
            'phone'         => 'required|unique:users',
            'roles'         => 'requiredif:isAdmin,=,true',

            'nationality_id' => 'requiredif:isGuardian,=,true|numeric',
            'national_id'   => 'requiredif:isGuardian,=,true|numeric|unique:guardians',
            'address'       => 'requiredif:isGuardian,=,true|string',
            'city_name'     => 'nullable|string',
        ];
    }

    public function messages()
    {
        return  [
            'phone.digits' => 'ادخل رقم الهاتف بالصيغة الدولية مثال - 201xxxxxxxxx',
        ];
    }

    protected function prepareForValidation()
    {
         $this->merge([
            'isAdmin' => (bool) $this->isAdmin,
            'isGuardian' => (bool) $this->isGuardian,
            'isTeacher' => (bool) $this->isTeacher,
            'active' => (bool) $this->active,
            'guardian_active' => (bool) $this->guardian_active,
            'admin_active' => (bool) $this->admin_active,
            'teacher_active' => (bool) $this->teacher_active,
        ]);
    }

}
