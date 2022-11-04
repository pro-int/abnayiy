<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentTransportationRequest extends FormRequest
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
            'transportation_id' => 'required',
            'payment_type' => 'required',
            'expire_at' => 'nullable|date'
        ];
    }

    public function attributes()
    {
        return [
            'transportation_id' => 'خطة النقل',
            'payment_type' => 'طريقة السداد',
            'expire_at' => 'تاريخ انتهاء  الاشتراك'
        ];
    }
}
