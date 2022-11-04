<?php

namespace Gtech\AbnayiyNotification\Requests\Notifications\Types;

use App\Http\Requests\GeneralRequest;

class StoreNotificationTypeRequest extends GeneralRequest
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
            'type'              => 'required',
            'frequent'          => 'required',
            'target_user'       => 'required',
            'content_id'        => 'required_unless:frequent,frequent',
            'to_notify'         => 'required_unless:target_user,user',
            'channels'          => 'required_unless:type,internal'
        ];
    }

    public function attributes()
    {
        return [
            'type'              => 'النوع',
            'frequent'          => 'التكرار',
            'target_user'       => 'الهدف',
            'content_id'        => 'المحتوي',
            'to_notify'         => 'المديرين',
            'channels'         => 'قنوات الأرسال',
        ];
    }
}
