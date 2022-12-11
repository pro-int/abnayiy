<?php

namespace App\Http\Requests\plan;

use App\Http\Requests\GeneralRequest;

class StorePlanRequest extends GeneralRequest
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
            'plan_name' => 'required|string|unique:plans',
            'transaction_methods' => 'required|array',
            'contract_methods'=> 'required|array',
            'plan_based_on' => 'required',
            'odoo_id' => 'Nullable|string',
            'payment_due_determination' => 'requiredif:plan_based_on,semester,selected_date',
            'beginning_installment_calculation' => 'requiredif:plan_based_on,=,selected_date',
            'down_payment' => 'requiredif:plan_based_on,=,selected_date',
        ];
    }

    public function attributes()
    {
        return [
            'plan_name' => 'اسم خطة الدفع',
            'transaction_methods' => 'طرق الدفع بعد التعاقد',
            'contract_methods' => 'طرق الدفع  اثناء التعاقد',

        ];
    }

    public function messages()
    {
        return [
            'payment_due_determination.requiredif' => 'ادخل موعد الأستحاق',
            'beginning_installment_calculation.requiredif' => 'موعد اصدار القسط',
            'down_payment.requiredif' => 'ادخل قيمة الدفعة المقدمة',
        ];
    }

    protected function prepareForValidation()
    {

        $this->merge([
            'req_confirmation' => (bool) $this->req_confirmation
        ]);

        $this->merge([
            'active' => (bool) $this->active
        ]);

        $this->merge([
            'fixed_discount' => (bool) $this->fixed_discount
        ]);
    }
}
