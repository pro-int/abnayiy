<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Http\Requests\period\StoreperiodRequest;
use App\Http\Requests\period\UpdateperiodRequest;
use App\Models\AcademicYear;

class AdminPeriodController extends Controller
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
        $periods = Period::where('academic_year_id', $year->id)
            ->get();

        return view('admin.AcademicYears.period.index', compact('periods', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(AcademicYear $year)
    {
        return view('admin.AcademicYears.period.create', compact('year'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreperiodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreperiodRequest $request ,$year)
    {

        $period = Period::create($request->only([
            'period_name',
            'apply_start',
            'apply_end',
            'points_effect',
            'active',
        ]) + ['academic_year_id' => $year]);

        if ($period) {
            return redirect()->route('years.periods.index',$year)
                ->with('alert-success', 'تم اضافة فترة السداد بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة فترة السداد');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYear $year, period $period)
    {
        return view('admin.AcademicYears.period.view', compact('year', 'period'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $year, period $period)
    {
        return view('admin.AcademicYears.period.edit', compact('year', 'period'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateperiodRequest  $request
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateperiodRequest $request, $year, period $period)
    {
        if ($period->update($request->only([
            'period_name',
            'apply_start',
            'apply_end',
            'points_effect',
            'active',
        ]))) {

            return redirect()->route('years.periods.index',$year)
            ->with('alert-success', 'تم تعديل معلومات الفترة بنجاح');
        }
        
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل معلومات الفترة ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy($year, period $period)
    {
        if ($period->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف الفترة ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف الفترة ');
    }
}
