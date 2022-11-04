<?php

namespace Gtech\AbnayiyNotification\Requests\Notifications\Frequent;

use App\Http\Requests\GeneralRequest;

class StoreNotificationFrequentRequest extends GeneralRequest
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
            'condition_type'              => 'required',
            'interval'          => 'required|numeric|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'condition_type'              => 'اليرط',
            'interval'          => 'التوقيت',
        ];
    }
}
