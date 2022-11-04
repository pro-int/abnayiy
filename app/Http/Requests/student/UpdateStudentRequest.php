<?php

namespace App\Http\Requests\student;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\MaxWordsRule;
class UpdateStudentRequest extends GeneralRequest
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
            'student_name'              => ['bail','required','string',new MaxWordsRule()],
            'birth_place'               => 'bail|string',
            'national_id'               => 'bail|numeric|'. Rule::unique('students')->ignore($request->student),
            'birth_date'                => 'bail|date',
            'student_care'              => 'bail|boolean',
            'nationality_id'            => 'bail|numeric',
        ];
    }

            /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'student_name' => 'اسم الطالب'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'student_care' => (bool) $this->student_care,
            'allow_late_payment' => (bool) $this->allow_late_payment
        ]);
    }
}
