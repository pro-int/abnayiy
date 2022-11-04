<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordByCodeRequest;
use App\Models\Mobile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminResetPassword extends Controller
{
    public function resetPasswordSendSmsCode()
    {
        return view('auth.passwords.reset_password');
    }
    public function resetPasswordBySmsCode(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric',
         
        ],[
            'phone.required' => 'رقم الجوال مطلوب',
            
        ]);
       
        $phone = $request->phone;
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            $message = ' يرجى التأكد من رقم الجوال';
           
            return redirect()->back()
                ->with('alert-danger', $message);
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
        info($code->code);
        $s = Mobile::Send_verify_code($code->phone,$message);
        return view('auth.passwords.confirm_code_for_password');
    }

    public function confirmCodeChangePasswordPage()
    {
       return view('auth.passwords.confirm_code_for_password');
    }
    public function confirmCodeChangePassword(ResetPasswordByCodeRequest $request)
    {
        $code = Mobile::where('phone', $request->phone)->where('activated', 0)->whereDate('created_at', '>=', Carbon::now()->subMinutes(30))->where('code', $request->code)->first();
        
        if ($code) {
            $code->activated = $request->activated = 1;
            $code->save();
            $passowrd = Hash::make($request->password);
            // dd($passowrd);
            $user = User::where('phone', $request->phone)->update(['password' => $passowrd]);
            
            return redirect()->route('login')->with('alert-success', 'تم تغير الباسورد بنجاح');
        } else {
            $message = ' يرجى التأكد من الكود او رقم الجوال';
            
            return redirect()->route('get.confirm_code')->with('alert-danger', $message);
        }
        
    }
}
