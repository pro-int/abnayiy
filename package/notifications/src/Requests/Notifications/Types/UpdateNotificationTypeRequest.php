<?php

namespace Gtech\AbnayiyNotification\Requests\Notifications\Types;

use App\Http\Requests\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateNotificationTypeRequest extends GeneralRequest
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

    public function rules(Request $request)
    {
        return [
            'content_id'      => Rule::requiredIf($request->type->getRawOriginal('frequent') == 'single'),
            'to_notify'       => Rule::requiredIf($request->type->getRawOriginal('target_user') == 'admin'),
            'channels'       => Rule::requiredIf($request->type->getRawOriginal('type') == 'external'),
        ];
    }

    public function attributes()
    {
        return [
            'notification'    => 'الأشعار',
            'frequent'        => 'التكرار',
            'target_user'     => 'الهدف',
            'content_id'      => 'المحتوي',
            'to_notify'       => 'المديرين',
            'channels'         => 'قنوات الأرسال',

        ];
    }

}
