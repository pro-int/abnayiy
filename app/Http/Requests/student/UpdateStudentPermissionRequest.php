<?php

namespace App\Http\Requests\student;

use App\Http\Requests\GeneralRequest;

class UpdateStudentPermissionRequest extends GeneralRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'case_id' => 'required|numeric|exists:permission_cases,id'
        ];
    }

    public function attributes()
    {
        return [
            'case_id' => 'الحالة',
        ];
    }
}
