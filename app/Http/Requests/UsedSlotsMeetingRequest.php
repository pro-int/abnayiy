<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
class UsedSlotsMeetingRequest extends FormRequest
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
            'selected_date' => 'bail|required|date|after_or_equal:' . Carbon::now()->addDay()->toDateString(),
            'grade_id' => 'required'
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
            'selected_date.required' => 'رجاء تحديد التاريخ اولا',
            'selected_date.date' => 'صيغة التاريخ غير صحيحة',
            'selected_date.after_or_equal' => 'لا يمكن اختيار تاريخ قبل : ' . Carbon::now()->addDay()->format('d-m-Y'),
        ];
    }
}
