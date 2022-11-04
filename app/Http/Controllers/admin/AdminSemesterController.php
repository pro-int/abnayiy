<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\semester;
use App\Http\Requests\semester\StoresemesterRequest;
use App\Http\Requests\semester\UpdatesemesterRequest;
use App\Models\AcademicYear;

class AdminSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

        $this->middleware('permission:semesters-list|semesters-create|semesters-edit|semesters-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:semesters-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:semesters-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:semesters-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AcademicYear $year)
    {
        $semesters = semester::select('semesters.*', 'academic_years.year_name')
            ->leftjoin('academic_years', 'academic_years.id', 'semesters.year_id')
            ->where('year_id', $year->id)->get();

        return view('admin.AcademicYears.semesters.index', compact('semesters', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(AcademicYear $year)
    {
        return view('admin.AcademicYears.semesters.create', compact('year'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoresemesterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresemesterRequest $request, $year)
    {
        if (semester::create($request->only([
            'semester_name',
            'semester_start',
            'semester_end',
            'semester_in_fees',
            'semester_out_fees'
        ]) + ['year_id' => $year])) {
            return redirect()->route('years.semesters.index', $year)
                ->with('alert-success', 'تم اضافة الفصل الدراسي بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'فشل اضافة الفصل الدراسي ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYear $year, semester $semester)
    {
        return view('admin.AcademicYears.semesters.view', compact('year', 'semester'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $year, semester $semester)
    {
        return view('admin.AcademicYears.semesters.edit', compact('year', 'semester'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesemesterRequest  $request
     * @param  \App\Models\semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesemesterRequest $request, $year, semester $semester)
    {
        if ($semester->update($request->only([
            'semester_name',
            'semester_start',
            'semester_end',
            'semester_in_fees',
            'semester_out_fees',
        ]) + ['year_id' => $year])) {

            return redirect()->route('years.semesters.index', $year)
                ->with('alert-success', 'تم تعديل معلومات الفصل الدراسي بنجاح');
        }
        return redirect()->route('years.semesters.index', $year)
            ->with('alert-danger', 'فشل  تعديل معلومات الفصل الدراسي ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function destroy($year, semester $semester)
    {
        if ($semester->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حضف الفصل الدراسي ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'فشل حضف الفصل الدراسي ');
    }
}
