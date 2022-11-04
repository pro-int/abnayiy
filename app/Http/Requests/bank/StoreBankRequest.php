<?php

namespace App\Http\Requests\bank;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;

class StoreBankRequest extends GeneralRequest
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
            'bank_name' => 'required|string|unique:banks',
            'account_number' => 'required|string',
        ];
    }
}
