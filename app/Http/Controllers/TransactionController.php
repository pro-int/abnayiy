<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Helpers\PayfortIntegration;
use App\Models\Contract;
use App\Models\PaymentAttempt;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\TransactionTrait;

class TransactionController extends Controller
{
    use TransactionTrait;

    public function transactions(Request $request)
    {
        $student = Student::where('guardian_id', Auth::id())->find($request->student_id);

        if (!$student) {
            return $this->ApiErrorResponse('لم يتم العثور علي الطالب ', 404, ['errors' => ['student_id' => 'لم يتم العثور علي الطالب رقم ' . $request->student_id]]);
        }

        // get last contrat
        $contract = Contract::select(DB::raw('MAX(id) as id'))->where('student_id', $student->id)->first();

        if (!$contract) {
            return $this->ApiErrorResponse('لا توجد مدفوعات في الوقت الحالي', 404);
        }

        $transactions = transaction::select(
            'transactions.id',
            'transactions.installment_name',
            'transactions.discount_rate',
            DB::raw('round(transactions.amount_before_discount,2) as amount_before_discount'),
            DB::raw('round(transactions.period_discount,2) as period_discount'),
            DB::raw('round(transactions.amount_after_discount,2) as amount_after_discount'),
            DB::raw('round(transactions.paid_amount,2) as paid_amount'),
            DB::raw('round(transactions.residual_amount,2) as residual_amount'),
            'transactions.coupon_discount',
            'transactions.payment_status',
            'transactions.vat_amount',
            'transactions.payment_date',
            'transactions.payment_due',
            'transactions.updated_at'
        )
            ->where('transactions.contract_id', $contract->id)
            ->get();

        // foreach ($transactions as $transaction) {
        //     $transaction->transactions = rand(15454, 98498);
        // }

        return $this->ApiSuccessResponse(['transactions' =>  $transactions]);
    }

    public function update_transactions(Request $request)
    {
        $this->validate($request, [
            'method_id' => 'required'
        ]);

        $transaction = $this->Get_transactions($request->transaction_id);
        if (!$transaction) {
            # return response
            return response()->json([
                'done' => true,
                'success' => false,
                'messages' => 'رجاء تحديد الدفعة التي التي ترغب في اتمام عملية الدفع الخاصة بها'
            ], 422);
        }
        if ($request->filled('method_id')) {
            switch ($request->method_id) {
                case 1:
                    return $this->bank_transactions($request, $transaction);
                    break;
                case 2:
                    return $this->atSchool_transactions($request, $transaction);
                    break;
                case 3:
                    return $this->payfort_transactions($request, $transaction);
                    break;
                default:
                    return response()->json([
                        'done' => true,
                        'success' => false,
                        'messages' => 'رجاء تحديد طريقة الدفع'
                    ], 422);
                    break;
            }
        }
    }

    public function atSchool_transactions(Request $request, $transaction)
    {

        $PaymentAttempt = $this->CreatePaymentAttempt($transaction, $request);

        if ($PaymentAttempt) {
            # return the code
            return $this->ApiSuccessResponse(null, 'برجاء التوجة الي قسم الحسابات لدفع مبلع : ' . ($PaymentAttempt->requested_ammount) . ' ر.س قبل ' . $transaction->payment_due);
        }
    }

    public function bank_transactions(Request $request, $transaction)
    {
        $this->validate(
            $request,
            [
                'receipt' => 'required|file|mimes:jpg,jpeg,bmp,png,pdf',
                'bank_id' => 'required'
            ]
        );

        // cache the file
        $file = $request->file('receipt');
        // generate a new filename. getClientOriginalExtension() for the file extension
        $filename = Auth::id() . '/receipt-byUser-U' . Auth::id() . '-T' . $transaction->id . '-' . time() . '.' . $file->getClientOriginalExtension();

        $path = upload($file,'s3','receipts',$filename);


        $PaymentAttempt = $this->CreatePaymentAttempt($transaction, $request, ['attach_pathh' => $path, 'bank_id' => $request->bank_id]);

        if ($PaymentAttempt) {
            # return the code
            return response()->json([
                'done' => true,
                'success' => true,
                'message' => 'تم ارسال ايصال الدفع الي ادارة الحسابات بنجاح .. سنقوم بمراجعتة غي اقرب وقت'
            ]);
        }
    }

    public function payfort_transactions(Request $request, $transaction)
    {
        $ref = rand(0, getrandmax());
        $PaymentAttempt = $this->CreatePaymentAttempt($transaction, $request, ['reference' => $ref]);
        $scheme = app()->isLocal() ? 'http://' : 'https://' ;
        $return_url = $scheme . $_SERVER['HTTP_HOST'] . '/api/user/student/transaction/'.$transaction->id.'/response';
        $objFort = new PayfortIntegration(env('PAYFORT_TEST',true));

        $objFort->customerEmail = Auth::user()->email;
        $objFort->amount = $PaymentAttempt->requested_ammount;
        $objFort->itemName = $transaction->installment_name;
        $objFort->return_url = $return_url;
//        $objFort->return_url = route('payfort_processResponse', $transaction->id);
        $form_array = $objFort->processRequest($ref);
        if ($PaymentAttempt) {
            # return payment array
            info($form_array);
            return $form_array;
        }
        return [];
    }

    public function payfort_processResponse()
    {
        $objFort = new PayfortIntegration(env('PAYFORT_TEST',true));

        $response = $objFort->processResponse();
        info($response);

        $PaymentAttempt = PaymentAttempt::where('reference', $response['merchant_reference'])->first();
        if ($PaymentAttempt) {

            if ($response['status'] == '14' ||  $response['status'] == 14) {
                DB::transaction(function () use ($PaymentAttempt, $response) {
                    $PaymentAttempt->received_ammount = $response['amount'];
                    $PaymentAttempt->approved = 1;
                    $PaymentAttempt->reason = isset($response['response_message']) ? $response['response_message'] : '';
                    $PaymentAttempt->save();

                    transaction::findOrFail($PaymentAttempt->transaction_id)->update_transaction();
                });
            } else {

                $PaymentAttempt->approved = 2;
                $PaymentAttempt->reason = $response['error_msg'] ?? 'لم نتمكن من تأكيد استلام الدفعة';
                $PaymentAttempt->save();
            }
        }

        # return payment array
        $responseToFront['status'] = $response['status'];

        if ($response['status'] == '14' ||  $response['status'] == 14) {
            $responseToFront['response_message'] = $response['response_message'];
        } else {
            $responseToFront['error_msg'] = $response['error_msg'] ?? 'لم نتمكن من تأكيد استلام الدفعة';
        }

        return redirect()->route("parent.showChildrens",$responseToFront);

        //return redirect()->away('https://student.abnayiy.com/student?' . http_build_query($responseToFront), 302, $responseToFront);
    }


    public function getTransactionInfo(Request $request)
    {
        $transaction = $this->Get_transactions($request->transaction_id);

        if ($transaction) {
            return $this->ApiSuccessResponse($this->getTransactionAmounts($transaction, $request->coupon));
        }
        return $this->ApiSuccessResponse([], 'لم يتم العثور علي المبلغ الذي تريد دفعة حاليا', true, false, 201);
    }
}
