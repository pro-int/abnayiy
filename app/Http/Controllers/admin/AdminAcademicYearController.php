<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */
/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Http\Requests\AcademicYear\StoreAcademicYearRequest;
use App\Http\Requests\AcademicYear\UpdateAcademicYearRequest;

class AdminAcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = AcademicYear::orderBy('id', 'DESC')->get();
        return view('admin.AcademicYears.index', compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.AcademicYears.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAcademicYearRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAcademicYearRequest $request)
    {
        $AcademicYear = AcademicYear::create($request->only([
            'year_numeric',
            'year_name',
            'year_hijri',
            'start_transition',
            'year_start_date',
            'fiscal_year_end',
            'year_end_date',
            'current_academic_year',
            // 'previous_year_id',
            'is_open_for_admission',
            'installments_available_until',
            'last_installment_date',           
            'min_tuition_percent',
            'min_debt_percent',
            'active'
        ]));

        if ($AcademicYear) {
            return redirect()->route('years.index')
                ->with('alert-success', 'تم اضافة العام الدراسي بنجاح');
        }
        return redirect()->route('years.index')
            ->with('alert-danger', 'تم اضافة العام الدراسي بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYear $year)
    {
        return view('admin.AcademicYears.show', compact('year'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $year)
    {
        return view('admin.AcademicYears.edit', compact('year'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAcademicYearRequest  $request
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAcademicYearRequest $request, AcademicYear $year)
    {
        $year->update($request->only([
            'year_numeric',
            'year_name',
            'year_hijri',
            'year_start_date',
            'year_end_date',
            'start_transition',
            'current_academic_year',
            // 'previous_year_id',
            'fiscal_year_end',
            'is_open_for_admission',
            'min_tuition_percent',
            'min_debt_percent',
            'installments_available_until',
            'last_installment_date',
            'active',
        ]));

        if ($year) {
            return redirect()->route('years.index')
                ->with('alert-success', 'تم تعديل معلومات العام الدراسي بنجاح');
        }

        return redirect()->route('years.index')
            ->with('alert-danger', 'فشل تعديل معلومات العام الدراسي ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicYear $year)
    {
        if ($year->delete()) {
            return redirect()->route('years.index')
                ->with('alert-success', 'تم حضف العام الدراسي ينجاح');
        }
        return redirect()->route('years.index')
            ->with('alert-danger',  'فشل حضف العام الدراسي ينجاح');
    }
}
