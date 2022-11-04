<?php

namespace App\Http\Requests\application;

use App\Http\Requests\GeneralRequest;

class UpdateApplicationManagerRequest extends GeneralRequest
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
            'grade_id'     => 'required|array',
        ];
    }

    public function messages()
    {
        return
            [
                'grade_id'     => 'رجاء تحديد قسم واحد علي الاقل'
            ];
    }
}
