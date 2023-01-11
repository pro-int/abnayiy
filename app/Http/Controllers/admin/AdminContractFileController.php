<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\Files\StoreContractFileRequest;
use App\Models\Contract;
use App\Models\ContractFile;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminContractFileController extends Controller
{
    /**
     * Display a listing of the files resource.
     * @return \Illuminate\Http\Response
     */
    protected LogHelper $logHelper;
    function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
    }
     public function index($student, $contract)
     {
        $contract = Contract::select('contracts.id', 'students.student_name','students.id as student_id', 'academic_years.year_name')
        ->join('students','students.id','contracts.student_id')
        ->join('academic_years','academic_years.id','contracts.academic_year_id')
        ->with('files', function ($q)
        {
            $q->select('contract_files.*', DB::raw('CONCAT(users.first_name, " " ,users.last_name) as admin_name'))
            ->leftjoin('users','users.id','contract_files.admin_id');
        })
        ->findOrFail($contract);

        return view('admin.student.contract.file.index', compact('contract'));
     }

         /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($student, $contract)
    {
        $contract = Contract::select('contracts.id', 'academic_years.year_name', 'contracts.student_id', 'students.national_id', 'students.student_name','contracts.academic_year_id')
        ->leftJoin('students','students.id','contracts.student_id')
        ->leftJoin('academic_years','academic_years.id','contracts.academic_year_id')
        ->findOrFail($contract);
        return view('admin.student.contract.file.create',compact('contract'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Files\StoreContractFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContractFileRequest $request, $student , $contract)
    {
     $file = $request->file('file_path');
        $path = upload($file,'s3',CIONTRACT_FILES,'/byAdmin-U' . auth()->id() . '-' . time() . '.' . $file->getClientOriginalExtension());

     $contractfile =  ContractFile::create([
        'file_path' => $path,
        'contract_id' => $contract,
        'admin_id' => auth()->id(),
        'file_type' => $request->file_type,
     ]);

     if ($contractfile) {
         $logMessage = 'تم اضافة ملف للتعاقد  بنجاح بواسطة '.Auth::user()->getFullName();
         $this->logHelper->logContract($logMessage, $contract, Auth::id());
            return redirect()->route('students.contracts.files.index',[$student, $contract])
                ->with('alert-success', 'تم اضافة الملف بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة الملف');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractFile  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy($student, $contract , ContractFile $file)
    {
        if (Storage::disk('s3')->delete($file->file_path) && $file->delete()) {
            $logMessage = 'تم حذف ملف من التعاقد  بنجاح بواسطة '.Auth::user()->getFullName();
            $this->logHelper->logContract($logMessage, $contract, Auth::id());
            return redirect()->back()
                ->with('alert-success', 'تم حضف الملف ينجاح');
        }
        return back()
        ->with('alert-danger', 'فشي حضف الملف ');
    }
}
