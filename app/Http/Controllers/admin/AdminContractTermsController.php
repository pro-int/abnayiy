<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractTerms\StoreContractTermsRequest;
use App\Http\Requests\ContractTerms\UpdateContractTermsRequest;
use App\Models\ContractTerms;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminContractTermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contract_terms = ContractTerms::select(
            'contract_terms.*',
            DB::raw('CONCAT(createAdmin.first_name, " " ,createAdmin.last_name) as createdByUserName'),
            DB::raw('CONCAT(updateAdmin.first_name, " " ,updateAdmin.last_name) as updatedByUserName')
        )
            ->leftjoin('users as createAdmin', 'createAdmin.id', 'contract_terms.created_by')
            ->leftjoin('users as updateAdmin', 'updateAdmin.id', 'contract_terms.updated_by')
            ->orderBy('contract_terms.id')
            ->get();

        return view('admin.ContractTerms.index', compact('contract_terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ContractTerms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ContractTerms\StoreContractTermsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContractTermsRequest $request)
    {
     

        $contract_term = ContractTerms::create($request->only('version', 'content','is_default') + ['created_by' => Auth::id()]);

        if ($contract_term) {
            return redirect()->route('contract_terms.index')
                ->with('alert-success', 'تم اضافة الشروط بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة الشروط');
    }

    /**
     * Display the specified resource.
     *
     * 
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show(contractTerms $contract_term)
    {
        
        return view('admin.ContractTerms.show', compact('contract_term'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * 
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit(contractTerms $contract_term)
    {
               return view('admin.ContractTerms.edit', compact('contract_term'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ContractTerms\UpdateContractTermsRequest  $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContractTermsRequest $request, contractTerms $contract_term)
    {

        $contract_term->update($request->only('version','content', 'is_default') + ['updated_by' => Auth::id()]);

        if (!$contract_term) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل الشروط والاحكام ');
        }

        return redirect()->route('contract_terms.index')
            ->with('alert-success', 'تم تعديل الشروط والاحكام  بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(contractTerms $contract_term)
    {
        
        if($contract_term->delete()) {

            return redirect()->back()
            ->with('alert-success', 'تم حذف الشروط والاحكام بنجاح');
        }
        return redirect()->back()
        ->with('alert-danger', 'خطأ اثناء الشروط والاحكام ');
    }
}
