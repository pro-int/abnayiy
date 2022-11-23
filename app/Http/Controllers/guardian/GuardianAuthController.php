<?php

namespace App\Http\Controllers\guardian;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\AcademicYear;
use App\Http\Requests\AcademicYear\StoreAcademicYearRequest;
use App\Http\Requests\AcademicYear\UpdateAcademicYearRequest;
use App\Models\Category;
use App\Models\guardian;
use App\Models\Mobile;
use App\Models\User;
use Carbon\Carbon;
use Gtech\AbnayiyNotification\ApplySingleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class GuardianAuthController extends Controller
{

    public function showRegistrationPage(){
        return view('auth.user.register');
    }

    public function userRegistration(RegisterRequest $request)
    {
        try {
            $user = DB::transaction(function () use ($request) {

                $new_user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => '966'. $request->phone,
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

            if ($user) {
                $role = Role::select("id")->where("name","parent")->first();
                $user->assignRole([$role->id]);
                return redirect()->route('showLoginPage')
                    ->with(["userRegistrationSuccessMessage" => 'تم تسجيل الدخول بنجاح !!']);
            } else {
                return redirect()->back()
                    ->with(["userRegistrationErrorMessage" => 'خطأ اثناء تسجيل الحساب']);
            }
        } catch (\Exception $th) {
            dd($th);
            info($th);
            return redirect()->back()
                ->with(["userRegistrationErrorMessage" => 'خطأ غير متوقع']);
        }
    }

    public function showLoginPage(){
        return view('auth.user.login');
    }

    public function userLogin(LoginRequest $request)
    {
        $request->phone = '966' . $request->phone;

        if (!Auth::attempt(["phone" => $request->phone, "password" => $request->password])) {
            return response()->json([
                'error' => 'رجاء التأكد رقم الجوال و كلمة المرور',
                'code' => 401,
                'message' => 'للاسف المعلومات التي ادخلتها لا تطابق البيانات المسجلة لدينا',
            ], 200);
        }

        if (!$request->has('code')) {
            $code = Mobile::where('phone', $request->phone)->where('activated', 0)->whereDate('created_at', '>=', Carbon::now()->subMinutes(2)->toDateTimeString())->first();
            $user = User::where('phone', $request->phone)->first();

            if (!$code) {
                Mobile::where('phone', $request->phone)->where('activated', 0)->delete();
                $new_code = rand(1000, 9999);
                $code = new Mobile();
                $code->code = $new_code;
                $code->phone = $request->phone;
                $code->save();
            }

            $notification = new ApplySingleNotification($code, 1, $user->id);
            $notification = $notification->fireNotification();

            return response()->json([
                'code' => 200,
                'message' => 'تم ارسال كود التحقق الي رقم الجوال',
            ], 200);
        }
        if(preg_match("@^\d{4}$@", $request->code)){
            $code = Mobile::where('phone', $request->phone)->where('activated', 0)->whereDate('created_at', '>=', Carbon::now()->subMinutes(30))->where('code', $request->code)->first();
        }else{
            $code = null;
        }
        if (!$code) {
            return response()->json([
                'error' => 'كود التحقق غير صحيح',
                'code' => 402,
                'message' => 'رجاء ادخال كود التحقق المرسل الي الجوال',
            ], 200);
        }

        $code->delete();

        if (!Auth::user()->guardian) {
            $defult_category = Category::where('is_default', true)->first();

            $new_guardian = new guardian();
            $new_guardian->guardian_id = Auth::id();
            $new_guardian->category_id = $defult_category ? $defult_category->id : null;
            $new_guardian->save();
        }

        $user = $this->getAuthUser();
        $role = Role::select("id")->where("name","parent")->first();
        $user->assignRole([$role->id]);
        if ($user) {
            return response()->json([
                'code' => 200,
                'message' => 'تم تسجيل الدخول بنجاح !!',
            ], 200);
        } else {
            return response()->json([
                'error' => 'ليس لديك صلاحية الدخول الي هذا النظام',
                'code' => 403,
                'message' => 'صلاحيات حسابك لا تسمح لك بالدخول علي هذا النظام',
            ], 200);
        }
    }

    public function getAuthUser()
    {
        return user::with(['guardian', 'guardian.students', 'guardian.applications', 'guardian.category'])->find(Auth::id());
    }

}
