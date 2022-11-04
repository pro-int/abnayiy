<?php

namespace Gtech\AbnayiyNotification\Requests\Content;

use App\Http\Requests\GeneralRequest;

class StoreNotificationContentRequest extends GeneralRequest
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
            'content_name'            => 'required|string',
            'sms_content'             => 'required|string',
            'email_subject'           => 'required|string',
            'internal_content'        => 'required|string',
            'email_content'           => 'required|string',
            'telegram_content'        => 'required',
            'whatsapp_content'        => 'required',
            'event_id'                => 'required',
            
        ];
    }

    public function attributes()
    {
        return [
            'content_name'            => 'اسم المحتوي',
            'sms_content'             => 'محتوي الرسائل',
            'email_subject'             => 'عنوان رسالة البريد',
            'internal_content'        => 'المحتوي الداخلي',
            'email_content'           => 'محتوي البريد',
            'telegram_content'        => 'محتوي التليجرام',
            'whatsapp_content'        => 'محتوي واتساب',
            'event_id'                => 'المناسبة',
        ];
    }
}
