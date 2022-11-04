<?php

namespace App\Http\Requests\Appointments;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends GeneralRequest
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

            'day_of_week' => 'required|unique:office_schedules,day_of_week,' . $this->day->id . ',id,office_id,' . $this->office,
            'time_from' => 'required|before:time_to',
            'time_to' => 'required|after:time_from',

        ];
    }

    public function attributes()
    {
        return [
            'day_of_week' => 'اليوم',
            'time_from' => 'بداية المواعيد',
            'time_to' => 'نهاية المواعيد',
        ];
    }
}
