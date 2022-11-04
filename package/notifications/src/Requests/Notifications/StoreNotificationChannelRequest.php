<?php

namespace Gtech\AbnayiyNotification\Requests\Notifications;

use App\Http\Requests\GeneralRequest;

class StoreNotificationChannelRequest extends GeneralRequest
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
            'notification_name'    => 'required|string',
            'event_id'             => 'required:unique:notifications',
        ];
    }

    public function attributes()
    {
        return [
            'notification_name'            => 'وصف الاشعار',
            'event_id'             => 'المناسبة',
        ];
    }
}
