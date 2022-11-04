<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Http\Requests\type\StoreTypeRequest;
use App\Http\Requests\type\UpdateTypeRequest;
use App\Services\schoolservice;

class AdminTypeController extends Controller
{
    protected schoolservice $schoolservice;

    public function __construct(schoolservice $schoolservice)
    {
        $this->schoolservice = $schoolservice;

        $this->middleware('permission:corporates-list|corporates-create|corporates-edit|corporates-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:corporates-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:corporates-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:corporates-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = $this->schoolservice->all();
        
        return view('admin.type.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeRequest $request)
    {
        if (School::create($request->only(['school_name','school_name_noor', 'active']))) {
            return redirect()->route('schools.index')
                ->with('alert-success', 'تم اضافة النظام التعليمي بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة معلومات النظام التعليمي');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return view('admin.type.view', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {

        return view('admin.type.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypeRequest  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        if ($type->update($request->only(['school_name','school_name_noor', 'active']))) {
            return redirect()->route('schools.index')
                ->with('alert-success', 'تم تعديل معلومات النظام التعليمي بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل معلومات النظام التعليمي');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        School::where('id', $type->id)->delete();
        return redirect()->back()
            ->with('alert-success', 'تم حضف الفصل الدراسي ينجاح');
    }
}
