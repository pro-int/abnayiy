<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mobile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\schools\Boolean;
use App\Http\Requests\SendCodeMobileRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class MobileController extends Controller
{

    public function sendCode(Request $request)
    {
        try {
            if (!$phone = $this->getUserPhone($request)) {
                return $this->ApiErrorResponse(null, 400, 'لم يتم ارسال رقم الجوال المراد التحقق منة');
            }

            $code = Mobile::where('phone', $phone)->where('activated', 0)->whereDate('created_at', '>=', Carbon::now()->subMinutes(30))->first();

            if (!$code) {
                $new_code = rand(1000, 9999);
                $code = new Mobile();
                $code->code = $new_code;
                $code->phone = $phone;
                $code->save();
            }

            $message = 'كود التحقق الخاص بك هو : ' . $code->code;
            Mobile::Send_verify_code($code->phone, $message);

            $respons_text = auth()->check() ?  'تم ارسال كود التحقق الي رقم الجوال المسجل لدينا' : 'تم ارسال كود التحقق الي رقم الجوال ' . $phone;

            return $this->ApiSuccessResponse(['code' => (int) $code->code] ,$respons_text);

        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->ApiErrorResponse('خطا غير متوقع اثناء ارسال كود التخقق', 500, ['code' => 'فشل ارسال كود التحقق لاسباب تقنية. رجاء المحاولة لاحقا'] );
        }
    }

    public function verify(Request $request)
    {
        try {
            $phone = $this->getUserPhone($request);
            
            if (!$phone) {
                return $this->ApiErrorResponse(null, 400, 'لم يتم ارسال رقم الجوال المراد التحقق منة');
            }

            $code = Mobile::where('phone', $phone)->where('activated', 0)->whereDate('updated_at', '>=', Carbon::now()->subMinutes(30))->where('code', $request->code)->first();

            if ($code) {
                $code->delete();
                return $this->ApiSuccessResponse(['code_is_valid' => true]);
            }
            return $this->ApiErrorResponse('كود التحقق الذي تم ادخالة غير صحيح');
        } catch (\Throwable $th) {
            info($th);
            // check here
            return $this->ApiErrorResponse('خطا غير متوقع .. حاول مرة اخري',500,['code' => 'فشل التحقق من الكود لأسباب تقنية .. رجاء المحاولة مرة اخري']);
        }
    }

    protected function getUserPhone(Request $request)
    {
        if (auth()->check()) {
            return Auth::user()->phone;
        } else if ($request->filled('phone')) {
            return $request->phone;
        }
    }
}
