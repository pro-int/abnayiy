<?php

namespace Gtech\AbnayiyNotification\Traits;

use Gtech\AbnayiyNotification\Mail\NotificationEmail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Laravel\Facades\Telegram;

trait ChannelSenderTrait
{
    public function sendviaSms($channel)
    {
        if (env('TEST_MOOE') == true) {
            return [
                'sent' => true,
                'response' => 'النظام النجريبي : ' . $this->contents[$channel->content_name]
            ];
        }

        try {
            $config = $channel->config;
            $response = Http::get($config['url'], [
                'username' => $config['username'] ?? env('SMS_USERNAME', '05831115'),
                'password' => $config['password'] ?? env('SMS_PASSWORD', '123456'),
                'mobile' => $this->current_user->phone,
                'message' => $this->contents[$channel->content_name],
                'sender' =>  $config['sender'] ??  env('SMS_SENDER', 'NOBALA'),
                'unicodetype' => $config['unicodetype'] ?? 'u',
            ]);
            return [
                'sent' => true,
                'response' => $response
            ];
        } catch (\Throwable $th) {
            return [
                'sent' => false,
                'response' => $th->getMessage()
            ];
        }
    }

    public function sendviaWhatsapp($channel)
    {
        return   [
            'sent' => false,
            'response' => 'لم يتم اعاداد الارسال عن طريق وااتساب'
        ];
    }

    public function sendviaTelegram($channel)
    {
        try {
            if($this->current_user_settings->telegram_id){
                
                $response = Telegram::sendMessage([
                    'chat_id' => $this->current_user_settings->telegram_id,
                    'text' => $this->contents[$channel->content_name]
                ]);
                
                return [
                    'sent' => true,
                    'response' => $response->getMessageId()
                ];
            }
            return [
                'sent' => false,
                'response' => 'المستخدم لم يقم بتفغيل خدمة تليجرام'
            ];

        } catch (\Throwable $th) {
            return [
                'sent' => false,
                'response' => $th->getMessage()
            ];
        }
        
    }

    public function sendviaEmail($channel)
    {
        $details = [
            'title' => $this->contents['email_subject'],
            'body' => $this->contents['email_content']
        ];

        try {
        // Mail::to('test@ozmmar.com')->send(new NotificationEmail($details));
            // Mail::to($this->current_user->email)->send(new NotificationEmail($details));
            return [
                'sent' => true,
                'response' => 'msg sent'
            ];
        } catch (\Throwable $th) {
            return [
                'sent' => false,
                'response' => $th->getMessage()
            ];
        }
    }
}
