<?php

namespace App\Http\Requests\withdrawalPeriod;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class StoreWithdrawalPeriodRequest extends GeneralRequest
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
            'period_name' => 'required|string',
            'apply_start' => 'required|date|before:apply_end',
            'apply_end' => 'required|date|after:apply_start',
            'fees_type' => 'required',
            'fees' => $this->getFeesValidationRule()
        ];
    }

    private function getFeesValidationRule(){
        if($this->fees_type == "money"){
            return "required|integer";
        }
        return "required|integer|between:1,100";
    }


    public function attributes()
    {
        return [
            'period_name' => 'اسم الفترة',

            'apply_start' => 'تاريح البدء',

            'apply_end' => 'تاريخ الأنتهاء',

            'academic_year_id' => 'السنة الدراسية',

            'fees_type' => 'الرسوم المستخدمة',

            'fees' => 'المبلغ المستحق'

        ];
    }
}

