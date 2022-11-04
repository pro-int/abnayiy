<?php

namespace App\Http\Requests\Contract;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentDebtsRequest extends GeneralRequest
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
        ];
    }

    public function attributes()
    {
        return [
            'sheet_path' => 'ملف مديونيات الطلاب',
        ];
    }

}
