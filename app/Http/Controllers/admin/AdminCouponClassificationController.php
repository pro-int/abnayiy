<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\coupon\category\StoreCouponClassificationRequest;
use App\Http\Requests\coupon\category\UpdateCouponClassificationRequest;
use App\Models\CouponClassification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminCouponClassificationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:discounts-list|discounts-create|discounts-edit|discounts-delete', ['only' => ['index', 'store', 'report']]);
        $this->middleware('permission:discounts-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:discounts-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:discounts-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classifications = CouponClassification::select('coupon_classifications.*', 'academic_years.year_name', DB::raw('CONCAT(users.first_name, " " ,users.last_name) as admin_name'))
            ->leftjoin('users', 'users.id', 'coupon_classifications.admin_id')
            ->leftjoin('academic_years', 'academic_years.id', 'coupon_classifications.academic_year_id')
            ->withTrashed()
            ->paginate(config('view.per_page', 30));

        return view('admin.coupon.classification.index', compact('classifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.classification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCouponClassificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponClassificationRequest $request)
    {
        $created =  CouponClassification::create(array_merge($request->only(
            'classification_name',
            'classification_prefix',
            'allowed_schools',
            'limit',
            'color_class',
            'academic_year_id',
            'active'
        ), ['admin_id' => Auth::id()]));

        if ($created) {
            # item has been created
            return redirect()->route('classifications.index')
                ->with('alert-success', 'تم اضافة التصنيف ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة التصنيف ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CouponClassification  $classification
     * @return \Illuminate\Http\Response
     */
    public function show(CouponClassification $classification)
    {
        return view('admin.coupon.classification.view', compact('classification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CouponClassification  $classification
     * @return \Illuminate\Http\Response
     */
    public function edit(CouponClassification $classification)
    {
        return view('admin.coupon.classification.edit', compact('classification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCouponClassificationRequest  $request
     * @param  \App\Models\CouponClassification  $classification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponClassificationRequest $request, CouponClassification $classification)
    {
        $updated = $classification->update(array_merge($request->only(
            'classification_name',
            'allowed_schools',
            'limit',
            'color_class',
            'active'
        ), ['admin_id' => Auth::id()]));

        if ($updated) {
            # item has been updated
            return redirect()->route('classifications.index')
                ->with('alert-success', 'تم تحديث التصنيف ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تحديث التصنيف ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CouponClassification  $classification
     * @return \Illuminate\Http\Response
     */
    public function destroy(CouponClassification $classification)
    {
        if ($classification->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حضف التصنيف ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'فشل حضف التصنيف ');
    }
}
