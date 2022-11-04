<?php

namespace Gtech\AbnayiyNotification\Requests\setting;

use App\Http\Requests\GeneralRequest;

class UpdateNotificationSettingRequest extends GeneralRequest
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

    public function rules()
    {
        return [
            'channels'            => 'required|array',            
        ];
    }

    public function attributes()
    {
        return [
            'channels'            => 'قنوات الأرسال',
        ];
    }

}
