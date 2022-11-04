<?php

namespace App\Http\Requests\subject;

use App\Http\Requests\GeneralRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubjectRequest extends GeneralRequest
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
            'subject_name' => 'required|string|' . Rule::unique('subjects')->where('level_id', request()->level),
            'min_grade' => 'required|Numeric|min:0|max:100',
            'max_grade' => 'required|Numeric|min:0|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'subject_name' => 'اسم الماده الدراسية',
            'min_grade' => 'درجة النجاح',
            'max_grade' => 'الدرجة النهائية'
        ];
    }
}
