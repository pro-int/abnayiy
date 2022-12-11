<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Http\Requests\plan\StorePlanRequest;
use App\Http\Requests\plan\UpdatePlanRequest;
use App\Models\PaymentMethod;

class AdminPlanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:plans-list|plans-create|plans-edit|plans-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:plans-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:plans-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:plans-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::all();

        return view('admin.plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $methods = PaymentMethod::select('id','method_name')->get();
        return view('admin.plan.create',compact('methods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreplanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreplanRequest $request)
    {
        $plan = Plan::create($request->only([
            'plan_name',
            'installments',
            'req_confirmation',
            'fixed_discount',
            'plan_based_on',
            'payment_due_determination',
            'beginning_installment_calculation',
            'down_payment',
            'active',
            'odoo_id',
            'odoo_key',
            'transaction_methods',
            'contract_methods'
        ]));

        if ($plan) {
            return redirect()->route('plans.index')
                ->with('alert-success', 'تم اضافة خطة السداد بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة خطة السداد');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(plan $plan)
    {
        $methods = PaymentMethod::select('id','method_name')->get();

        return view('admin.plan.show', compact('plan','methods'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(plan $plan)
    {
        $methods = PaymentMethod::select('id','method_name')->get();

        return view('admin.plan.edit', compact('plan','methods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateplanRequest  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateplanRequest $request, plan $plan)
    {

        $plan->update($request->only([
            'plan_name',
            'installments',
            'req_confirmation',
            'fixed_discount',
            'plan_based_on',
            'payment_due_determination',
            'beginning_installment_calculation',
            'down_payment',
            'active',
            'odoo_id',
            'odoo_key',
            'transaction_methods',
            'contract_methods'
        ]));

        if (!$plan) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات خطة الدفع ');
        }

        return redirect()->route('plans.index')
            ->with('alert-success', 'تم تعديل معلومات خطة الدفع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(plan $plan)
    {
        if ($plan->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف خطة الدفع ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف خطة الدفع ');
    }
}
