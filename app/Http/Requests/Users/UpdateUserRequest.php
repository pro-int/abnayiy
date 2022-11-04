<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends GeneralRequest
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
        $rules =  [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|' . Rule::unique('users')->ignore($this->user->id),
            'country_id'    => 'required',
            'phone'         => 'required|' . Rule::unique('users')->ignore($this->user->id),
            'roles'         => 'requiredif:isAdmin,=,true',
            'job_title'     => 'requiredif:isAdmin,=,true',
            'vendor_name'     => 'requiredif:isVendor,=,true|' . Rule::unique('vendors')->ignore($this->user->id, 'user_id'),
            'vendor_slug'     => 'requiredif:isVendor,=,true|' . Rule::unique('vendors')->ignore($this->user->id, 'user_id'),
        ];

        if ($this->change_password) {
            array_push($rules, ['password' => 'required|min:8|confirmed']);
        }

        return $rules;
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
            'change_password' => (bool) $this->change_password,
            'active' => (bool) $this->active,
            'password' => $this->change_password ? $this->password : null,
            'password_confirmation' => $this->change_password ? $this->password_confirmation : null,

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
