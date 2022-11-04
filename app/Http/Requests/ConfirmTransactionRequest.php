<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmTransactionRequest extends FormRequest
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
            // 'approved' => 'required',
            'received_ammount' => 'required|numeric',
            'attach_pathh' => 'nullable|file|mimes:jpg,jpeg,bmp,png,pdf',
        ];
    }
}
