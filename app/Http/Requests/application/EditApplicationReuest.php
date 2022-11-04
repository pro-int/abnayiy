<?php

namespace App\Http\Requests\application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EditApplicationReuest extends FormRequest
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
        if ($request->isMethod('post')) {
            return [
                'plan_id'                   => 'required|numeric',
                'transportation_required'   => 'bail|required|boolean',
                'transportation_id'         => 'bail|' . Rule::requiredIf(function () use ($request) {
                    return $request->transportation_required;
                }),
                'transportation_payment'    => 'bail|' . Rule::requiredIf(function () use ($request) {
                    return $request->transportation_required;
                }),
            ];
        } else {
            return [];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'plan_id'                   => 'خطة السداد',
            'transportation_required'   => 'خدمة النقل',
            'transportation_id'         => 'نوع النقل',
            'transportation_payment'    => 'طريقة سداد النقل',
        ];
    }
}
