<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Http\Requests\gender\StoregenderRequest;
use App\Http\Requests\gender\UpdategenderRequest;
use App\Models\School;
use App\Services\GenderService;
use Illuminate\Http\Request;

class AdminGenderController extends Controller
{
    protected GenderService $genderService;

    public function __construct(GenderService $genderService)
    {
        $this->genderService = $genderService;

        $this->middleware('permission:genders-list|genders-create|genders-edit|genders-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:genders-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:genders-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:genders-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $genders = $this->genderService->all($request);

        return view('admin.gender.index', compact('genders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gender.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoregenderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoregenderRequest $request)
    {
        if ($this->genderService->create($request)) {
            return redirect()->route('genders.index')
                ->with('alert-success', 'تم اضافة القسم بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة معلومات القسم');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $gender = $this->genderService->show();

        return view('admin.gender.show', compact('gender'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $gender = $this->genderService->show();

        return view('admin.gender.edit', compact('gender'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdategenderRequest  $request
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function update(UpdategenderRequest $request)
    {
        if ($this->genderService->update($request)) {
            return redirect()->route('genders.index')
                ->with('alert-success', 'تم تعديل معلومات النظام التعليمي بنجاح');
        }

        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل معلومات النوع التعليمي');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if ($this->genderService->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حضف النوع ينجاح');
        }
        return back()
            ->with('alert-danger', 'فشي حضف النوع ');
    }
}
