<?php

namespace App\Http\Requests\role;

use App\Http\Requests\GeneralRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRoleRequest extends GeneralRequest
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
            'name' => 'required|unique:roles|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'display_name' => 'required|unique:roles',
            'color' => 'required',
            'permission' => 'required',
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
            'name.required' => 'اسم الدور انجليزي مطلوب',
            'name.unique' => 'اسم الدور انجليزي مسجل مسبقا',
            'name.regex' => 'اسم الدور يجب ان يكون بالحروف الأنجليزية فقط وبدون مسافات',

            'display_name.required' => 'اسم الدور عربي مطلوب',
            'display_name.unique' => 'اسم الدور عربي مسجل مسبقا',

            'permission.required' => 'رجاء اختيار صلاحية واحدة علي الاقل لهذة الدور',

            'color.required' => 'رجاء اختيار اللون',
        ];
    }
}
