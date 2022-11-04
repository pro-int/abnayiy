<?php

namespace App\Http\Requests\student;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreStudentPermissionRequest extends FormRequest
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
            'student_id' => 'required|numeric|'. Rule::exists('students','id')->where('guardian_id',Auth::id()),
            'pickup_persion' => 'required|string',
            'pickup_time' => 'required|after:'. Carbon::now(),
            'permission_reson' => 'required|string',
            'permission_duration' => 'required|string',
        ];
    }

    public function messages()
    {
        return ['student_id.exists' => 'لم يتم العثور علي الطالب في قاعدة البيانات'];
    }

    public function attributes()
    {
        return [
            'student_id' => 'الطاب',

            'pickup_persion' => 'من سيأخذ الطال',

            'pickup_time' => 'وقت الأستأذان',

            'permission_reson' => 'سبب الأستأذان',

            'permission_duration' => 'مدة الأستأذان',

        ];
    }
}
