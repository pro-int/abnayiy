<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Http\Requests\discount\StoreDiscountRequest;
use App\Http\Requests\discount\UpdateDiscountRequest;
use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Period;
use App\Models\Plan;
use Illuminate\Http\Request;

class AdminDiscountController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:discounts-list|discounts-create|discounts-edit|discounts-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:discounts-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:discounts-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:discounts-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $period = Period::findOrFail($request->period);
        $year = AcademicYear::findOrFail($period->academic_year_id);

        $discounts = Discount::select('discounts.id', 'discounts.rate', 'discounts.created_at', 'discounts.updated_at', 'levels.level_name', 'plans.plan_name', 'categories.category_name', 'categories.color', 'users.first_name as admin_name')
            ->leftjoin('levels', 'levels.id', 'discounts.level_id')
            ->leftjoin('plans', 'plans.id', 'discounts.plan_id')
            ->leftjoin('categories', 'categories.id', 'discounts.category_id')
            ->leftjoin('users', 'users.id', 'discounts.updated_by')
            ->where('discounts.period_id', $period->id);

        if ($request->has('plan_id') && is_numeric($request->plan_id)) {
            $discounts = $discounts->where('discounts.plan_id', $request->plan_id);
        }

        if ($request->has('category_id') && is_numeric($request->category_id)) {
            $discounts = $discounts->where('discounts.category_id', $request->category_id);
        }

        if ($request->has('level_id') && is_numeric($request->level_id)) {
            $discounts = $discounts->where('discounts.level_id', $request->level_id);
        }


        $discounts = $discounts->get();

        return view('admin.AcademicYears.period.discount.index', compact('discounts', 'period', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $period = Period::findOrFail($request->period);
        $year = AcademicYear::findOrFail($period->academic_year_id);

        return view('admin.AcademicYears.period.discount.create', compact('period', 'year'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorediscountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorediscountRequest $request)
    {

        $discount = Discount::create($request->only(['school_id', 'discount_name', 'active']));

        return redirect()->route('discounts.index')
            ->with('alert-success', 'تم اضافة الخصم بنجاح');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(period $period, discount $discount)
    {
        return view('admin.AcademicYears.period.discount.view', compact('period', 'discount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(discount $discount)
    {
        $schools  = Discount::orderBy('id')->pluck('school_name', 'id')->toArray();
        return view('admin.AcademicYears.period.discount.edit', compact('discount', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatediscountRequest  $request
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatediscountRequest $request)
    {
        $discount = Discount::where('id', $request->discount_id)->update($request->only(['school_id', 'discount_name', 'active']));

        if (!$discount) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات الخصم التعليمي');
        }

        return redirect()->route('discounts.index')
            ->with('alert-success', 'تم تعديل معلومات النظام التعليمي بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($year, $period ,discount $discount)
    {
        Discount::where('id', $discount->id)->delete();
        return redirect()->back()
            ->with('alert-success', 'تم حضف الخصم ينجاح');
    }
}
