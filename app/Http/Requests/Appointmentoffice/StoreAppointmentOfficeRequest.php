<?php

namespace App\Http\Requests\Appointmentoffice;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class StoreAppointmentOfficeRequest extends GeneralRequest
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
            'office_name' => 'required|string|unique:appointment_offices',
            'employee_name' => 'required|string',
            'phone' => 'required|numeric',
            'sections' => 'required|exists:appointment_sections,id',
        ];
    }

    public function messages()
    {
        return  [
            'office_name.required' => 'اسم المكتب مطلوب',
            'office_name.string' => 'اسم المكتب يجب ان يكون حروف فقط',
            'office_name.unique' => 'اسم المكتب مسجل مسبقا',
            'employee_name.required' => 'اسم الموظف مطلوب',
            'employee_name.string' => 'اسم الموظف يجب ان يكون حروف فقط',
            'phone.numeric' => 'رقم الجوال يجب ان يكون ارقام فقط ',
            'sections.required' => 'رجاء اختيار الاقسام',
        ];
    }
}
