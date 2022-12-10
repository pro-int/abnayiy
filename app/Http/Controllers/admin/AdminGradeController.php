<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Http\Requests\grade\StoreGradeRequest;
use App\Http\Requests\grade\UpdateGradeRequest;
use App\Services\GraderService;
use Illuminate\Http\Request;

class AdminGradeController extends Controller
{
    protected GraderService $gradeService;

    public function __construct(GraderService $gradeService)
    {
        $this->gradeService = $gradeService;

        $this->middleware('permission:grades-list|grades-create|grades-edit|grades-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:grades-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:grades-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:grades-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grades = $this->gradeService->all($request);

        return view('admin.grade.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.grade.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGradeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradeRequest $request)
    {
        $grade = Grade::create($request->only(['grade_name' , 'gender_id' , 'active']));

        if ($grade) {
            return redirect()->route('grades.index')
                ->with('alert-success', 'تم اضافة المسار الدراسية بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة معلومات المسار ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show($grade)
    {
        $grade = Grade::select('grades.*','schools.id as school_id', 'genders.id as gender_id')
        ->leftjoin('genders', 'genders.id', 'grades.gender_id')
        ->leftjoin('schools', 'schools.id', 'genders.school_id')
        ->findOrFail($grade);

        return view('admin.grade.view', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit($grade)
    {
        $grade = Grade::select('grades.*','schools.id as school_id', 'genders.id as gender_id')
        ->leftjoin('genders', 'genders.id', 'grades.gender_id')
        ->leftjoin('schools', 'schools.id', 'genders.school_id')
        ->findOrFail($grade);

        return view('admin.grade.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGradeRequest  $request
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {

        $grade->update($request->only(['grade_name', 'gender_id' , 'active']));
        if (!$grade) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات المسار بنجاح')->withInput();
        }

        return redirect()->route('grades.index')
            ->with('alert-success', 'تم تعديل معلومات المسار التعليمية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        if ($grade->delete()) {

            return redirect()->back()
                ->with('alert-success', 'تم المسار الدراسية ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف  معلومات المسار');
    }
}
