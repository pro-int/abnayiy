<?php

namespace App\Http\Requests\paymentNetwork;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;

class StorePaymentNetworkRequest extends GeneralRequest
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
            'network_name' => 'required|string|unique:payment_networks',
            'account_number' => 'required|string',
        ];
    }
}
