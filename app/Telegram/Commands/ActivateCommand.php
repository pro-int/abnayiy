<?php

namespace App\Telegram\Commands;

use Gtech\AbnayiyNotification\Models\UserNotificationSetting;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class ActivateCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "activate";

    /**
     * @var string Command Description
     */
    protected $description = "تفعيل استلام الرسائل";

    /**
     * @inheritdoc
     */
    public function handle()
    {

        $this->replyWithChatAction(['action' => Actions::TYPING]);
        
        $chat_id = $this->getUpdate()->getChat()->id;
        $settings = UserNotificationSetting::where('telegram_id', $chat_id)->first();

        if ($settings) {
            $this->replyWithMessage(['text' => 'الحساب الذي تحاول تفعيلة مرتبط حاليا بحساب اخر لدينا'.PHP_EOL . 'لأعادة تفعيل الحساب يمكنك الضفط علي اللامر التالي']);
            $this->replyWithMessage(['text' => '/stop']);
            
        } else {
            $this->replyWithMessage(['text' => 'لتفعيل خدمة استلام الرسائل عن طريق تطبيق تلجيرام .. يرجي ارسال  رقم الجوال المسجل لدينا']);
            
            Cache::put($chat_id, ['action' => 'CheckPhoneNumber', 'await' => 'phone'], 1800);
        }
    }
}
