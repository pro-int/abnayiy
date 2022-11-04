<?php

namespace Gtech\AbnayiyNotification\Controllers;

use App\Http\Controllers\Controller;
use Gtech\AbnayiyNotification\Traits\HandelTelehramReponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Traits\CommandsHandler;

class TelegramNotificationController extends Controller
{
    use HandelTelehramReponse, CommandsHandler;

    public function update(Request $request)
    {
        $token = env('TELEGRAM_API_TOKEN', 'JBQGRlwFjLTxH6QdcYcpZYVRdRb12Cfu');
        if ($request->token == $token) {
            # match token ...
            $res = Telegram::commandsHandler(true);
            if (isset($res['message'])) {
                $chat_id = $res['message']['chat']['id'];
    
                if (!$res->message->entities) {
                    if (Cache::has($chat_id)) {
                        $this->handelResponse($res);
                    } else {
                        $this->sendMesg('عفوا لم نتمكن من معالجة الرسالة بشكل صحيح .. الأختيار من القائمة', $res['message']['chat']['id']);
                        Telegram::triggerCommand('start', $res);
                    }
                }
            } else {
                info('Telegram controller , cant handel message');
                Log::debug($res);
            }
        }

        return 'ok';
    }
}
