<?php

namespace App\Http\Requests\withdrawalApplication;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class StoreWithdrawalApplicationRequest extends GeneralRequest
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
            'student_id' => 'required|numeric|unique:withdrawal_applications',
            'reason' => 'required|string',
            'comment' => 'required|string|min:1|max:150',
            'school_name' => 'nullable|min:1|max:50',
            'date' => 'nullable|string'
        ];
    }

    public function attributes()
    {
        return [
            'student_id' => 'اسم الطالب',

            'reason' => 'سبب الانسحاب',

            'comment' => 'تعليقك',

            'date' => 'تاريخ الانسحاب',

            'school_name' => 'اسم المدرسه'

        ];
    }
}

