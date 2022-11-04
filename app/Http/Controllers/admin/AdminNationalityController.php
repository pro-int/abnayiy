<?php
/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\nationality;
use App\Http\Requests\nationality\StorenationalityRequest;
use App\Http\Requests\nationality\UpdatenationalityRequest;

class AdminNationalityController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:nationalities-list|nationalities-create|nationalities-edit|nationalities-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:nationalities-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:nationalities-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:nationalities-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nationalities = nationality::all();
        return view('admin.nationality.index', compact('nationalities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.nationality.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorenationalityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorenationalityRequest $request)
    {

        $nationality = nationality::create($request->only(['nationality_name','vat_rate', 'active']));

        if ($nationality) {
            return redirect()->route('nationalities.index')
                ->with('alert-success', 'تم اضافة معلومات الجنسية بنجاح');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة معلومات الجنسية');
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function show(nationality $nationality)
    {
        return view('admin.nationality.view', compact('nationality'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(nationality $nationality)
    {
        return view('admin.nationality.edit', compact('nationality'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatenationalityRequest  $request
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatenationalityRequest $request,nationality $nationality)
    {

        $type = nationality::where('id', $nationality->id)->update($request->only(['nationality_name', 'vat_rate','active']));

        if ($type) {
            return redirect()->route('nationalities.index')
                ->with('alert-success', 'تم تعديل معلومات الجنسية بنجاح');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات الجنسية');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(nationality $nationality)
    {
        $nationality->delete();
        return redirect()->back()
            ->with('alert-success', 'تم حضف الجنسية ينجاح');
    }
}

