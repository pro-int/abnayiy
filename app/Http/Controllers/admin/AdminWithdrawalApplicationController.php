<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\withdrawalApplication\StoreWithdrawalApplicationRequest;
use App\Http\Requests\withdrawalApplication\UpdateWithdrawalApplicationRequest;
use App\Http\Traits\ContractTrait;
use App\Models\AcademicYear;
use App\Models\Contract;
use App\Models\guardian;
use App\Models\Student;
use App\Models\StudentTransportation;
use App\Models\WithdrawalApplication;
use App\Models\WithdrawalPeriod;
use App\Services\WithdrawalFeesServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWithdrawalApplicationController extends Controller
{
    use ContractTrait;
    public WithdrawalFeesServices $withdrawalService;

    function __construct(WithdrawalFeesServices $withdrawalFeesServices)
    {
        $this->withdrawalService = $withdrawalFeesServices;
        $this->middleware('permission:withdrawal-applications-list|withdrawal-applications-create|withdrawal-applications-edit|withdrawal-applications-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:withdrawal-applications-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:withdrawal-applications-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:withdrawal-applications-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdrawalApplication = WithdrawalApplication::select("student_transportations.id as trans_id","withdrawal_applications.*", "students.student_name", "students.national_id", "levels.level_name", "academic_years.year_name")
            ->leftjoin("students", "students.id", "withdrawal_applications.student_id")
            ->leftjoin('contracts', function ($join){
                $join->on('contracts.student_id', '=', 'withdrawal_applications.student_id')
                    ->on('contracts.academic_year_id', '=', 'withdrawal_applications.academic_year_id');
            })
            ->leftJoin('levels', 'levels.id', 'contracts.level_id')
            ->leftJoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->leftjoin('student_transportations', function ($join){
                $join->on('student_transportations.student_id', '=', 'students.id')
                    ->on('student_transportations.contract_id', '=', 'contracts.id');
            })
            ->paginate(10);

       // dd($withdrawalApplication);

        return view('admin.withdrawalApplication.index', compact('withdrawalApplication'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$year = $this->GetAdmissionAcademicYear();
        return view('admin.withdrawalApplication.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreWithdrawalApplicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWithdrawalApplicationRequest $request)
    {
        $time =  $request->filled('date') ? $request->date : Carbon::now()->toDateString();
        $amount_fees = 0;

        $year = AcademicYear::where('current_academic_year', 1)->first();

        $period = WithdrawalPeriod::select("withdrawal_periods.*")
        ->where("withdrawal_periods.apply_start", "<=", $time)->where("withdrawal_periods.apply_end", ">=", $time)->where("withdrawal_periods.active", 1)->first();

        if($period){
            $contract = Contract::select("contracts.*")
                ->where("contracts.academic_year_id", $period->academic_year_id)
                ->where("contracts.student_id", $request->get("student_id"))
                ->with('transactions')
                ->first();

            if($period->fees_type == "money"){
                $convertedAmount = ($period->fees / $contract->tuition_fees);
                $amount_fees = ($contract->tuition_fees * $convertedAmount) + ($contract->vat_amount * $convertedAmount);
            }else{
                $amount_fees = ($contract->tuition_fees * ($period->fees / 100)) + ($contract->vat_amount * ($period->fees / 100));
            }
        }

        if($amount_fees == 0){
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة طلب الانسحاب بسبب عدم وجود فتره انسحاب صحيحة');
        }

        $withdrawalApplication = WithdrawalApplication::create([
            "student_id" => $request->get("student_id"),
            "academic_year_id" => $period ? $period->academic_year_id : $year->id,
            "reason" => $request->get("reason"),
            "comment" => $request->get("comment"),
            "amount_fees" => $amount_fees,
            "date" => $time,
            "school_name" => $request->get("school_name")
        ]);

        if ($withdrawalApplication) {
            return redirect()->route('withdrawals.index')
                ->with('alert-success', 'تم اضافة طلب الانسحاب بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة طلب الانسحاب');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WithdrawalApplication  $withdrawalApplication
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $withdrawalApplication = WithdrawalApplication::select("withdrawal_applications.*", "students.student_name", "students.national_id", "levels.level_name", "academic_years.year_name")
            ->leftjoin("students", "students.id", "withdrawal_applications.student_id")
            ->leftjoin('contracts', function ($join){
                $join->on('contracts.student_id', '=', 'withdrawal_applications.student_id')
                    ->on('contracts.academic_year_id', '=', 'withdrawal_applications.academic_year_id');
            })
            ->leftJoin('levels', 'levels.id', 'contracts.level_id')
            ->leftJoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->where("withdrawal_applications.id", $id)
            ->first();

        return view('admin.withdrawalApplication.view', compact( 'withdrawalApplication'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WithdrawalApplication  $withdrawalApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(UpdateWithdrawalApplicationRequest $request,$id)
    {
        $withdrawalApplication = WithdrawalApplication::findOrFail($id);
        $studentTrans = StudentTransportation::where("student_id", $withdrawalApplication->student_id)->count();

        $transportationFees = null;
        $amountFees = $withdrawalApplication->amount_fees;

        if($studentTrans > 0 && $request->get("fees") != ''){
            $transportationFees = $request->get("fees");
            $amountFees += $transportationFees;
        }

        $withdrawalPeriodTable = $withdrawalApplication->update([
            "application_status" => 1,
            "transportation_fees" => $transportationFees,
            "amount_fees" => $amountFees
        ]);

        if ($withdrawalPeriodTable) {
            $this->withdrawalService->saveWithdrawalFees($withdrawalApplication);
            return response()->json([
                'code' => 200,
                'message' => 'تم تعديل طلب الانسحاب بنجاح',
            ], 200);
        }

        return response()->json([
            'code' => 400,
            'message' => 'خطأ اثناء تعديل طلب الانسحاب',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateWithdrawalApplicationRequest  $request
     * @param  \App\Models\WithdrawalApplication  $withdrawalApplication
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWithdrawalApplicationRequest $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WithdrawalApplication  $withdrawalApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawalApplication $withdrawalApplication)
    {
        if ($withdrawalApplication->delete()) {
            return redirect()->route('withdrawals.index')
                ->with('alert-success', 'تم حذف الطلب بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف الطلب ');
    }
}
