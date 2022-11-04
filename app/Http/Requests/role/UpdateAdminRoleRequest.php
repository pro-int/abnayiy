<?php

namespace App\Http\Requests\role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateAdminRoleRequest extends FormRequest
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
    public function rules(Request $request)
    {
       return [
            'name' => 'required|regex:/(^([a-zA-Z]+)(\d+)?$)/u|' . Rule::unique('roles')->ignore($request->role->id),
            'display_name' => 'required|' . Rule::unique('roles')->ignore($request->role->id),
            'color' => 'required',
            'permission' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الدور انجليزي مطلوب',
            'name.unique' => 'اسم الدور انجليزي مسجل مسبقا',
            'name.regex' => 'اسم الدور يجب ان يكون بالحروف الأنجليزية فقط',

            'display_name.required' => 'اسم الدور عربي مطلوب',
            'display_name.unique' => 'اسم الدور عربي مسجل مسبقا',

            'permission.required' => 'رجاء اختيار صلاحية واحدة علي الاقل لهذة الدور',

            'color.required' => 'رجاء اختيار اللون',
        ];
    }
}
