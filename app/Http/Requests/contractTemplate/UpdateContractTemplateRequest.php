<?php

namespace App\Http\Requests\contractTemplate;

use App\Http\Requests\GeneralRequest;

class UpdateContractTemplateRequest extends GeneralRequest
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
            'school_name' => 'Nullable|string',
            'school_logo' => 'Nullable|image',
            'school_watermark' => 'Nullable|image',
        ];
    }
}
