<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRestLinkRequest;
use App\Http\Requests\ChangePasswordRequest;

use App\Models\Category;
use App\Models\guardian;
use App\Models\Mobile;
use Carbon\Carbon;
use Gtech\AbnayiyNotification\ApplySingleNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function Register(RegisterRequest $request)
    {

        try {
            $user = DB::transaction(function () use ($request) {

                $new_user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email' => time() . rand(100,1500) . '@temp.com',
                    'country_id' => env('default_country', 1),
                    'password' => Hash::make($request->password),
                ]);

                $defult_category = Category::where('is_default', true)->first();

                $guardian = new guardian();
                $guardian->guardian_id = $new_user->id;
                $guardian->nationality_id = $request->nationality_id;
                $guardian->category_id =  $defult_category ?  $defult_category->id : null;
                $guardian->save();
                return $new_user;
            });

            Auth::login($user);
            $token = $user->createToken('token')->plainTextToken;

            $cookie = cookie('abc', $token, 60 * 24 * 365, null, 'localhost'); // iyear
            if ($user) {
                return response()->json([
                    'done' => true,
                    'success' => true,
                    'message' => 'تم تسجيل الدخول بنجاح !!',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'userData' => $user
                ], 200)->withCookie($cookie);

                // return $this->login($request,true);
            } else {
                return $this->ApiErrorResponse('خطأ اثناء تسجيل الحساب');
            }
        } catch (\Exception $th) {
            info($th);
            return $this->ApiErrorResponse('خطأ غير متوقع');
        }
    }

    public function update(UpdateProfileRequest $request)
    {
        try {

            Log::info(Auth::id());
            $user = User::where('id', Auth::id())->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'country_id' => $request->country_id,
            ]);

            if ($user) {

                guardian::where('guardian_id', Auth::id())->update([
                    'nationality_id' =>  $request->nationality_id,
                    'city_name' =>  $request->city_name,
                    'address' =>  $request->address,
                    'national_id' =>  $request->national_id,
                ]);
                return $this->ApiSuccessResponse(null, 'تم تعديل الملف الشخصي بنجاح', true, true, 201);
            } else {

                return $this->ApiErrorResponse('خطأ غير متوقع', 201);
            }
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->ApiErrorResponse('خطأ غير متوقع', 500);
        }
    }
    public function login(LoginRequest $request)
    {
        # try to login
        $this->validate(
            $request,
            [
                'phone'             => 'required',
                'password'          => 'required|min:8',
            ],
            [
                'password.required'         => 'كلمة المرور مطلوبة',
                'password.confirmed'        => 'كلمة المرور غير متطابقة',
                'password.min'              => 'كلمة المرور يجب ان تكون 8 احرف علي الاـقل',
                'phone.required'            => 'رقم الجوال مطلوب',
            ]
        );

        if (!Auth::attempt($request->only(['phone', 'password']))) {

            return $this->ApiErrorResponse(
                'للاسف المعلومات التي ادخلتها لا تطابق البيانات المسجلة لدينا ',
                401,
                [
                    'phone' => 'رجاء التأكد رقم الجوال و كلمة المرور',
                ]
            );
        }

        if (!$request->has('code')) {

            $code = Mobile::where('phone', $request->phone)->where('activated', 0)->whereDate('created_at', '>=', Carbon::now()->subMinutes(30))->first();
            $user = User::where('phone', $request->phone)->first();

            if (!$code) {
                $new_code = rand(1000, 9999);
                $code = new Mobile();
                $code->code = $new_code;
                $code->phone = $request->phone;
                $code->save();
            }

            $notification = new ApplySingleNotification($code, 1, $user->id);
            $notification = $notification->fireNotification();
            

            $message = 'تم ارسال كود التحقق الي رقم الجوال';
            return $this->ApiSuccessResponse($code->code, $message);
        }

        $code = Mobile::where('phone', $request->phone)->where('activated', 0)->whereDate('created_at', '>=', Carbon::now()->subMinutes(30))->where('code', $request->code)->first();
        if (!$code) {
            return $this->ApiErrorResponse(
                'رجاء ادخال كود التحقق المرسل الي الجوال',
                401,
                [
                    'code' => 'كود التحقق غير صحيح',
                ]
            );
        }

        $code->delete();

        if (!Auth::user()->guardian) {
            $defult_category = Category::where('is_default', true)->first();

            $new_guardian = new guardian();
            $new_guardian->guardian_id = Auth::id();
            $new_guardian->category_id = $defult_category ? $defult_category->id : null;
            $new_guardian->save();
            $message = 'تم انشاء حساب ولي الامر بنجاح !!';
        }

        $user = $this->getAuthUser();

        if ($user) {
            $token = $user->createToken('token')->plainTextToken;

            $cookie = cookie('abc', $token, 60 * 24 * 365); // iyear

            return response()->json([
                'done' => true,
                'success' => true,
                'message' => isset($message) ? $message : 'تم تسجيل الدخول بنجاح !!',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'userData' => $user
            ], 200)->withCookie($cookie);
        } else {
            return $this->ApiErrorResponse(
                'صلاحيات حسابك لا تسمح لك بالدخول علي هذا النظام',
                401,
                [
                    'phone' => 'ليس لديك صلاحية الدخول الي هذا النظام',
                ]
            );
        }
    }

    public function getAuthUser()
    {
    return user::with(['guardian', 'guardian.students', 'guardian.applications', 'guardian.category'])->find(Auth::id());
    }

    public function user()
    {
        if (Auth::check()) {
            $user = $this->getAuthUser();
            // return $this->ApiSuccessResponse($user,'مرحبا بعودتك  ' . $user->first_name);
            return response()->json([
                'done' => true,
                'success' => true,
                'message' => 'مرحبا بعودتك  ' . $user->first_name,
                'userData' => $user
            ]);
        }
        return $this->ApiErrorResponse('رجاء تسجيل الدخول اولا', 401);
    }

    public function logout(Request $request)
    {
        $token = ($request->header('authorization'));
        if ($token) {
            $pice1 = explode(' ', $token);
            $id = explode('|', $pice1[1]);
        }

        Session::flush([]);

        foreach (Auth::user()->tokens as $token) {
            if ($token->id == $id[0]) {
                $token->delete();
            } else {
                // Log::alert($token);
            }
        }

        $cookie = cookie::forget('abc');
        // check here
        return response()->json([
            'done' => true,
            'success' => false,
            'message' => 'تم تسجيل الخروج بنجاح',
        ], 200)->withCookie($cookie);
    }

    // public function SendPasswordRestLink(SendPasswordRestLinkRequest $request)
    // {

    //     try {

    //         $user = User::where('email', $request->email)->first();
    //         if (!$user) {
    //             # code...
    //             // return response()->json([
    //             //     'errors' => ['email' => ['هذا البريد غير مسجل لدينا.']]
    //             // ], 201);
    //             return $this->ApiErrorResponse(null, 201, ['email' => ['هذا البريد غير مسجل لدينا.']]);
    //         }

    //         DB::table('password_resets')->where('email', $request->email)->delete();

    //         $token = Str::random(100);

    //         $insert = DB::table('password_resets')->insert([
    //             'email' => $request->email,
    //             'token' => $token,
    //             'created_at' => Carbon::now()
    //         ]);

    //         $reset_link = env('APP_URL') . '/reset-password/' . $token;
    //         $user->notify(new SendResetPasswordLink($reset_link));

    //         if ($insert) {
    //             # code...
    //             // return response()->json([
    //             //     'message' => 'تم ارسال رابط اعادة تعيين كلمة المرور .. رجاء مراجعة بريدك الاليكتروني .'
    //             // ], 200);
    //             return $this->ApiSuccessResponse(null, 'تم ارسال رابط اعادة تعيين كلمة المرور .. رجاء مراجعة بريدك الاليكتروني .');
    //         }
    //     } catch (\Throwable $th) {
    //         // return response()->json([
    //         //     'errors' => ['userEmail' => ['خطا غير متوقع .. رجاء المحاولة في وقت لاحق.']]
    //         // ], 500);
    //         return $this->ApiErrorResponse(null, 500, ['userEmail' => ['خطا غير متوقع .. رجاء المحاولة في وقت لاحق.']]);
    //     }
    // }
    public function sendPasswordResetCode(ResetPasswordRestLinkRequest $request)
    {
        try {
            if ($request->filled('code')) {

                $code = Mobile::where('phone', $request->phone)->where('activated', 0)->whereDate('created_at', '>=', Carbon::now()->subMinutes(30))->where('code', $request->code)->first();

                if (!$code) {
                    $message = ' يرجى التأكد من الكود او رقم الجوال';
                    $errors = [
                        'code_is_valid' => false,
                        'code' => 'كود التحقق غير صحيح '
                    ];
                    return $this->ApiErrorResponse($message, 422, $errors);
                }

                $code->activated = 1;
                $code->save();
                $user = User::where('phone', $request->phone)->first(); //(['password' => $request->password]);
                if ($user) {
                    $user->password = Hash::make($request->password);

                    if ($user->save())
                        $data = ['code_is_valid' => true];
                    $message = 'تم تغيير كلمة المررو بنجاح .. يمكنك الان تسجيل الدخول بأستخادم كلمة المرور الجديدة.';
                    return $this->ApiSuccessResponse($data, $message);
                }
                $message = ' لم يتم العثور علي المستخدم';
                $errors = [
                    'code_is_valid' => false,
                    'phone' => 'تاكد من رقم الجوال'
                ];
                return $this->ApiErrorResponse($message, 422, $errors);
            } else {

                $phone = $request->phone;
                $user = User::where('phone', $phone)->first();

                if (!$user) {
                    $message = ' يرجى التأكد من رقم الجوال';
                    $errors = [
                        'phone' => 'رقم الجوال غير صحيح '
                    ];
                    return $this->ApiErrorResponse($message, 404, $errors);
                }

                $code = Mobile::where('phone', $phone)->where('activated', 0)->whereDate('created_at', '>=', Carbon::now()->subMinutes(30))->first();

                if (!$code) {
                    $new_code = rand(1000, 9999);
                    $code = new Mobile();
                    $code->code = $new_code;
                    $code->phone = $phone;
                    $code->save();
                }
                $message = 'تم ارسال كود التحقق الي رقم الجوال';
                $message_code = 'كود التحقق الخاص بك هو : ' . $code->code;

                Mobile::Send_verify_code($code->phone, $message_code);

                return $this->ApiSuccessResponse($code->code, $message);
            }
        } catch (\Throwable $th) {
            info($th);
            return $this->ApiErrorResponse(null, 500, ['phone' => ['خطا غير متوقع .. رجاء المحاولة في وقت لاحق.']]);
        }
    }

    // public function sendPasswordResetCode(ResetPasswordRestLinkRequest $request)
    // {

    //     try {
    //         $exire = Carbon::now()->subDay();

    //         if (!$resetRequest = DB::table('password_resets')->where('token', $request->token)->where('email', $request->email)->whereDate('created_at', '>=', $exire)->first()) {
    //             // return response()->json([
    //             //     'message' => 'الرابط الذي اتبعتة غير صحيح او منتهي الصلاحية او ربما قد تم استدامة مسبقا .. رجاء ارسال طلب جديد لاستعادة كلمة المرور.'
    //             // ], 201);
    //             return $this->ApiErrorResponse('الرابط الذي اتبعتة غير صحيح او منتهي الصلاحية او ربما قد تم استدامة مسبقا .. رجاء ارسال طلب جديد لاستعادة كلمة المرور.' ,201);
    //         }

    //         # request founded
    //         User::where('email', $resetRequest->email)
    //             ->update([
    //                 'password' => Hash::make($request->password)
    //             ]);
    //         DB::table('password_resets')->where('token', $request->token)->delete();
    //         // return response()->json([
    //         //     'message' => 'تم تغيير كلمة المررو بنجاح .. يمكنك الان تسجيل الدخول بأستخادم كلمة المرور الجديدة.'
    //         // ]);
    //         return $this->ApiSuccessResponse(null, 'تم تغيير كلمة المررو بنجاح .. يمكنك الان تسجيل الدخول بأستخادم كلمة المرور الجديدة.');
    //     } catch (\Throwable $th) {
    //         // return response()->json([
    //         //     'message' => 'حدث خطأ داخلي اثناء عملية تغيير كلمة المرور رجاء المحاولة مرة اخري.'
    //         // ], 500);
    //         return $this->ApiErrorResponse('حدث خطأ داخلي اثناء عملية تغيير كلمة المرور رجاء المحاولة مرة اخري.',500);
    //     }
    // }
    public function changepassword(ChangePasswordRequest $request)
    {
        #change ussr password
        info($request);

        if (Hash::check($request->oldPassword, auth()->user()->password)) {
            // $passowrd = Hash::make($request->password);

            User::find(auth()->user()->id)->update(['password' => $request->password]);

            return $this->ApiSuccessResponse(null, 'تم تغيير كلمة المرور بنجاح');
        } else {
            return $this->ApiErrorResponse(null, 422, ['oldPassword' => 'كلمة المرور الحالية غير صحيحة']);
        }
    }
}
