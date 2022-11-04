<?php

namespace App\Http\Requests\ContractTerms;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;


class StoreContractTermsRequest extends GeneralRequest
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
            'content' =>'required|string',
            'version' =>'required|integer',
            'is_default' => Rule::unique('contract_terms')->where('is_default', true)
        ];
    }
   
    protected function prepareForValidation()
    {
       $this->merge([
            'is_default' => (bool) $this->is_default,
        ]);
    }
    public function messages()
    {
        return [
            'is_default.unique' => 'لا يمكن اختيار اكتر من  شروط ك شروط افتراضية',
        ];
    }

}
