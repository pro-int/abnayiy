<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Events\UpdateDiscount;
use App\Http\Controllers\Controller;
use App\Http\Traits\ManageAppointments;
use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\CouponClassification;
use App\Models\Discount;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\guardian;
use App\Models\Level;
use App\Models\Plan;
use App\Models\ReservedAppointment;
use App\Models\Transportation;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\Tr;
use App\Models\Student;


class AdminJsonController extends Controller
{
    use ManageAppointments;

    public function index(Request $request)
    {
        if (is_callable(AdminJsonController::class . '::' . $request->methodName)) {
            return call_user_func(AdminJsonController::class . '::' . $request->methodName, $request);
        }
    }

    protected function Main_data(Request $request)
    {
        $genders = new Gender();
        $grades = new Grade();
        $levels = new Level();

        return $this->ApiSuccessResponse([
            'genders' => $genders->genders(false),
            'schools' => schools(null,true),
            'levels' => $levels->levels(false),
            'grades' => $grades->grades(false),
        ]);
    }

    protected function UpdateDiscount(Request $request)
    {
        try {
            $updatedBy = Auth::id();
            if ($request->has('plans') && is_array($request->plans)) {
                foreach ($request->plans as $plan) {
                    if ($plan['value'] > 100) {
                        $plan['value'] = 100;
                    } else if ($plan['value'] < 0) {
                        $plan['value'] = 0;
                    }

                    Discount::updateOrCreate(
                        ['period_id' => $request->period_id, 'category_id' => $request->category_id, 'level_id' => $request->level_id, 'plan_id' => $plan['plan_id']],
                        ['rate' => $plan['value'], 'period_id' => $request->period_id, 'category_id' => $request->category_id, 'level_id' => $request->level_id, 'plan_id' => $plan['plan_id'], 'updated_by' => $updatedBy]
                    );
                }
            }
            return $this->ApiSuccessResponse([], 'تم تحديث نسبة الخصم بنجاح');
        } catch (\Throwable $th) {
            return $this->ApiErrorResponse('خطأ اثناء تحديث نسبة الخصم');
        }
    }

    protected function discounts(Request $request)
    {
        $period_id = $request->period_id;
        $levels = Level::where('grade_id', $request->grade_id)->orderBy('id')->get();
        $level_ids = $levels->pluck('id')->toArray();
        $discounts = Discount::where('period_id', $request->period_id)->whereIn('level_id', $level_ids)->orderBy('id')->get();
        $categories = Category::where('active', 1)->orderBy('id')->get();
        $plans = Plan::where('active', 1)->orderBy('id')->get();

        $data = view('admin.AcademicYears.period.discount.json', compact('discounts', 'levels', 'plans', 'categories', 'period_id'))->render();
        return $this->ApiSuccessResponse($data);
    }

    protected function getTransportationFees(Request $request)
    {
        $transportationFees = Transportation::select('id', 'transportation_type', 'annual_fees', 'semester_fees', 'monthly_fees')->get();

        return $this->ApiSuccessResponse($transportationFees);
    }


    public function getdiscountLimits(Request $request)
    {
        if ($request->filled('academic_year_id')) {

            if ($request->filled('classification_id')) {
                # spscial discounts
                $classification = CouponClassification::findOrFail($request->classification_id);
                dispatch(new UpdateDiscount($request->level_id, $request->academic_year_id, $classification));

                $discount_limits = Cache::get('special_discount_limits', []);

                if (isset($discount_limits[$request->academic_year_id][$classification->classification_prefix])) {
                    return $this->ApiSuccessResponse($discount_limits[$request->academic_year_id][$classification->classification_prefix]);
                }
            } else {
                #  general discounts
                dispatch(new UpdateDiscount($request->level_id, $request->academic_year_id));

                $discount_limits = Cache::get('discount_limits', []);

                if (isset($discount_limits[$request->academic_year_id][$request->level_id])) {
                    return $this->ApiSuccessResponse($discount_limits[$request->academic_year_id][$request->level_id]);
                }
            }
            return $this->ApiErrorResponse('خطأ غير متوقع اثناء الحصول علي بيانات ');
        }
        return $this->ApiErrorResponse('رجاء اختيار السنة الدراسية و الصف الدراسي', 404);
    }

    protected function search_users(Request $request)
    {
        if ($request->filled('q')) {
            $users =  guardian::select('guardians.guardian_id as id', DB::raw('CONCAT(users.first_name, " " ,users.last_name) as full_name'), 'users.phone', 'guardians.national_id', 'categories.category_name')
                ->where('guardians.national_id', 'LIKE', '%' . $request->q . '%')
                ->orWhere('users.phone', 'LIKE', '%' . $request->q . '%')
                ->orWhere('guardians.national_id', 'LIKE', '%' . $request->q . '%')
                ->orWhere(DB::raw("concat(users.first_name, ' ', users.last_name)"), 'LIKE', "%" . $request->q . "%")
                ->leftJoin('users', 'users.id', 'guardians.guardian_id')
                ->leftJoin('categories', 'categories.id', 'guardians.category_id')
                ->get();

            return $this->ApiSuccessResponse(['users' => $users]);
        }
    }

