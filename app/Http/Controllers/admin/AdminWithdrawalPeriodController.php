<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\withdrawalPeriod\StoreWithdrawalPeriodRequest;
use App\Http\Requests\withdrawalPeriod\UpdateWithdrawalPeriodRequest;
use App\Models\AcademicYear;
use App\Models\WithdrawalPeriod;
use Illuminate\Http\Request;

class AdminWithdrawalPeriodController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:periods-list|periods-create|periods-edit|periods-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:periods-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:periods-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:periods-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AcademicYear $year)
    {
        $withdrawalPeriods = WithdrawalPeriod::where('academic_year_id', $year->id)
            ->get();

        return view('admin.AcademicYears.withdrawalPeriod.index', compact('withdrawalPeriods', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(AcademicYear $year)
    {
        return view('admin.AcademicYears.withdrawalPeriod.create', compact('year'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreWithdrawalPeriodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWithdrawalPeriodRequest $request, $year)
    {
        $withdrawalPeriodDates = WithdrawalPeriod::select('*')->where("apply_end" ,">", $request->get("apply_start"))->where("apply_start" , "<" ,$request->get("apply_end"))->count();

        if($withdrawalPeriodDates == 0) {

            $withdrawalPeriod = WithdrawalPeriod::create($request->only([
                    'period_name',
                    'apply_start',
                    'apply_end',
                    'fees_type',
                    'fees',
                    'active',
                ]) + ['academic_year_id' => $year]);

            if ($withdrawalPeriod) {
                return redirect()->route('years.withdrawalPeriods.index', $year)
                    ->with('alert-success', 'تم اضافة فترة طلب الانسحاب بنجاح');
            }
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة فترة طلب الانسحاب');
        } else {
            return redirect()->route('years.withdrawalPeriods.create', $year)
                ->with('alert-danger', 'يوجد فتره انسحاب في هذه الفتره من ' . $request->get("apply_start") . " الي " . $request->get("apply_end"))->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WithdrawalPeriod  $withdrawalPeriod
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYear $year, WithdrawalPeriod $withdrawalPeriod)
    {
        return view('admin.AcademicYears.withdrawalPeriod.view', compact('year', 'withdrawalPeriod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WithdrawalPeriod  $withdrawalPeriod
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $year, WithdrawalPeriod $withdrawalPeriod)
    {
        return view('admin.AcademicYears.withdrawalPeriod.edit', compact('year', 'withdrawalPeriod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WithdrawalPeriod  $withdrawalPeriod
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWithdrawalPeriodRequest $request, $year, WithdrawalPeriod $withdrawalPeriod)
    {
        if($withdrawalPeriod->fees_type == "percentage" && ($request->get("fees") < 1 || $request->get("fees") > 100) ){
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل النسبة بين 1 الي 100');
        }

        $withdrawalPeriodDates = WithdrawalPeriod::select('*')->where("apply_end" ,">", $request->get("apply_start"))->where("apply_start" , "<" ,$request->get("apply_end"))->where("id", "!=", $withdrawalPeriod->id)->count();

        if($withdrawalPeriodDates== 0) {

            $withdrawalPeriodTable = $withdrawalPeriod->update($request->only([
                    'period_name',
                    'apply_start',
                    'apply_end',
                    'fees',
                    'active',
                ]));

            if ($withdrawalPeriodTable) {
                return redirect()->route('years.withdrawalPeriods.index', $year)
                    ->with('alert-success', 'تم تعديل فترة طلب الانسحاب بنجاح');
            }
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل فترة طلب الانسحاب');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'يوجد فتره انسحاب في هذه الفتره من ' . $request->get("apply_start") . " الي " . $request->get("apply_end"));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WithdrawalPeriod  $withdrawalPeriod
     * @return \Illuminate\Http\Response
     */
    public function destroy($year, WithdrawalPeriod $withdrawalPeriod)
    {
        if ($withdrawalPeriod->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف الفترة ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف الفترة ');
    }
}
