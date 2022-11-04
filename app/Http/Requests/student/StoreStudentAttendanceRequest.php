<?php

namespace App\Http\Requests\student;

use App\Http\Requests\GeneralRequest;

class StoreStudentAttendanceRequest extends GeneralRequest
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
            'class_id' => 'required|numeric',
            'absent_date' => 'required|date',
        ];
    }

    public function nessages()
    {
        return [
            'class_id.required' => 'تعذر العثور علي الفصل لتسجيل الغياب',
            'class_id.numeric' => 'تعذر العثور علي الفصل لتسجيل الغياب',

            'absent_date.required' => 'required|date',
            'absent_date.date' => 'required|date',
        ];
    }
}
