<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Http\Requests\bank\StoreBankRequest;
use App\Http\Requests\bank\UpdateBankRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminBankController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:accuonts-list|accuonts-create|accuonts-edit|accuonts-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:accuonts-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:accuonts-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:accuonts-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::select('banks.*','users.first_name as admin_name')
        ->leftjoin('users','users.id','banks.add_by')
        ->get();
        return view('admin.bank.index',compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\bank\StoreBankRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankRequest $request)
    {

        $bank = Bank::create($request->only('bank_name','account_name','account_number', 'journal_id', 'odoo_account_number', 'account_iban','active') + ['add_by' => Auth::id()]);

        if ($bank) {
            return redirect()->route('banks.index')
                ->with('alert-success', 'تم اضافة البنك بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة البنك');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(bank $bank)
    {
        return view('admin.bank.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(bank $bank)
    {
        return view('admin.bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Bank\UpdateBankRequest  $request
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankRequest $request, bank $bank)
    {
        $bank = $bank->update($request->only(['bank_name','account_name','account_number', 'journal_id', 'odoo_account_number','account_iban','active']) +  ['add_by' => Auth::id()]);
        if (!$bank) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات البنك ');
        }

        return redirect()->route('banks.index')
            ->with('alert-success', 'تم تعديل معلومات البنك بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(bank $bank)
    {
        if ($bank->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف البنك ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف  البنك ');
    }
}
