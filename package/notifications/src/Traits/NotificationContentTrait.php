<?php

namespace Gtech\AbnayiyNotification\Traits;

use Gtech\AbnayiyNotification\Models\NotificationContent;

trait NotificationContentTrait
{

    public function prepareContent($model, $content_id)
    {
        $content = NotificationContent::select('notification_contents.*','notification_events.content_vars')
        ->leftjoin('notification_events','notification_events.id','notification_contents.event_id')
        ->find($content_id);

        if ($content) {
            $contents = [
                'sms_content'       =>  $content->sms_content,
                'internal_content'  =>  $content->internal_content,
                'email_content'     =>  $content->email_content,
                'email_subject'     =>  $content->email_subject,
                'telegram_content'  =>  $content->telegram_content,
                'whatsapp_content'  =>  $content->whatsapp_content,
            ];

            $vars = $content->content_vars;
            
            if (is_array($vars)) {
                foreach ($vars as  $put_in => $take_out) {
                    foreach ($contents as $key => $value) {
                        $contents[$key] = str_replace('%' . $take_out, $model->$put_in, $value);
                    }
                }
            }

            foreach ($contents as $key => $value) {
                $contents[$key] = preg_replace("/[%]\w+/", '', $value);
            }

            return $contents;
        }
        return [];
    }
}
