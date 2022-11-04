<?php

namespace App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class NewMeetingRequest extends FormRequest
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
            'online' => 'bail|required|boolean',
            'selected_date' => 'bail|required|date|after_or_equal:' . Carbon::now()->addDay()->toDateString(),
            'selected_time' => 'bail|required|date_format:H:i:s|before_or_equal:' . Carbon::parse(env('MEETING_TO'))->format('H:i:s') . '|after_or_equal:' . Carbon::parse(env('MEETING_FROM'))->format('H:i:s'),
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
            'online.required' => 'رجاء اختيار مكان المقابلة',
            'online.boolean' => 'مكان المقابلة غير صحيح',

            'selected_date.required' => 'رجاء تحديد التاريخ اولا',
            'selected_date.date' => 'صيغة التاريخ غير صحيحة',
            'selected_date.after_or_equal' => 'لا يمكن اختيار تاريخ قبل : ' . Carbon::now()->addDay()->format('d-m-Y'),

            'selected_time.required' => 'رجاء تحديد ميعاد المقابلة اولا',
            'selected_time.date_format' => 'صيغة موعد المقابلة غير صحيحة',
            'selected_time.before_or_equal' => 'لا يمكن اختيار ميعاد بعد الساعة : ' . Carbon::parse(env('MEETING_TO'))->format('h:i:s A'),
            'selected_time.after_or_equal' => 'لا يمكن اختيار ميعاد قبل الساعة : ' . Carbon::parse(env('MEETING_FROM'))->format('h:i:s A'),
        ];
    }
}
