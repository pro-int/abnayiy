<?php
/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Http\Requests\country\StorecountryRequest;
use App\Http\Requests\country\UpdatecountryRequest;

class AdminCountryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:countries-list|countries-create|countries-edit|countries-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:countries-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:countries-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:countries-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        return view('admin.country.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecountryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecountryRequest $request)
    {

        $country = Country::create($request->only(['country_name','country_code', 'active']));

        if ($country) {
            return redirect()->route('countries.index')
                ->with('alert-success', 'تم اضافة معلومات الدولة بنجاح');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة معلومات الدولة');
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function show(country $country)
    {
        return view('admin.country.view', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(country $country)
    {
        return view('admin.country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecountryRequest  $request
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecountryRequest $request)
    {
        $type = Country::where('id', $request->country_id)->update($request->only(['country_name', 'country_code','active']));

        if ($type) {
            return redirect()->route('countries.index')
                ->with('alert-success', 'تم تعديل معلومات الدولة بنجاح');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات الدولة');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(country $country)
    {
        $country->delete();
        return redirect()->back()
            ->with('alert-success', 'تم حضف الدولة ينجاح');
    }
}
