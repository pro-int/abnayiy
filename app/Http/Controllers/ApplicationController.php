<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Http\Requests\application\ApplicationReuest;
use App\Http\Requests\application\EditApplicationReuest;
use App\Http\Traits\ManageAppointments;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Discount;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\guardian;
use App\Models\Level;
use App\Models\Period;
use App\Models\Plan;
use App\Models\User;
use Gtech\AbnayiyNotification\ApplySingleNotification;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    use ManageAppointments;
    // user side functions
    public function store(ApplicationReuest $request)
    {
        // handel new application after validation is passed "ApplicationReuest"
        if ($request->filled('verify_application')) {
            return  $this->ApiSuccessResponse(['data_valid' => true]);
        }

        try {
            $user = User::whereHas('guardian')->with('guardian')->find(Auth::id());

            if ($user) {
                // get gender 
                $gender = Gender::findOrFail($request->gender_id);
                $level = Level::select('grade_id')->findOrFail($request->level_id);
                $grade = Grade::select('appointment_section_id')->findOrFail($level->grade_id);

                $new_meetig = $this->bookNewAppointment($request, $grade->appointment_section_id, Auth::id());

                if ($new_meetig['success']) {

                    $application = new Application();
                    $application->student_name = $request->student_name;
                    $application->birth_place = $request->birth_place;
                    $application->national_id = $request->national_id;
                    $application->birth_date = $request->birth_date;
                    $application->student_care = $request->student_care;
                    $application->nationality_id = $request->nationality_id;
                    $application->plan_id = $request->plan_id;
                    $application->status_id = env('default_application_status', 1);
                    $application->gender = $gender->gender_type;
                    $application->level_id = $request->level_id;
                    $application->academic_year_id = $request->academic_year_id;
                    $application->guardian_id = Auth::id();
                    $application->appointment_id = $new_meetig['appointment']->id;
                    $application->transportation_id = $request->transportation_required ? $request->transportation_id : null;
                    $application->transportation_payment = $request->transportation_required ? $request->transportation_payment : null;

                    if ($application->save()) {

                        $new_application = Application::select('applications.*', 'schools.school_name', 'levels.level_name', 'grades.grade_name', 'genders.gender_name', 'application_statuses.status_name', 'reserved_appointments.appointment_time', 'reserved_appointments.selected_date', 'appointment_sections.section_name', 'appointment_offices.office_name', 'appointment_offices.employee_name', 'appointment_offices.phone')
                            ->leftjoin('reserved_appointments', 'reserved_appointments.id', 'applications.appointment_id')
                            ->leftjoin('appointment_sections', 'appointment_sections.id', 'reserved_appointments.section_id')
                            ->leftjoin('appointment_offices', 'appointment_offices.id', 'reserved_appointments.office_id')
                            ->leftjoin('levels', 'levels.id', 'applications.level_id')
                            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
                            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
                            ->leftjoin('schools', 'schools.id', 'genders.school_id')
                            ->leftjoin('application_statuses', 'application_statuses.id', 'applications.status_id')
                            ->where('applications.id', $application->id)->first();

                        $nNotification = new ApplySingleNotification($application, 5);
                        $nNotification->fireNotification();

                        return $this->ApiSuccessResponse(['application' => $new_application], 'تم تقديم الطلب بنجاح');
                    }
                    $application->delete();
                } else {
                    $error_msg = 'موعد المقابلة المحدد لم يعد متاح .. رجاء اختيار موعد اخر';
                    $code = 404;
                }
            } else {
                $error_msg = 'نعتذر .. خطأ غير متوقع اثناء تقديم الطلب ';
                $code = 402;
            }
        } catch (\Throwable $th) {
            Log::debug($th);
            $error_msg = 'نعتذر .. خطأ غير متوقع اثناء تقديم الطلب';
            $code = 500;
        }
        return $this->ApiErrorResponse($error_msg, $code);
    }

    public function update(EditApplicationReuest $request)
    {
        // handel application edit after validation is passed "EditApplicationReuest"
        try {
            // find application by national_id
            $application = Application::where('national_id', $request->national_id)->where('guardian_id', Auth::user()->guardian->id)->first();
            if ($application) {
                # application founded

                $application->student_name = $request->student_name;
                $application->birth_date = $request->birth_date;
                $application->gender = $request->gender;
                $application->student_care = $request->student_care;
                $application->school_id = $request->school_id;
                $application->level_id = $request->level_id;
                $application->grade_id = $request->grade_id;
                $application->save();

                if ($application) {
                    return $this->ApiSuccessResponse($application, 'تم تعديل الطلب بنجاح');
                } else {
                    return $this->ApiErrorResponse('نعتذر .. خطأ غير متوقع اثناء تعديل الطلب ');
                }
            } else {
                return $this->ApiErrorResponse('لم يتم العثور علي الطلب المطلوب تعديلة', 200);
            }
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->ApiErrorResponse('نعتذر .. خطأ غير متوقع اثناء تعديل الطلب ', 500);
        }
    }

    function application_info($id)
    {
        # get single applcation info if $reuest has id
        try {
            $applications = Application::select('applications.*', 'schools.school_name', 'levels.level_name', 'grades.grade_name', 'genders.gender_name', 'application_statuses.status_name')
                ->leftjoin('levels', 'levels.id', 'applications.level_id')
                ->leftjoin('grades', 'grades.id', 'levels.grade_id')
                ->leftjoin('genders', 'genders.id', 'grades.gender_id')
                ->leftjoin('schools', 'schools.id', 'genders.school_id')
                ->leftjoin('application_statuses', 'application_statuses.id', 'applications.status_id')
                ->where('applications.guardian_id', Auth::id())->orderBy('applications.id');

            // ->where('guardian_id', Auth::user()->guardian->id);

            if ($id == 'all') {
                $applications = $applications->where('applications.status_id', '<=', 4)->get();
            } else {
                $applications = $applications->where('applications.id', $id)->get();
            }
            return $this->ApiSuccessResponse($applications);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->ApiErrorResponse('خطأ غير متوقع', 500);
        }
    }

    // public function input_data(Request $request)
    // {
    //     if ($request->has('to_return') && !empty($request->to_return)) {
    //         switch ($request->to_return) {
    //             case 'school_id':
    //                 return School::where('active', true)->select('id', 'school_name')->get();
    //                 break;

    //             case 'gender_id':
    //                 if ($request->has('school_id') && !empty($request->school_id)) {
    //                     return Gender::where('active', true)->where('school_id', $request->school_id)->select('id', 'gender_name')->get();
    //                 }
    //                 break;

    //             case 'grade_id':
    //                 if (!empty($request->gender_id)) {
    //                     return Grade::where('active', true)->where('gender_id', $request->gender_id)->select('id', 'grade_name')->get();
    //                 }
    //                 break;

    //             case 'level_id':
    //                 if (!empty($request->grade_id)) {
    //                     return Level::where('active', true)->where('grade_id', $request->grade_id)->select('id', 'level_name')->get();
    //                 }
    //                 break;
    //             default:
    //                 # code...
    //                 break;
    //         }
    //     }
    // }

    /**
     * Update Payment plan and transportation.
     *
     * @return \Illuminate\Http\Response
     */

    public function selectPlan(EditApplicationReuest $request)
    {

        if ($request->isMethod('post')) {
            return $this->update_plan($request);
        }
        return $this->get_plan($request);
    }

    public function update_plan(EditApplicationReuest $request)
    {
        $application = Application::find($request->application_id);
        # application founded
        if ($application && $application->guardian_id == Auth::id() && $application->status_id <= 3) {

            $application->plan_id  = $request->plan_id;
            if ($request->transportation_required) {
                $application->transportation_id = $request->transportation_id;
                $application->transportation_payment = $request->transportation_payment;
            }

            if ($application->save()) {
                return $this->ApiSuccessResponse(null, 'تم تحديث معلومات الطلب بنجاح');
            }
            return $this->ApiErrorResponse('خطأ اثناء تحديث معلومات الطلب ', 401);
        }
        return $this->ApiErrorResponse('لم يتم العثور علي الطلب الذي ترغب في تعديلة ');
    }

    public function get_plan(EditApplicationReuest $request)
    {
        # select student payment plan

        $application = Application::find($request->application_id);
        # application founded
        if ($application
            /** && $application->guardian_id == Auth::id()**/
        ) {

            $level = Level::find($application->level_id);

            # level founded
            if ($level) {
                $AcademicYear = $this->GetAdmissionAcademicYear();
                $period = currentPeriod($AcademicYear);
                $plans = Plan::select('id', 'plan_name', 'installments')->where('active', 1)->get();
                $categoty = guardian::getCategory($application->guardian_id);

                $period_id = $period->id ?? null;
                // create empty array to hold plans data
                // $plans_data = array();
                foreach ($plans as $plan) {
                    # loop for plans
                    $discount = Discount::Get_discounts_info($level->id, $plan, $period_id, $categoty->id);
                    if ($discount) {
                        $discount_ammount = round($level->tuition_fees * ($discount->rate / 100), 2);
                        # discount founded , push to $plans_data
                        $plan->ammount_before_discount = $level->tuition_fees;
                        $plan->discount_rate = $discount->rate;
                        $plan->discount_ammount = $discount_ammount;
                        $plan->ammount_after_discount = round($level->tuition_fees - $discount_ammount, 2);
                        $plan->valid_until = $period->apply_end ?? null;
                        $plan->is_discounted = true;
                    } else {
                        # discount founded , push to $plans_data
                        $plan->ammount_before_discount = $level->tuition_fees;
                        $plan->is_discounted = false;
                    }
                }
                return $this->ApiSuccessResponse($plans);
            }
        }
        return $this->ApiErrorResponse('نعتذر .. خطأ غير متوقع اثناء حساب قيمة الرسوم ');
    }
}
