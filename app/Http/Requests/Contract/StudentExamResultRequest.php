<?php

namespace App\Http\Requests\Contract;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentExamResultRequest extends GeneralRequest
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
            'sheet_path' => 'required|mimes:xlsx,xls',
            'academic_year_id' => 'required|exists:academic_years,id',
            'exam_result' => 'required|in:1,2',
            'ignore_old_result' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'sheet_path' => 'ملف نتائج الطلاب',
            'exam_result' => 'نتيجة الطلاب',
            'ignore_old_result' => 'الاجراء في حالة وجود نتائج سابقة'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'ignore_old_result' => (bool) $this->ignore_old_result]);
    }
}
