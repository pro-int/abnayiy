<?php

namespace App\Http\Requests\Noor\Account;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;

class UpdateNoorAccountRequest extends GeneralRequest
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
            'username' => 'required|string|unique:noor_accounts,id',
            'password' => 'nullable|string',
            'school_name' => 'nullable|string',
            'account_name' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'اسم المستخدم',
            'password' => 'كلمة المرور',
            'school_name' => 'اسم المدرية',
            'account_name' => 'اسم الحساب',

        ];
    }

    protected function prepareForValidation()
    {     
        $this->merge([
            'updated_by' => auth()->user()->id]);

        if ($this->filled('new_password')) {
            $this->merge([
                'password' => $this->new_password]);        }

    }
}

