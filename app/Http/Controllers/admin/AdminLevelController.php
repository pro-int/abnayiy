<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Http\Requests\level\StoreLevelRequest;
use App\Http\Requests\level\UpdateLevelRequest;
use Illuminate\Http\Request;

class AdminLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:levels-list|levels-create|levels-edit|levels-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:levels-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:levels-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:levels-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $levels = Level::select('levels.*', 'genders.gender_name', 'schools.school_name', 'grades.grade_name', 'nextLevel.level_name as next_level_name')
            ->leftjoin('levels as nextLevel', 'nextLevel.id', 'levels.next_level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id');


        if ($request->filled('grade_id') && is_numeric($request->grade_id)) {
            $levels = $levels->where('grades.id', $request->grade_id);
        } else if ($request->filled('gender_id') && is_numeric($request->gender_id)) {
            $levels = $levels->where('genders.id', $request->gender_id);
        } else if ($request->filled('school_id') && is_numeric($request->school_id)) {
            $levels = $levels->where('schools.id', $request->school_id);
        }

        $levels = $levels->orderBy('levels.id')->get();

        return view('admin.level.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.level.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLevelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLevelRequest $request)
    {
        $level = Level::create($request->only(['grade_id', 'level_name_noor', 'level_name', 'tuition_fees', 'min_students', 'active', 'coupon_discount_persent', 'period_discount_persent']));

        if ($level) {
            return redirect()->route('levels.index')
                ->with('alert-success', 'تم اضافة الصدف الدراسي بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة الصدف الدراسي');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show($level)
    {
        $level = Level::select('levels.*', 'schools.id as school_id', 'genders.id as gender_id', 'grades.id as grade_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->findOrFail($level);

        return view('admin.level.show', compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit($level)
    {
        $level = Level::select('levels.*', 'schools.id as school_id', 'genders.id as gender_id', 'grades.id as grade_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->findOrFail($level);
        return view('admin.level.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLevelRequest  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLevelRequest $request, Level $level)
    {

        $level->update($request->only(['level_name', 'tuition_fees', 'grade_id', 'level_name_noor', 'min_students', 'active', 'coupon_discount_persent', 'period_discount_persent']));

        if (!$level) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات الصف ');
        }

        return redirect()->route('levels.index')
            ->with('alert-success', 'تم تعديل معلومات الصف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        if ($level->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف المرحلة الدراسية ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف الصف ');
    }

    public function nextLevel(Request $request, Level $level)
    {
        if ($request->isMethod('POST')) {
            if ($request->filled('is_graduated')) {
                $level->next_level_id =  null;
                $level->is_graduated =  1;
            } else if ($request->filled('level_id')) {
                $level->next_level_id = $request->level_id;
            }

            if ($level->save()) {
                return redirect()->route('levels.index')->with('alert-success', 'تم تحديث معلومات الصف الدراسي بنجاح'); 
            }

            return  redirect()->back()->with('alert-danger', 'خطأ تعديل معلومات الصف الدراسي');

         } else if ($request->isMethod('GET')) {
            $level = Level::select('levels.id', 'levels.level_name','levels.next_level_id as level_id', 'levels.is_graduated','genders.id as gender_id', 'schools.id as school_id', 'grades.id as grade_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->findOrFail($level->id);

            return view('admin.level.nextLevel',compact('level'));
        }
    }
}
