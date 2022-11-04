<?php

namespace App\Http\Requests\AppointmentSections;

use App\Http\Requests\GeneralRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentSectionRequest extends GeneralRequest
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
            'section_name' => 'required|string|'. Rule::unique('appointment_sections')->ignore(request('section')),
            'max_day_to_reservation' => 'required|integer|between:1,30'
        ];
    }


    public function attributes()
    {
        return [
            'section_name' => 'اسم القسم',
            'max_day_to_reservation' => 'اقصي موعد '
        ];
    }
}
