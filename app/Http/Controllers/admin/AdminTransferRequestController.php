<?php

namespace App\Http\Controllers\admin;

use App\Exports\TransferRequestExport;
use App\Http\Controllers\Controller;
use App\Models\TransferRequest;
use App\Http\Requests\Contract\TransferRequest\StoreAdminTransferRequestRequest;
use App\Http\Requests\Contract\TransferRequest\UpdateAdminTransferRequestRequest;
use App\Http\Traits\ContractTrait;
use App\Http\Traits\ContractTransportation;
use App\Models\AcademicYear;
use App\Models\Contract;
use App\Models\ContractFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdminTransferRequestController extends Controller
{
    use ContractTrait, ContractTransportation;
    function __construct()
    {
        $this->middleware('permission:transfers-list|transfers-create|transfers-edit|transfers-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:transfers-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:transfers-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transfers-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->filled('academic_year_id') ? AcademicYear::findOrFail($request->academic_year_id) : $this->GetAdmissionAcademicYear();

        $transfers = TransferRequest::select(
            'transfer_requests.*',
            'plans.plan_name',
            'levels.level_name',
            'students.national_id',
            'students.student_name',
            'academic_years.year_name',
            'students.id as student_id',
            'new_level.level_name as new_level_name',
            'banks.bank_name',
            'payment_methods.method_name',
            'users.phone'
        )
            ->join('contracts', 'contracts.id', 'transfer_requests.contract_id')
            ->join('students', 'students.id', 'contracts.student_id')
            ->join('users', 'users.id', 'students.guardian_id')
            ->join('academic_years', 'academic_years.id', 'transfer_requests.next_school_year_id')
            ->leftjoin('plans', 'plans.id', 'transfer_requests.plan_id')
            ->leftjoin('banks', 'banks.id', 'transfer_requests.bank_id')
            ->leftjoin('payment_methods', 'payment_methods.id', 'transfer_requests.payment_method_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('levels as new_level', 'new_level.id', 'transfer_requests.next_level_id')
            ->where('transfer_requests.next_school_year_id', $year->id)
            ->orderBy('transfer_requests.id', 'DESC');


            if ($request->filled('search')) {
                if ($request->search[0] == '=') {
    
                    $transfers = $transfers->where(function ($query) use ($request) {
                        $query->where('transfer_requests.id', substr($request->search, 1));
                    });
                } else {
                    if (is_numeric($request->search)) {
                        # search only numitic values
                        $transfers = $transfers->where(function ($query) use ($request) {
                            $query->where('students.national_id', 'LIKE', '%' . $request->search . '%')
                                ->orWhere('users.phone', 'LIKE', '%' . $request->search . '%');
                        });
                    } else {

                        $transfers = $transfers->where(function ($query) use ($request) {
                            $query->orWhere('students.student_name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere(DB::raw("CONCAT(users.first_name,' ',users.last_name)"), 'LIKE', "%" . $request->search . "%");

                        });
                    }
                }
            }

            $transfers = $this->fillter_applications($request, $transfers);

            if ($request->action == 'export_xlsx') {
                $expoert = new TransferRequestExport($transfers);
                return Excel::download($expoert, 'طلبات_تجديد_التعاقد.xlsx');
            }
    
             $transfers =  $transfers->paginate(config('view.per_page', 30));

             return view('admin.TransferRequest.index', compact('transfers', 'year'));
    }


    protected function fillter_applications($request, $transfers)
    {
        if ($request->filled('status_id')) {
            $transfers = $transfers->where('transfer_requests.status', $request->status_id);
        }

        if ($request->filled('payment_method_id')) {
            $transfers = $transfers->where('transfer_requests.payment_method_id', $request->payment_method_id);
        }

        if ($request->filled('date_from')) {
            $transfers = $transfers->whereDate('transfer_requests.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $transfers = $transfers->whereDate('transfer_requests.created_at', '<=',  $request->date_to);
        }

        if ($request->filled('transportation')) {
            $transfers = $transfers->whereNotNull('transfer_requests.transportation_id');
        }

        return $transfers;
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransferRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminTransferRequestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransferRequest  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show($transfer)
    {
        $transfer = TransferRequest::select(
            'transfer_requests.*',
            DB::raw('CONCAT(users.first_name, " " ,users.last_name) as guardian_name'),
            'users.phone',
            'guardians.national_id as guardian_national_id',
            'students.id as student_id',
            'categories.category_name',
            'students.national_id',
            'students.student_name',
            'students.last_noor_sync',
            'academic_years.year_name',
            'levels.level_name',
            'new_level.level_name as new_level_name',
            'plans.req_confirmation',
            'plans.plan_name',
        )
            ->leftJoin('contracts', 'contracts.id', 'transfer_requests.contract_id')
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->leftjoin('users', 'users.id', 'students.guardian_id')
            ->leftjoin('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->leftjoin('academic_years', 'academic_years.id', 'transfer_requests.next_school_year_id')
            ->leftjoin('plans', 'plans.id', 'transfer_requests.plan_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('levels as new_level', 'new_level.id', 'transfer_requests.next_level_id')
            ->findOrFail($transfer);

        return view('admin.TransferRequest.view', compact('transfer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransferRequest  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit($transfer)
    {
        $transfer = TransferRequest::select(
            'transfer_requests.*',
            DB::raw('CONCAT(users.first_name, " " ,users.last_name) as guardian_name'),
            'users.phone',
            'guardians.national_id as guardian_national_id',
            'students.id as student_id',
            'categories.category_name',
            'students.national_id',
            'students.student_name',
            'students.last_noor_sync',
            'academic_years.year_name',
            'levels.level_name',
            'new_level.level_name as new_level_name',
            'plans.req_confirmation',
            'plans.plan_name',
        )
            ->leftJoin('contracts', 'contracts.id', 'transfer_requests.contract_id')
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->leftjoin('users', 'users.id', 'students.guardian_id')
            ->leftjoin('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->leftjoin('plans', 'plans.id', 'transfer_requests.plan_id')
            ->leftjoin('academic_years', 'academic_years.id', 'transfer_requests.next_school_year_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('levels as new_level', 'new_level.id', 'transfer_requests.next_level_id')
            ->findOrFail($transfer);

        return view('admin.TransferRequest.edit', compact('transfer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransferRequestRequest  $request
     * @param  \App\Models\TransferRequest  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminTransferRequestRequest $request, $transfer)
    {
        $transfer = TransferRequest::whereIn('status', ['new', 'pending'])->find($transfer);

        $new_contract = $this->ConfirmTransferRequest($transfer, $request);
        if ($new_contract) {

            if ($request->file('installment_files')) {
                # add contract files
                $files = $request->file('installment_files');
                foreach ($files as $file) {
                    // generate a new filename. getClientOriginalExtension() for the file extension
                    $filename = $new_contract->student->guardian_id . '/file-byAdmin-U' . Auth::id() . '-C' . $new_contract->id . '-' . time() . '.' . $file->getClientOriginalExtension();

                    $path = Storage::disk('public')->putFileAs(
                        'contract_files',
                        $file,
                        $filename
                    );

                    ContractFile::create([
                        'file_path' => $path,
                        'contract_id' => $new_contract->id,
                        'admin_id' => Auth::id(),
                        'file_type' => 'installment',
                    ]);
                }
            }
            $total = $transfer->minimum_tuition_fee + $transfer->bus_fees + $transfer->bus_fees_vat + $transfer->dept_paid;

            $transfer->update(['status' => 3, 'total_paid' => $total]); // complete
            return redirect()->route('students.contracts.index', $new_contract->student_id)
                ->with('alert-success', 'تم تسجيل التعاقد بنجاح');
        }

        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة التعاقد واتمام عملية السداد ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransferRequest  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransferRequest $transfer)
    {
        if ($transfer->status == 'complete') {
            $contract = Contract::where('old_contract_id',$transfer->contract_id)->first();
            if ($contract) {
                # contract still apper
                return redirect()->back()
                ->with('alert-warning', 'لتتمكن من حذف طلب تجديد التعاقد .. رجاء حذف التعاقد رقم ' . $contract->id . ' اولا ثم حاول مرة اخري.');       
            }
         }

        if ($transfer->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذفا طلب اعادة التعاقد ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف  طلب اعادة التعاقد ');
    }
}
