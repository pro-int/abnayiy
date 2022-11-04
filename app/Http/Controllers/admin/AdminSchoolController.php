<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Corporate\School\IndexSchoolRequest;
use App\Models\School;
use App\Http\Requests\Corporate\School\StoreSchoolRequest;
use App\Http\Requests\Corporate\School\UpdateSchoolRequest;
use App\Services\CorporateService;
use App\Services\SchoolService;

class AdminSchoolController extends Controller
{
    protected SchoolService $schoolService;

    public function __construct(SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;

        $this->middleware('permission:corporates-list|corporates-create|corporates-edit|corporates-delete', ['only' => ['index', 'store', 'report']]);
        $this->middleware('permission:corporates-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:corporates-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:corporates-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexSchoolRequest $request)
    {
        $schools = $this->schoolService->all($request->validated());

        return view('admin.Corporate.School.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Corporate.School.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Corporate\School\School\StoreSchoolRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchoolRequest $request)
    {
        if ($this->schoolService->create($request)) {
            return redirect()->route('schools.index')->with('alert-success', 'تم اضافة معلومات المدرسة بنجاح');
        }
        return redirect()->back()->with('alert-danger', 'تم اضافة معلومات المدرسة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $school = $this->schoolService->show();

        return view('admin.Corporate.School.show', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        return view('admin.Corporate.School.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Corporate\School\School\UpdateSchoolRequest  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchoolRequest $request)
    {
        if ($this->schoolService->update($request)) {
            return redirect()->route('schools.index')->with('alert-success', 'تم تعديل معلومات المدرسة بنجاح');
        }
        return redirect()->back()->with('alert-danger', 'تم تعديل معلومات المدرسة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Http\Requests\Corporate\School\School\DeleteSchoolRequest  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if ($this->schoolService->delete()) {
            return redirect()->route('schools.index')->with('alert-success', 'تم حذف معلومات المدرسة بنجاح');
        }
        return redirect()->back()->with('alert-danger', 'تم حذف معلومات المدرسة بنجاح');
    }
}
