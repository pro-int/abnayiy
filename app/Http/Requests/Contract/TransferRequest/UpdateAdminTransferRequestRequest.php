<?php

namespace App\Http\Requests\Contract\TransferRequest;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class UpdateAdminTransferRequestRequest extends GeneralRequest
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
            'attach_pathh' => 'nullable|file|mimes:jpg,jpeg,bmp,png,pdf',
            'method_id' => 'required',
            'bank_id' => 'requiredIf:method_id,1',
            'confirmed' => 'required'
        ];
    }

    function messages()
    {
        return [
            'confirmed.required' => 'رجاء تأكيد استلام الدفعة'
        ];
    }

    public function attributes()
    {
        return [
            'attach_pathh' => 'ملف اثبات السداد',
            'method_id' => 'طريقة السداد',
            'bank_id' => 'البنك'
        ];
    }
}
