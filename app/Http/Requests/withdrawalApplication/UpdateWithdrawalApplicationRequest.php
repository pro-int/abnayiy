<?php

namespace App\Http\Requests\withdrawalApplication;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class UpdateWithdrawalApplicationRequest extends GeneralRequest
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
            'reason' => 'required|string',
            'comment' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'reason' => 'سبب الانسحاب',

            'comment' => 'تعليقك',
        ];
    }
}

