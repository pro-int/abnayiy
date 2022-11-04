<?php

namespace App\Telegram\Commands;

use Gtech\AbnayiyNotification\Models\UserNotificationSetting;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StopCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "stop";

    /**
     * @var string Command Description
     */
    protected $description = "ايقاف  استلام الاشعارات عن طريق تليجرام";

    /**
     * @inheritdoc
     */
    public function handle()
    {

        $this->replyWithChatAction(['action' => Actions::TYPING]);
        
        $chat_id = $this->getUpdate()->getChat()->id;
        $settings = UserNotificationSetting::where('telegram_id', $chat_id)->first();

        if ($settings) {
            $settings->telegram_id = null;
            $settings->save();
            
            $this->replyWithMessage(['text' => 'تم الغاء تنشيط الحساب بنجاح']);
            
        } else {
            
            $this->replyWithMessage(['text' => 'الحساب الذي طلبت ايقاف تفعيلة غير مسجل دلينا .. لتفعيل الحساب اضغط علي الامر التالي']);
            $this->replyWithMessage(['text' => '/activate']);
        }
    }
}
