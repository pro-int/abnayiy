<?php

namespace App\Http\Requests\Corporate\School;

use App\Http\Requests\GeneralRequest;

class UpdateSchoolRequest extends GeneralRequest
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
            'school_name' => 'required|string|unique:schools,school_name,'. $this->school,
            'corporate_id' => 'required|string|exists:corporates,id',
        ];
    }

    
    public function attribute()
    {
        return [
            'school_name' => 'اسم المدرسة',
            'corporate_id' => 'المجمع'
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge([
            'updated_by' => auth()->id()]);
    }
}
