<?php

namespace App\Http\Requests\Corporate;

use App\Http\Requests\GeneralRequest;

class StoreCorporateRequest extends GeneralRequest
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
            'corporate_name' => 'required|string|unique:corporates'
        ];
    }

    public function attribute()
    {
        return [
            'corporate_name' => 'اسم المجمع'
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge([
            'created_by' => auth()->id()]);
    }
    
}
