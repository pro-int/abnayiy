<?php

namespace App\Http\Requests\guardian\wallet;

use App\Http\Requests\GeneralRequest;

class StoreGuardianWalletRequest extends GeneralRequest
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
            'amount'            => 'required|numeric|min:1',
            'description'       => 'required|string',
            'transaction_type'  => 'required|in:withdraw,deposit',
            'receipt'           => 'requiredif:file_required,==,true|file|mimes:jpg,jpeg,bmp,png,pdf|max:8192',
        ];
    }

    function attributes()
    {
        return [
            'amount' => 'المبلغ',
            'receipt' => 'ايضال السداد',
            'description' => 'وصف الحركة',
            'transaction_type' => 'نوع العملية'
        ];
    }

    function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge([
            'file_required' => $this->guardian->hasWallet($this->wallet) && $this->guardian->getWallet($this->wallet)->slug == DEFAULT_WALLET_SLUG,
        ]);
    }
}
