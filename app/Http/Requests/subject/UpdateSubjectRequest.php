<?php

namespace App\Http\Requests\subject;
use Illuminate\Http\Request;
use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends GeneralRequest
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
            'subject_name' => 'required|string|'. Rule::unique('subjects')->ignore($request->subject->id),
        ];
    }
    public function attributes()
    {
        return [
            'subject_name' => 'اسم الماده الدراسية',

        ];
    }
}
