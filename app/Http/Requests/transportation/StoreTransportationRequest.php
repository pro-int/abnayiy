<?php

namespace App\Http\Requests\transportation;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;

class StoreTransportationRequest extends GeneralRequest
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
            'transportation_type' => 'required|string|unique:transportations',
            'annual_fees' => 'required|numeric',
            'semester_fees' => 'required|numeric',
            'monthly_fees' => 'required|numeric',
            'odoo_product_id' => 'Nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'transportation_type' => 'اسم الخطة',

            'annual_fees' => 'الرسوم السنوية',

            'semester_fees' => 'رسوم الفصل',

            'monthly_fees' => 'الرسوم الشهرية',

        ];
    }
}

