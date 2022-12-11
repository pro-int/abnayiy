<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transportation;
use Illuminate\Http\Request;
use App\Http\Requests\transportation\StoreTransportationRequest;
use App\Http\Requests\transportation\UpdateTransportationRequest;
use Illuminate\Support\Facades\Auth;

class AdminTransportationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:transportations-list|transportations-create|transportations-edit|transportations-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:transportations-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:transportations-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transportations-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transportations = Transportation::select('transportations.*','users.first_name as admin_name')
        ->leftjoin('users','users.id','transportations.add_by')
        ->get();

        return view('admin.transportation.index', compact('transportations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transportation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransportationRequest $request)
    {
        $transportation = Transportation::create(array_merge($request->only([
            'transportation_type',
            'annual_fees',
            'semester_fees',
            'monthly_fees',
            'odoo_product_id',
            'odoo_account_code',
            'active'
        ]),['add_by' => Auth::id(),'active' => (bool) $request->active]));

        if (!$transportation) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة خطة النقل ');
        }

        return redirect()->route('transportations.index')
            ->with('alert-success', 'تم اضافة خطة النقل بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transportation  $transportation
     * @return \Illuminate\Http\Response
     */
    public function show(Transportation $transportation)
    {
        return view('admin.transportation.view',compact('transportation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transportation  $transportation
     * @return \Illuminate\Http\Response
     */
    public function edit(Transportation $transportation)
    {
        return view('admin.transportation.edit',compact('transportation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transportation  $transportation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransportationRequest $request, Transportation $transportation)
    {
        $transportation->update(array_merge($request->only([
            'transportation_type',
            'annual_fees',
            'semester_fees',
            'monthly_fees',
            'odoo_product_id',
            'odoo_account_code',
            'active'
        ]),['add_by' => Auth::id(),'active' => $request->active]));

        if (!$transportation) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات خطة النقل ');
        }

        return redirect()->route('transportations.index')
            ->with('alert-success', 'تم تعديل معلومات خطة النقل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transportation  $transportation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transportation $transportation)
    {
        if ($transportation->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف خطة النقل ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف خطة النقل ');
    }
}
