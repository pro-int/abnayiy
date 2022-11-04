<?php

namespace App\Http\Controllers\admin;

use App\Events\UpdateDiscount;
use App\Exports\CouponReportExport;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Http\Requests\coupon\StoreCouponRequest;
use App\Http\Requests\coupon\UpdateCouponRequest;
use App\Models\AcademicYear;
use App\Models\CouponClassification;
use App\Models\PaymentAttempt;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminCouponsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:discounts-list|discounts-create|discounts-edit|discounts-delete', ['only' => ['index', 'store', 'report']]);
        $this->middleware('permission:discounts-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:discounts-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:discounts-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the couponea.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $coupons = Coupon::select(
            'coupons.*',
            'users.first_name as admin_name',
            'coupon_classifications.classification_name',
            'coupon_classifications.color_class',
            'academic_years.year_name',
            'levels.level_name'
        )
            ->leftjoin('users', 'users.id', 'coupons.add_by')
            ->leftjoin('levels', 'levels.id', 'coupons.level_id')
            ->leftjoin('academic_years', 'academic_years.id', 'coupons.academic_year_id')
            ->leftjoin('coupon_classifications', 'coupon_classifications.id', 'coupons.classification_id')
            // ->with('usage')
            ->orderBy('coupons.id', 'DESC');

        if ($request->filled('classification_id')) {
            if ($request->classification_id == 'all') {
                $coupons = $coupons->whereNull('coupons.classification_id');
            } else {
                $coupons = $coupons->where('coupons.classification_id', $request->classification_id);
            }
        }

        if ($request->filled('search')) {
            # fild all transaction
            $coupons = $coupons->where('coupons.code', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('date_from')) {
            # select start date
            $coupons = $coupons->whereDate('coupons.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $coupons = $coupons->whereDate('coupons.created_at', '<=', $request->date_to);
        }


        if ($request->filled('level_id') && is_numeric($request->level_id)) {
            $coupons = $coupons->where('coupons.level_id', $request->level_id);
        }

        $year_name = null;
        if ($request->filled('academic_year_id')) {
            $coupons = $coupons->where('coupons.academic_year_id', $request->academic_year_id);
            $year_name = AcademicYear::find($request->academic_year_id)->year_name;
        }

        if ($request->action == 'export_xlsx') {
            $coupons = $coupons->get();
            $export = new CouponReportExport($coupons, $request->date_from, $request->date_to, $year_name);
            return count($coupons) ? Excel::download($export, 'تقرير_الخصومات.xlsx') : redirect()->back()->with('alert-warning', 'لا توجد نتائج لمعاير اليحث')->withInput();
        }

        $coupons = $coupons->paginate(env('PER_PAGE', 30));
        return view('admin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponRequest $request)
    {
        $classification = $request->filled('classification_id') ? CouponClassification::findOrFail($request->classification_id) : null;

        if ($limit = $this->checkDiscountsLimit($request, $classification) >= $request->coupon_value) {

            $code = $this->getCouponWithPrefix($request, $classification);
            $coupon = Coupon::create(array_merge($request->only([
                'coupon_value',
                'level_id',
                'academic_year_id',
                'available_at',
                'expire_at',
                'coupon_type',
                'classification_id',
                'active'
            ]), ['code' => $code, 'add_by' => Auth::id()]));

            if (!$coupon) {
                return redirect()->back()
                    ->with('alert-danger', 'خطأ اثناء اضافة القسيمة ');
            }

            return redirect()->route('coupons.index')
                ->with('alert-success', sprintf('تم اضافة القسيمة %s بنجاح', $code));
        }

        $msg = $limit > 1 ? 'اقصي قيمة للقيمة لا يجب ان تكون اكبر من ' . $limit : 'لا يوجد رصيد خصومات متاح للأستخدامة';
        return redirect()->back()->withinput()->withErrors(['coupon_value' => $msg])->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(coupon $coupon)
    {
        return view('admin.coupon.view', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit($coupon)
    {
        $coupon = Coupon::select('coupons.*', 'schools.id as school_id', 'grades.id as grade_id', 'genders.id as gender_id')
            ->leftjoin('levels', 'levels.id', 'coupons.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->findOrFail($coupon);

        if ($coupon->used_value) {
            return redirect()->back()
                ->with('alert-danger', 'لا يمكن تعديل القسائم المستخدمة بالفعل');
        }

        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponRequest $request, coupon $coupon)
    {
        $classification = $request->filled('classification_id') ? CouponClassification::findOrFail($request->classification_id) : null;

        if ($limit = $this->checkDiscountsLimit($request, $classification) + $coupon->coupon_value >= $request->coupon_value) {
            $coupon->update(array_merge($request->only([
                'coupon_value',
                'level_id',
                'academic_year_id',
                'available_at',
                'expire_at',
                'active'
            ]), ['add_by' => Auth::id()]));

            if (!$coupon) {
                return redirect()->back()
                    ->with('alert-danger', 'خطأ اثناء تعديل القسيمة ');
            }

            return redirect()->route('coupons.index')
                ->with('alert-success', 'تم تعديل القسيمة بنجاح');
        }

        $msg = $limit > 1 ? 'اقصي خصم متاح للقسائم هو ' . $limit : 'لا يوجد رصيد خصومات متاح للأستخدامة';
        return redirect()->back()->withinput()->withErrors(['coupon_value' => $msg])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(coupon $coupon)
    {

        if ($coupon->used_value) {
            return redirect()->back()
                ->with('alert-danger', 'لا يمكن حذف القسائم المستخدمة بالفعل');
        }

        if ($coupon->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف القسيمة ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف القسيمة ');
    }

    protected function getCouponWithPrefix(FormRequest $request, $classification): string
    {
        if ($classification) {
            # return prefix
            return 'NL' . $classification->classification_prefix . $request->code;
        }
        return $request->code;
    }

    protected function checkDiscountsLimit(FormRequest $request, $classification)
    {
        dispatch(new UpdateDiscount($request->level_id, $request->academic_year_id, $classification));

        if ($classification) {
            # spchial discount
            $discount_limits = Cache::get('special_discount_limits', []);
            info($discount_limits);
            if (isset($discount_limits[$request->academic_year_id][$classification->classification_prefix])) {
                $limit = $discount_limits[$request->academic_year_id][$classification->classification_prefix];
                return $limit['remain_coupon_discounts'];
            }
        } else {
            $discount_limits = Cache::get('discount_limits', []);
            if (isset($discount_limits[$request->academic_year_id][$request->level_id])) {
                $limit = $discount_limits[$request->academic_year_id][$request->level_id];
                return $limit['remain_coupon_discounts'];
            }
        }
    }

    public function discount_report(Request $request)
    {
        $payments = PaymentAttempt::select(
            'payment_attempts.id',
            'payment_attempts.received_ammount',
            'payment_attempts.coupon',
            'payment_attempts.coupon_discount',
            'payment_attempts.attach_pathh',
            'payment_attempts.payment_method_id',
            'payment_attempts.reference',
            'payment_attempts.created_at',
            'payment_attempts.updated_at',
            'transactions.installment_name',
            'academic_years.year_name',
            DB::raw("CONCAT(users.first_name,' ',users.last_name) as guardian_name"),
            DB::raw("CONCAT(admins.first_name,' ',admins.last_name) as admin_name"),
            'users.phone',
            'coupon_classifications.classification_name',
            'coupon_classifications.color_class',
            'coupons.coupon_value',
            'payment_attempts.transaction_id',
            'transactions.contract_id',
            'contracts.student_id'
        )
            ->join('transactions', 'transactions.id', 'payment_attempts.transaction_id')
            ->leftjoin('contracts', 'contracts.id', 'transactions.contract_id')
            ->join('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->join('students', 'students.id', 'contracts.student_id')
            ->join('coupons', 'coupons.code', 'payment_attempts.coupon')
            ->leftjoin('coupon_classifications', 'coupon_classifications.id', 'coupons.classification_id')
            ->join('users', 'users.id', 'students.guardian_id')
            ->join('users as admins', 'admins.id', 'payment_attempts.admin_id')
            ->whereNotIn('payment_attempts.coupon', ['', 'null'])
            ->where('payment_attempts.coupon_discount', '>', 0)
            ->orderBy('payment_attempts.created_at', 'DESC');


        if ($request->filled('classification_id')) {
            if ($request->classification_id == 'all') {
                $payments = $payments->whereNull('coupons.classification_id');
            } else {
                $payments = $payments->where('coupons.classification_id', $request->classification_id);
            }
        }

        if ($request->filled('search')) {
            # fild all transaction
            $payments = $payments->where('payment_attempts.coupon', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('date_from')) {
            # select start date
            $payments = $payments->whereDate('payment_attempts.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $payments = $payments->whereDate('payment_attempts.created_at', '<=', $request->date_to);
        }


        $year_name = null;
        if ($request->filled('academic_year_id')) {
            $payments = $payments->where('contracts.academic_year_id', $request->academic_year_id);
            $year_name = AcademicYear::find($request->academic_year_id)->year_name;
        }

        if ($request->action == 'export_xlsx') {
            $payments = $payments->get();
            $export = new CouponReportExport($payments, $request->date_from, $request->date_to, $year_name);
            return count($payments)
                ? Excel::download($export, 'تقرير_الخصومات.xlsx')
                : redirect()->back()->with('alert-warning', 'لا توجد نتائج لمعاير اليحث')->withInput();
        }

        $payments = $payments->paginate(config('view.per_page', 30));

        return view('admin.coupon.report', compact('payments', 'year_name'));
    }
}
