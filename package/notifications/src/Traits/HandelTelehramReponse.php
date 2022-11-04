<?php

namespace Gtech\AbnayiyNotification\Traits;

use App\Models\Mobile;
use App\Models\User;
use Gtech\AbnayiyNotification\ApplySingleNotification;
use Hamcrest\Type\IsCallable;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Laravel\Facades\Telegram;
use Gtech\AbnayiyNotification\Models\UserNotificationSetting;

trait HandelTelehramReponse
{

    protected $cache;
    protected $chat_id;
    protected $response;
    protected $message_id;
    protected $text;

    public function handelResponse($response)
    {
        $this->response = $response;

        $this->chat_id = $response['message']['chat']['id'];
        $this->message_id = $response['message']['message_id'];
        $this->cache = Cache::get($this->chat_id);
        $this->hasPindingResponse($response);
    }

    protected function hasPindingResponse()
    {
        $this->text = trim($this->response['message']['text']);
        if ($this->cache['action']) {
            call_user_func([$this, $this->cache['action']]);
        }
    }

    protected function CheckPhoneNumber()
    {

        if (!empty($this->text) && is_numeric($this->text) && strlen($this->text) == 12) {

            $user = User::where($this->cache['await'], $this->text)->first();
            if ($user) {

                $code = new Mobile();
                $code->code = rand(1000, 9999);
                $code->phone = $user->phone;
                $code->save();

                $Notification = new ApplySingleNotification($code,2,$user->id);
                if($Notification->fireNotification()) {
                    $message = 'تم ارسال رمز تحقق علي علي الجوال ' . $this->text . PHP_EOL . 'رجاء ارسالة في هذة المحادثة لتفعيل خدمة التليجرام';
                    cache::put($this->chat_id, ['phone' => $user->phone, 'action' => 'CheckPhoneCode', 'await' => 'code'], 1800);
                } else {

                    $message = 'تعذر ارسال كود التفعيل في الوقت الحالي رجاء المحاولة وفي واقت لاحق';
                }

            } else {
                $message = 'رقم الجوال ' . $this->text . PHP_EOL . ' غير مسجل لدينا ';
            }
        } else {
            if (!is_numeric($this->text)) {
                $message = 'رقم الجوال يجب ان يكون ارقام فقط بالصيغة الدولية' . PHP_EOL . ' مثال 966501234567';
            } else if (empty($this->text)) {
                $message = 'رجاء ارسال رقم الجوال بشكل صحيح';
            } else if (strlen($this->text) != 12) {
                $message = 'رقم الجوال يجب ان بالصيغة الدولية ' . PHP_EOL . ' مثال 966501234567';
            }
        }
        $this->sendMesg($message, $this->chat_id);
    }

    protected function CheckPhoneCode()
    {
        if (!empty($this->text) && is_numeric($this->text) && strlen($this->text) == 4) {

            $code = Mobile::where('code',$this->text)->first();
            if ($code) {
                $code->activated = 1;
                $code->save();

                $user = User::where('phone', $this->cache['phone'])->first();

                if ($user) {
                    $settings = UserNotificationSetting::where('user_id', $user->id)->first();
                    
                    if ($settings) {
                        $settings->telegram_id = $this->chat_id;
                    } else {
                        $settings = new UserNotificationSetting();
                        $settings->user_id = $user->id;
                        $settings->telegram_id = $this->chat_id;
                    }

                    $message = $settings->save() ? 'اهلا بك '. PHP_EOL .' تفغيل حدمة التليجرام بنجاح .. شكرا لاهتمامك بخدماتنا' : 'فشل تفغيل خدمة تليجرام حاول مرة اخري';
                
                } else {
                    $message = 'نعتذر رقم الجوال الذي ترغب تفعيلة غير مسجل بقاعدة البيانات لدينا';
                }
                Cache::forget($this->chat_id);

            } else {
                $message = 'رمز التحقق غير صحبح .. رجاء اعادة ارسال رمز التحقق المرسل الي الجوال';
            }
        } else {
            if (!is_numeric($this->text)) {
                $message = 'رمز التفعيل  يجب ان يكون ارقام فقط بالصيغة الدولية';
            } else if (empty($this->text)) {
                $message = 'رجاء ارسال رقم الجوال بشكل صحيح';
            } else if (strlen($this->text) != 4) {
                $message = 'رمز التفعيل يجب ان يكون 4 ارقام فقط ';
            }
        }
        $this->sendMesg($message, $this->chat_id);
    }
    protected function sendMesg($message, $chat_id)
    {
        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => $message
        ]);
    }
}
