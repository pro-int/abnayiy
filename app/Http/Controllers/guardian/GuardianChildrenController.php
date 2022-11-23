<?php

namespace App\Http\Controllers\guardian;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\nationality\StorenationalityRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StorePaymentAttempRequest;
use App\Http\Traits\TransactionTrait;
use App\Models\AcademicYear;
use App\Http\Requests\AcademicYear\StoreAcademicYearRequest;
use App\Http\Requests\AcademicYear\UpdateAcademicYearRequest;
use App\Models\Category;
use App\Models\Contract;
use App\Models\guardian;
use App\Models\Mobile;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Gtech\AbnayiyNotification\ApplySingleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class GuardianChildrenController extends Controller
{
    use TransactionTrait;

    function __construct()
    {
        $this->middleware('permission:guardianChildren-list|', ['only' => ['showChildrens', 'getChildrenDetails']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showChildrens()
    {
        $guardianChildrens = Student::select('students.*', 'nationalities.nationality_name', 'class_rooms.class_name', 'levels.level_name', 'levels.next_level_id', 'schools.school_name', 'grades.grade_name', 'genders.gender_name', 'contracts.id as contract_id', 'contracts.student_id', 'contracts.exam_result')
            ->leftJoin('contracts', function ($query) {
                $query->on('contracts.student_id', '=', 'students.id')
                    ->whereRaw('contracts.id IN (select MAX(a2.id) from contracts as a2 join students as u2 on u2.id = a2.student_id group by u2.id)');
            })
            ->leftjoin('class_rooms', 'contracts.class_id', 'class_rooms.id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->leftjoin('nationalities', 'nationalities.id', 'students.nationality_id')
            ->where('students.guardian_id', Auth::id())
            ->whereHas('contract')->get();

        return view('parent.children.index', compact('guardianChildrens'));

    }

    public function getChildrenDetails(Request $request)
    {
        $contracts = Contract::select(
            'contracts.*',
            'students.student_name',
            'academic_years.year_name',
            'levels.level_name',
            'plans.plan_name',
            DB::raw('CONCAT(users.first_name, " " ,users.last_name) as admin_name')
        )
            ->leftjoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->leftjoin('users', 'users.id', 'contracts.admin_id')
            ->leftjoin('levels', 'levels.id', 'contracts.level_id')
            ->leftjoin('plans', 'plans.id', 'contracts.plan_id')
            ->leftJoin('students', 'students.id', 'contracts.student_id')
            ->leftjoin('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->where('contracts.student_id', $request->id)
            ->where('guardians.guardian_id' , Auth::id())
            ->with(['transactions', 'transportation', 'files'])
            ->orderBy('contracts.id')
            ->get();

        if(count($contracts) == 0){
            return redirect()->route('parent.showChildrens')
                ->with('alert-danger', 'لا يوجد اي ابناء بهذا الرقم ' . $request->id);
        }


        return view('parent.children.view', compact('contracts'));
    }

    public function getContractTransaction(Request $request){

        $contract = Contract::select('contracts.id', 'students.id as student_id', 'students.student_name', 'academic_years.year_name', 'contracts.student_id', 'contracts.status')
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->leftjoin('academic_years', 'academic_years.id', 'contracts.academic_year_id')
            ->leftjoin('guardians', 'guardians.guardian_id', 'students.guardian_id')
            ->where('guardians.guardian_id' , Auth::id())
            ->where('contracts.student_id', $request->student_id)
            ->with('transportation')
            ->findOrFail($request->contract_id);

        $transactions = Transaction::select('transactions.*', 'periods.period_name', 'categories.category_name', 'categories.color', DB::raw('CONCAT(users.first_name, " " ,users.last_name) as admin_name'))
            ->leftjoin('periods', 'periods.id', 'transactions.period_id')
            ->leftjoin('categories', 'categories.id', 'transactions.category_id')
            ->leftjoin('users', 'users.id', 'transactions.admin_id')

            ->where('transactions.contract_id', $contract->id)
            ->orderBy('transactions.id')
            ->get();

        return view('parent.children.viewTransactions', compact('transactions', 'contract'));
    }

    public function showTransactionPaymentAttempt(Request $request){

        $requestData = json_decode($request->get('data'))[0];

        $student = Student::select("guardian_id")->where("id", $requestData->student)->first();

        $transaction = $this->Get_transactions($requestData->transaction);

        if ($msg = $this->CheckNewPaymentStatus($transaction->academic_year_id, $requestData->contract)) {
            return response()->json([
                'code' => 400,
                'message' => $msg,
            ], 200);
        }

        $PaymentAttempt = $this->CreatePaymentAttempt($transaction, $request, [], $student->guardian_id,$requestData);

        if ($PaymentAttempt) {

            $amount = $requestData->requested_ammount ?? $transaction->residual_amount;

            $requestData->requested_ammount = $amount; //add request

            if (!$this->confirmPaymentAttempt($PaymentAttempt, $transaction, $requestData)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'خطأ اثناء محاولة تأكيد الدفعة',
                ], 200);
            }

            return response()->json([
                'code' => 200,
                'message' => 'تم اضافه الدفعه بنجاح',
            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'خطأ اثناء تسجيل الدفعة',
            ], 200);
        }
    }

    protected function CheckNewPaymentStatus(int $academic_year_id, int $contract_id)
    {
        $contract = Contract::select('contracts.id', 'levels.next_level_id', 'contracts.status','students.allow_late_payment')
            ->join('levels', 'levels.id', 'contracts.level_id')
            ->join('students', 'students.id', 'contracts.student_id')
            ->findOrFail($contract_id);

        if (! $contract->allow_late_payment) {
            $year = AcademicYear::findOrfail($academic_year_id);
            // check contract status - not closed
            if (!$year->fiscalYearStatus() && $contract->next_level_id) {
                # refuse to enter page if theres next level id , so student can
                return sprintf('تنتهي السنة المالية لهذا التعاقد في %s ولا يمكن او حذف اي دفعات اخري بعد هذا التاريخ', $year->fiscal_year_end->format('d-m-Y'));
            }

            if ($contract->status == 2 && $contract->next_level_id) {
                return sprintf('تم اغلاق هذا التعاقد ربما يكون الطالب قد ترم ترحيلة الي العام الدراسي التالي او ان ولي الامر قام بتقديم طلب تجديد تعاقد ', $year->fiscal_year_end->format('d-m-Y'));
            }
        }
    }

    protected function Get_transactions($id)
    {
        return transaction::select('transactions.*', 'contracts.student_id', 'contracts.academic_year_id', 'contracts.level_id', 'contracts.plan_id', 'contracts.vat_rate', 'plans.fixed_discount', 'students.guardian_id','contracts.status')
            ->leftjoin('contracts', 'contracts.id', 'transactions.contract_id')
            ->leftjoin('plans', 'plans.id', 'contracts.plan_id')
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->find($id);
    }

    public function confirmPaymentAttempt($PaymentAttempt, $transaction, $request)
    {
        $result = DB::transaction(function () use ($PaymentAttempt, $transaction, $request) {

            $received_ammount =  isset($request->received_ammount) ? $request->received_ammount : $PaymentAttempt->requested_ammount;

            if ($received_ammount <> $PaymentAttempt->requested_ammount) {
                $transaction_data =  $this->getTransactionAmounts($transaction, $PaymentAttempt->coupon, $received_ammount);

                $PaymentAttempt->coupon_discount = $transaction_data['coupon_discount'];
                $PaymentAttempt->period_discount = $transaction_data['new_period_discount'];
            }

            $PaymentAttempt->approved = 1;
            $PaymentAttempt->admin_id = Auth::id();
            $PaymentAttempt->received_ammount = $received_ammount;

            if ($PaymentAttempt->save()) {
//                if ($request->has('notifyuser') && $request->notifyuser) {
//                    $nNotification = new ApplySingleNotification($PaymentAttempt, 3, $transaction->guardian_id);
//                    $nNotification->fireNotification();
//                }

                if (!empty($PaymentAttempt->coupon)) {
                    $this->UpdatecouponUsage($PaymentAttempt->coupon);
                }
                return $transaction->update_transaction();
            }
        });

        return $result;
    }

}
