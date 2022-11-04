<?php

namespace App\Http\Requests\Corporate\School;

use Illuminate\Foundation\Http\FormRequest;

class IndexSchoolRequest extends FormRequest
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
            'corporate' => 'sometimes|string',
        ];
    }

}
