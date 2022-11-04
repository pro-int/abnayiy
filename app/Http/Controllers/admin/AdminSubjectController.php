<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\subject\StoreSubjectRequest;
use App\Http\Requests\subject\UpdateSubjectRequest;
use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSubjectController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Level $level)
    {
        $subjects =  Subject::select('subjects.*', 'levels.level_name')
            ->where('level_id', $level->id)
            ->leftjoin('levels', 'levels.id', 'subjects.level_id')
            ->get();

        return view('admin.level.subject.index', compact('subjects', 'level'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Level $level)
    {
        return view('admin.level.subject.create', compact('level'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreSubjectRequest  $request 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $request, $level)
    {
        $subject = Subject::create($request->only([
            'subject_name',
            'min_grade',
            'max_grade',
        ]) + ['created_by' => Auth()->id(), 'level_id' => $level]);

        if ($subject) {
            return redirect()->route('levels.subjects.index', $level)
                ->with('alert-success', 'تم اضافة المادة الدراسية بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة المادة الدراسية');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level, Subject $subject)
    {
        return view('admin.level.subject.show',compact('subject', 'level'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level, Subject $subject)
    {
        return view('admin.level.subject.edit', compact('subject', 'level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubjectRequest   $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubjectRequest $request, $level, Subject $subject)
    {
        $subject->update(
            $request->only([
                'subject_name',
                'min_grade',
                'max_grade',
            ]) + ['updated_by' => Auth()->id(), 'level_id' => $level]
        );

        if (!$subject) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات الماده الدراسية ');
        }

        return redirect()->route('levels.subjects.index', $level)
            ->with('alert-success', 'تم تعديل معلومات المادة الدراسية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy($level, Subject $subject)
    {
        if ($subject->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذفا المادة الدراسية ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف  المادة الدراسية ');
    }
}
