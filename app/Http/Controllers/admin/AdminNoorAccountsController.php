<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Noor\Account\StoreNoorAccountRequest;
use App\Http\Requests\Noor\Account\UpdateNoorAccountRequest;
use App\Models\NoorAccount;
use Illuminate\Http\Request;

class AdminNoorAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = NoorAccount::all();
        return view('admin.noor.accounts.index', ['accounts' => $accounts ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.noor.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoorAccountRequest $request)
    {
        if (NoorAccount::create($request->only([
            'account_name',
            'username',
            'password',
            'school_name',
            'created_by',
        ]))) {
            return redirect()->route('noorAccounts.index')
                ->with('alert-success', 'تم اضافة حساب نور بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة حساب نور')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NoorAccount  $noorAccount
     * @return \Illuminate\Http\Response
     */
    public function show(NoorAccount $noorAccount)
    {
        return view('admin.noor.accounts.show' ,compact('noorAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NoorAccount  $noorAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(NoorAccount $noorAccount)
    {
        return view('admin.noor.accounts.edit',compact('noorAccount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NoorAccount  $noorAccount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoorAccountRequest $request, NoorAccount $noorAccount)
    {
        if ($noorAccount->update($request->only([
            'account_name',
            'username',
            'password',
            'school_name',
            'updated_by',
        ]))) {
            return redirect()->route('noorAccounts.index')
                ->with('alert-success', 'تم تعديل حساب نور بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل حساب نور')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NoorAccount  $noorAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(NoorAccount $noorAccount)
    {
        if ($noorAccount->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حف حساب نور بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حف حساب نور')->withInput();
    }
}
