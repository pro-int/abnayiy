<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransferRequestRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'payment_method_id' => 'required',
            'bank_id'    => 'bail|' . Rule::requiredIf(function () {
                return $this->payment_method_id == 1;
            }),
            'receipt' => Rule::requiredIf(function () {
                return $this->payment_method_id == 1;
            }) .'|file|mimes:jpg,jpeg,bmp,png,pdf|max:8192'
        ];
    }

    public function attributes()
    {
        return [
            'payment_method_id' => 'طريقة السداد',
            'bank_id' => 'البنك',
            'receipt' => 'ملف اثبات السداد',
        ];
    }
}