    protected function search_students(Request $request)
    {
        if ($request->filled('q')) {
            $academic_year = AcademicYear::where('current_academic_year', 1)->first()->id;
            $search = $request->q;
            $students =  Student::select('students.id', 'students.student_name', 'students.national_id', 'levels.level_name')
                ->where(function($query) use ($search){
                    $query->where('student_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('national_id', 'LIKE', '%' . $search . '%');
                })
                ->leftJoin('contracts','contracts.student_id', 'students.id')
                ->where('contracts.academic_year_id', $academic_year)
                ->leftjoin('levels', 'levels.id', 'contracts.level_id')
                ->get();

            return $this->ApiSuccessResponse(['students' => $students]);
        }
    }

    protected function getMeetingSlots(Request $request)
    {
        if ($request->filled('selected_date')) {

            $section_id =  Gender::select('appointment_section_id')->findOrFail($request->gender_id)->appointment_section_id;
            $selected_date = $request->selected_date;
            $response = $this->CheckAvailableAppointments($selected_date, $section_id);

            return $this->ApiSuccessResponse($response);
        }
    }

    protected function getYearCouponClassification(Request $request)
    {
        // if ($request->filled('academic_year_id')) {
        $Classifications = getCouponClassification($request->academic_year_id, $request->id);
        return $this->ApiSuccessResponse(['Classifications' => $Classifications]);
        // }
        // return $this->ApiSuccessResponse(['Classifications' => getCouponClassification(nul)]);
    }

    protected function getSchools(Request $request)
    {
        return $this->ApiSuccessResponse(['schools' => schools($request->corporate_id, $request->returnArray)]);
    }

    protected function getCalender(Request $reuest)
    {
        $appointments = ReservedAppointment::select('reserved_appointments.id', 'reserved_appointments.appointment_time', 'reserved_appointments.selected_date', 'appointment_offices.office_name', 'users.first_name', 'users.last_name', 'appointment_sections.section_name', 'reserved_appointments.created_at', 'reserved_appointments.updated_at')
            ->leftjoin('appointment_offices', 'appointment_offices.id', 'reserved_appointments.office_id')
            ->leftjoin('appointment_sections', 'appointment_sections.id', 'reserved_appointments.section_id')
            ->leftjoin('users', 'users.id', 'reserved_appointments.guardian_id')
            ->orderBy('reserved_appointments.id', 'DESC')->get();

        // return $this->ApiSuccessResponse(['events' => $appointments]);
        return $this->ApiSuccessResponse(['events' => [
            [
                'id' => 1,
                'url' => '',
                'title' => 'شركة اميجو للأساتك البنس',
                'start' => Carbon::now(),
                'end' => Carbon::now()->addDay(),
                'allDay' => false,
                'extendedProps' => [
                    'calendar' => 'Business',
                ]
            ],
            [
                'id' => 2,
                'url' => '',
                'title' => 'Meeting With Client',
                'start' => Carbon::now()->addDays(rand(1, 15)),
                'end' => Carbon::now()->addDays(rand(1, 15)),
                'allDay' => true,
                'extendedProps' => [
                    'calendar' => 'Business',
                ]
            ],
            [
                'id' => 3,
                'url' => '',
                'title' => 'Family Trip',
                'allDay' => true,
                'start' => Carbon::now()->addDays(rand(1, 15)),
                'end' => Carbon::now()->addDays(rand(1, 15)),
                'extendedProps' => [
                    'calendar' => 'Holiday',
                ]
            ],
            [
                'id' => 4,
                'url' => '',
                'title' => "Doctor's Appointment",
                'start' => Carbon::now()->addDays(rand(1, 15)),
                'end' => Carbon::now()->addDays(rand(1, 15)),
                'allDay' => true,
                'extendedProps' => [
                    'calendar' => 'Personal',
                ]
            ],
            [
                'id' => 5,
                'url' => '',
                'title' => 'Dart Game?',
                'start' => Carbon::now()->addDay(),
                'end' => Carbon::now(),
                'allDay' => true,
                'extendedProps' => [
                    'calendar' => 'ETC',
                ]
            ],
            [
                'id' => 6,
                'url' => '',
                'title' => 'Meditation',
                'start' => Carbon::now()->addDay(),
                'end' => Carbon::now(),
                'allDay' => true,
                'extendedProps' => [
                    'calendar' => 'Personal',
                ]
            ],
            [
                'id' => 7,
                'url' => '',
                'title' => 'Dinner',
                'start' => Carbon::now()->addDay(),
                'end' => Carbon::now(),
                'allDay' => true,
                'extendedProps' => [
                    'calendar' => 'Family',
                ]
            ],
            [
                'id' => 8,
                'url' => '',
                'title' => 'Product Review',
                'start' => Carbon::now()->addDay(),
                'end' => Carbon::now(),
                'allDay' => true,
                'extendedProps' => [
                    'calendar' => 'Business',
                ]
            ]
        ]]);
    }
}
