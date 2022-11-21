<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Corporate\DeleteCorporateRequest;
use App\Models\Corporate;
use App\Http\Requests\Corporate\StoreCorporateRequest;
use App\Http\Requests\Corporate\UpdateCorporateRequest;
use App\Services\CorporateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCorporateController extends Controller
{
    protected CorporateService $corporateService;

    public function __construct(CorporateService $corporateService)
    {
        $this->corporateService = $corporateService;

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
    public function index()
    {
        $corporates = $this->corporateService->all();

        return view('admin.Corporate.index', compact('corporates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Corporate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Corporate\StoreCorporateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCorporateRequest $request)
    {
        if ($this->corporateService->create($request)) {
            return redirect()->route('corporates.index')->with('alert-success', 'تم اضافة معلومات المجمع بنجاح');
        }
        return redirect()->back()->with('alert-danger', 'تم اضافة معلومات المجمع بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Corporate  $corporate
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $corporate = $this->corporateService->show();

        return view('admin.Corporate.show', compact('corporate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Corporate  $corporate
     * @return \Illuminate\Http\Response
     */
    public function edit(Corporate $corporate)
    {
        return view('admin.Corporate.edit', compact('corporate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Corporate\UpdateCorporateRequest  $request
     * @param  \App\Models\Corporate  $corporate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCorporateRequest $request)
    {
        if ($this->corporateService->update($request)) {
            return redirect()->route('corporates.index')->with('alert-success', 'تم تعديل معلومات المجمع بنجاح');
        }
        return redirect()->back()->with('alert-danger', 'تم تعديل معلومات المجمع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Http\Requests\Corporate\DeleteCorporateRequest  $request
     * @param  \App\Models\Corporate  $corporate
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if ($this->corporateService->delete()) {
            return redirect()->route('corporates.index')->with('alert-success', 'تم حذف معلومات المجمع بنجاح');
        }
        return redirect()->back()->with('alert-danger', 'تم حذف معلومات المجمع بنجاح');
    }

    public function switch(Request $request)
    {
        # toggle selected corporate
        if ($request->filled('corprate_id') && $corporate = Corporate::find($request->corprate_id)) {
            session()->put('seleted_corprate', $corporate);
        }
        return redirect()->back();
    }
}
