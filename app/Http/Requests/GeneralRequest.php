<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class GeneralRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        isset($this->is_default) &&  $this->merge([
            'is_default' => (bool) $this->is_default,
        ]);

        $this->merge([
            'active' => (bool) $this->active]);
    }
    
    protected function failedValidation(Validator $validator)
    {
        info($validator->errors());
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}
