<?php

namespace Gtech\AbnayiyNotification\Requests\Notifications;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class UpdateNotificationChannelRequest extends GeneralRequest
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
            'notification_name'    => 'required|string',
            'event_id'             => 'required|'. Rule::unique('notifications')->ignore(request()->notification->id),
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
