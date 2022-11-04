<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StudentTransportation;
use App\Http\Requests\StoreStudentTransportationRequest;
use App\Http\Requests\UpdateStudentTransportationRequest;
use App\Models\Contract;
use App\Models\Student;
use App\Models\StudentParticipation;
use App\Models\Transaction;
use App\Models\Transportation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminStudentTransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Student $student, $contract)
    {
        $contract = Contract::select('contracts.id','academic_years.year_name')
        ->leftjoin('academic_years','academic_years.id','contracts.academic_year_id')
        ->where('student_id',$student->id)->findOrFail($contract);

        $transportations = StudentTransportation::select('student_transportations.*', 'transportations.transportation_type', DB::raw('CONCAT(users.first_name, " " ,users.last_name) as admin_name'))
            ->leftjoin('transportations', 'transportations.id', 'student_transportations.transportation_id')
            ->leftjoin('users', 'users.id', 'student_transportations.add_by')
            ->where('student_transportations.contract_id', $contract->id)->get();

        return view('admin.student.transportation.index', compact('transportations','contract','student'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Student $student, $contract)
    {
        return view('admin.student.transportation.create', compact('student', 'contract'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentTransportationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentTransportationRequest $request, $student, Contract $contract)
    {

        $result = DB::transaction(function () use ($request, $student, $contract) {

            $fees = $this->getTransportationFees($request, $request->transportation_id);

            $vat = $fees * ((int) env('VAT_RATE', 15)  / 100);

            $transaction = new transaction();
            $transaction->contract_id = $contract->id;
            $transaction->installment_name  =  $request->expire_at ? 'رسوم النقل حتي : ' . $request->expire_at : 'رسوم النقل';
            $transaction->amount_before_discount = $fees;
            $transaction->vat_amount = $vat;
            $transaction->amount_after_discount = $fees;
            $transaction->residual_amount =  $vat + $fees;
            $transaction->transaction_type = 'bus';
            $transaction->payment_due = Carbon::now();
            $transaction->save();

            $student_transportation = new StudentTransportation();

            $student_transportation->student_id = $student;
            $student_transportation->contract_id = $contract->id;
            $student_transportation->transportation_id = $request->transportation_id;
            $student_transportation->payment_type = $request->payment_type;
            $student_transportation->base_fees = $fees;
            $student_transportation->vat_amount = $vat;
            $student_transportation->total_fees = $fees + $vat;
            $student_transportation->address = $request->address;
            $student_transportation->expire_at = $request->expire_at;
            $student_transportation->transaction_id = $transaction->id;
            $student_transportation->add_by = Auth::id();
            $student_transportation->save();

            return  $contract->update_total_payments();
        }, 2);

        if ($result) {
            return redirect()->route('students.contracts.transportations.index', [$student, $contract->id])
                ->with('alert-success', 'تم اضافة خطة النقل بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة خطة النقل');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student, $contract, StudentTransportation $transportation)
    {
        return view('admin.student.transportation.view', compact('student', 'contract', 'transportation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student, $contract, StudentTransportation $transportation)
    {
        return view('admin.student.transportation.edit', compact('student', 'contract', 'transportation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentTransportationRequest  $request
     * @param  \App\Models\StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentTransportationRequest $request, $student, $contract, StudentTransportation $transportation)
    {

        $result = DB::transaction(function () use ($request, $transportation) {

            $fees = $this->getTransportationFees($request, $request->transportation_id);

            $vat = $fees * ((int) env('VAT_RATE', 15)  / 100);

            $transportation->payment_type = $request->payment_type;
            $transportation->base_fees = $fees;
            $transportation->vat_amount = $vat;
            $transportation->total_fees = $fees + $vat;
            $transportation->address = $request->address;
            $transportation->expire_at = $request->expire_at;
            $transportation->add_by = Auth::id();
            $transportation->save();

            $transaction = transaction::findOrFail($transportation->transaction_id);
            $transaction->installment_name  =  $request->expire_at ? 'رسوم النقل حتي : ' . $request->expire_at : 'رسوم النقل';
            $transaction->amount_before_discount = $fees;
            $transaction->vat_amount = $vat;
            $transaction->amount_after_discount = $fees;
            $transaction->save();

            return $transaction->update_transaction();
        }, 2);

        if ($result) {
            return redirect()->route('students.contracts.transportations.index', [$student, $contract])
                ->with('alert-success', 'تم تعديل خطة النقل بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل خطة النقل');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentTransportation  $studentTransportation
     * @return \Illuminate\Http\Response
     */
    public function destroy($student, Contract $contract, StudentTransportation $transportation)
    {
        $result = DB::transaction(function () use ($transportation, $contract) {
            $transaction = transaction::findorfail($transportation->transaction_id);
            if ($transaction->paid_amount > 0) {
                $transaction->installment_name  =  'تم الغاء خدمة النفل';
                $transaction->amount_before_discount = 0;
                $transaction->vat_amount = 0;
                $transaction->amount_after_discount = 0;
                $transaction->save();
                $transaction->update_transaction();
            } else {
                $transaction->delete();
            }
            $transportation->delete();
            $transaction->delete();
            return $contract->update_total_payments();
        }, 2);


        if ($result) {
            return redirect()->route('students.contracts.transportations.index', [$student, $contract->id])
                ->with('alert-success', 'تم حذف خطة النقل بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف خطة النقل');
    }

    protected function getTransportationFees($request, $transportation_id)
    {
        $transportation = Transportation::findorfail($transportation_id);
        $fees = 0;
        switch ($request->payment_type) {
            case '1':
                $fees = $transportation->annual_fees;
                break;
            case '2':
                $fees = $transportation->semester_fees;
                break;
            case '3':
                $fees = $transportation->monthly_fees;
                break;
        }
        return $fees;
    }
}
