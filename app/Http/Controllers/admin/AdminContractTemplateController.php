<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ContractTemplate;
use App\Http\Requests\contractTemplate\StoreContractTemplateRequest;
use App\Http\Requests\contractTemplate\UpdateContractTemplateRequest;
use App\Models\Contract;
use Illuminate\Support\Facades\Storage;

class AdminContractTemplateController extends Controller
{

    public function edit()
    {
        $template = ContractTemplate::first();
        if (! $template) {
            $template = new ContractTemplate();
            $template->school_watermark = ContractTemplate::$default_water_mark_path;
            $template->school_logo = ContractTemplate::$default_logo_path;
            $template->save();
        }
        return view('admin.contractTemplate.edit',compact('template'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContractTemplateRequest  $request
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContractTemplateRequest $request)
    {
        $school_logo_path= null;
        $school_watermark_path= null;

        if ($request->hasFile('school_logo')) {
            $file = $request->file('school_logo');

            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = 'school_logo.' . $file->getClientOriginalExtension();

           $school_logo_path = upload($file,'s3','pdfLogo',$filename);
        }

        if ($request->hasFile('school_watermark')) {
            $file = $request->file('school_watermark');

            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = 'school_watermark.' . $file->getClientOriginalExtension();
            $school_watermark_path = upload($file,'s3','pdfLogo',$filename);
        }

        $template = ContractTemplate::first();
        $template->school_name = $request->school_name;
        $template->school_logo = $school_logo_path;
        $template->school_watermark = $school_watermark_path;

        if ( $template->save()) {
            return redirect()->back()
                ->with('alert-success', '????  ?????????? ???????????????? ??????????');
        }
        return redirect()->back()
            ->with('alert-danger', '?????? ??????????  ?????????? ????????????????');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractTemplate $contractTemplate)
    {
        //
    }
}
