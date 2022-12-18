<?php

namespace App\Http\Controllers\guardian;

use App\Http\Controllers\Controller;
use App\Http\Requests\withdrawalApplication\StoreWithdrawalApplicationRequest;
use App\Http\Requests\withdrawalApplication\UpdateWithdrawalApplicationRequest;
use App\Http\Traits\ContractTrait;
use App\Models\AcademicYear;
use App\Models\Contract;
use App\Models\guardian;
use App\Models\Student;
use App\Models\WithdrawalApplication;
use App\Models\WithdrawalPeriod;
use App\Services\WithdrawalFeesServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuardianWithdrawalApplicationController extends Controller
{
    use ContractTrait;
    public WithdrawalFeesServices $withdrawalService;

    function __construct(WithdrawalFeesServices $withdrawalFeesServices)
    {
        $this->withdrawalService = $withdrawalFeesServices;
        $this->middleware('permission:guardian-withdrawal-applications-list|guardian-withdrawal-applications-create|guardian-withdrawal-applications-edit|guardian-withdrawal-applications-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:guardian-withdrawal-applications-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:guardian-withdrawal-applications-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:guardian-withdrawal-applications-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdrawalApplication = WithdrawalApplication::select("withdrawal_applications.*", "students.student_name", "students.national_id", "levels.level_name", "academic_years.year_name")
            ->leftjoin("students", "students.id", "withdrawal_applications.student_id")
            ->leftjoin("users", "students.guardian_id", "users.id")
            ->leftjoin('contracts', function ($join){
                $join->on('contracts.student_id', '=', 'withdrawal_applications.student_id')
                    ->on('contracts.academic_year_id', '=', 'withdrawal_applications.academic_year_id');
            })
            ->leftJoin('levels', 'levels.id', 'contracts.level_id')
            ->leftJoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->where("users.id",auth()->user()->id)
            ->paginate(10);

        return view('parent.withdrawalApplication.index', compact('withdrawalApplication'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$year = $this->GetAdmissionAcademicYear();
        return view('parent.withdrawalApplication.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreWithdrawalApplicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWithdrawalApplicationRequest $request)
    {
        $time = Carbon::now()->toDateString();
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
            return redirect()->route('parent.withdrawals.index')
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

        return view('parent.withdrawalApplication.view', compact( 'withdrawalApplication'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WithdrawalApplication  $withdrawalApplication
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $withdrawalApplication = WithdrawalApplication::findOrFail($id);
        $withdrawalPeriodTable = $withdrawalApplication->update([
            "application_status" => 1
        ]);

        if ($withdrawalPeriodTable) {
            $this->withdrawalService->saveWithdrawalFees($withdrawalApplication);
            return redirect()->route('parent.withdrawals.index')
                ->with('alert-success', 'تم تعديل طلب الانسحاب بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل طلب الانسحاب');

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
            return redirect()->route('parent.withdrawals.index')
                ->with('alert-success', 'تم حذف الطلب بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف الطلب ');
    }
}
