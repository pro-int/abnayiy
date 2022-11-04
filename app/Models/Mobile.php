<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Mobile extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'country_code',
        'phone',
        'activated'
    ];


    public static function Send_verify_code($phone, $message)
    {
        $response = Http::get('http://www.shamelsms.net/api/httpSms.aspx', [
            'username' => env('SMS_USERNAME', '05831115'),
            'password' => env('SMS_PASSWORD', '123456'),
            'mobile' => $phone,
            'message' => $message,
            'sender' => env('SMS_SENDER', 'NOBALA'),
            'unicodetype' => 'u',
        ]);
        return $response;
    }

    public static function Send_text_msg($message,$user_id = null)
    {
        if (null !== $user_id) {
            $user = User::findOrFail($user_id);
            $phone = $user->phone;
        } else {
            $phone = Auth::user()->phone;
        }

        $response = Mobile::Send_verify_code($phone, $message);
        return $response;
    }

    public static function getInternalUrl()
    {
    return '';
    }
}
