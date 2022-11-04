<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransferRequestRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (request()->isMethod('POST')) {
            return  [
                'plan_id' => 'required|exists:plans,id',
                'dept_to_pay' => 'required|numeric',
                'transportation_id'         => 'bail|required_If:transportation_required,==,true',
                'transportation_payment_id'    => 'bail|required_If:transportation_required,==,true',
                'payment_method_id' => 'bail|required',
                'receipt' => 'required_If:payment_method_id,==,1|file|mimes:jpg,jpeg,bmp,png,pdf',
                'bank_id' => 'required_If:payment_method_id,==,1',
            ];
        }

        return [];
    }

    public function attributes()
    {
        return [
            'plan_id' => 'خطة السداد',
            'dept_to_pay' => 'المديونيات',
            'transportation_id' => 'خطة النقل',
            'transportation_payment_id' => 'خطة سداد النقل',
            'bank_id' => 'البنك',
            'payment_method_id' => 'طريقة السداد',
            'receipt' => 'ملف اثبات السداد',
        ];
    }

    protected function prepareForValidation()
    {

        $transportation_payment_id = $this->transportation_payment_id;

        switch ($transportation_payment_id) {
            case 'annual_fees':
                $transportation_payment_id = 1;
                break;
            case 'semester_fees':
                $transportation_payment_id = 2;
                break;
            case 'monthly_fees':
                $transportation_payment_id = 3;
                break;
            case 'undefined':
                $transportation_payment_id = null;
                break;
            default:
                break;
        }

        $this->merge([
            'transportation_payment_id' =>  $transportation_payment_id,
            'transportation_required' => $this->transportation_required == 'true' ? true : false,
            'transportation_id' => $this->transportation_id == 'undefined' ? null : (int) $this->transportation_id,
        ]);
    }
}
