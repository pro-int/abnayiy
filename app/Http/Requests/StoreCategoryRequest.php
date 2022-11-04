<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'level_name' => 'required|string|unique:categories',
            'min_students'=> 'nullable|numeric',
        ];
    }
     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'level_name.required' => 'required|string|unique:categories',
            'level_name.string' => 'required|string|unique:categories',
            'level_name.unique' => 'required|string|unique:categories',
            'min_students'=> 'nullable|numeric',
        ];
    }
}
