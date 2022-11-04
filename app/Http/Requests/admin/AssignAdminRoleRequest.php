<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\GeneralRequest;

class AssignAdminRoleRequest extends GeneralRequest
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
            'user_id'       => 'bail|required|exists:users,id|unique:admins,admin_id',
            'roles'         => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'user_id'       => 'المدير',
            'roles'         => 'الدور',
        ]; 
    }

}
