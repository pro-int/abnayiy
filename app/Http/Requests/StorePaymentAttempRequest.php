<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentAttempRequest extends GeneralRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [

            'requested_ammount' => 'nullable|numeric|lte:max_amount',
            'method_id' => 'required',
            'coupon' => 'nullable|string',
            'receipt' => 'required_If:method_id,==,1|file|mimes:jpg,jpeg,bmp,png,pdf|max:8000',
            'bank_id' => 'required_If:method_id,==,1',
            'payment_network_id' => 'required_If:method_id,==,4',
        ];
    }
    public function messages():array
    {
        return [
            'receipt.max' => ' صورة الايصال لا يجب ان تكون اكبر من ٨ ميجا',
        ];
    }
    public function attributes():array
    {
        return [
            'requested_ammount' => 'قيمة الدفعة',
            'receipt' => 'صورة الايصال'
        ];
    }
}
