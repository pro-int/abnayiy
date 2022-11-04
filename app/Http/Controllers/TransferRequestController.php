<?php

namespace App\Http\Controllers;

use App\Helpers\PayfortIntegration;
use App\Models\TransferRequest;
use App\Http\Requests\StoreTransferRequestRequest;
use App\Http\Requests\UpdateTransferRequestRequest;
use App\Http\Traits\ContractTrait;
use App\Http\Traits\ContractTransportation;
use App\Http\Traits\PaymentRequestProcessing;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferRequestController extends Controller
{
    use ContractTrait, ContractTransportation, PaymentRequestProcessing;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StoreTransferRequestRequest $request, $contract)
    {
        
        $contract = Contract::select('contracts.*', 'levels.next_level_id', 'students.nationality_id', 'students.guardian_id', 'students.student_name','students.gender')
            ->leftJoin('levels', 'levels.id', 'contracts.level_id')
            ->leftJoin('students', 'students.id', 'contracts.student_id')
            ->where('students.guardian_id', auth()->id())
            ->with('transfare') 
            ->findOrFail($contract);

        $data = [
            'plan_id' => $request->plan_id,
            'transportation_id' => $request->transportation_id,
            'transportation_payment_id' => $request->transportation_payment_id,
        ];


        $data = $this->TransferContract($contract, $data);

        $data['student_name'] = $contract->student_name; 
        $data['gender'] = $contract->gender; 
        
        return $this->ApiSuccessResponse($data);
    }

    /**
     * Store new student tranfar request.
     *
     * @param  \App\Http\Requests\StoreTransferRequestRequest  $request
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransferRequestRequest $request, $contract)
    {
        $contract = Contract::select('contracts.*', 'levels.next_level_id', 'students.nationality_id', 'students.guardian_id')
            ->leftJoin('levels', 'levels.id', 'contracts.level_id')
            ->leftJoin('students', 'students.id', 'contracts.student_id')
            ->where('students.guardian_id', auth()->id())
            ->with('transfare')
            ->find($contract);

        if (!$contract) {
            return $this->ApiErrorResponse('لم يتم العثور علي التعاقد السابق لاتماعم علمية التحويل', 404);
        }

        if ($contract->transfare && in_array($contract->transfare->getRawOriginal('status'), ['pending','new','complete'])) {
            $stu = $contract->transfare->getRawOriginal('status') == 'new' ? 'يوجد طلب نقل مسجل حاليا في انتظار الدفع' : 'تم معالجة طلب النقل سابقا .. راجع الأدارة';
            return $this->ApiErrorResponse($stu);
        }

        $data = [
            'plan_id' => $request->plan_id,
            'transportation_id' => $request->transportation_id,
            'transportation_payment_id' => $request->transportation_payment_id,
        ];

        $data = $this->TransferContract($contract, $data , $request->transportation_required);

        // check min dept
        if (isset($data['debt'])) {
            if ($request->dept_to_pay < $data['debt']['minumim_debt']) {
                return $this->ApiErrorResponse(sprintf('الحد الأدني الذي يمكن سداداة من المديونية الحالية هو : %s ريال سعودي', $data['debt']['minumim_debt']) , 422);
            }

            if ($request->dept_to_pay > $data['debt']['debt']) {
                return $this->ApiErrorResponse(sprintf('الحد الأقصي الذي يمكن سداداة من المديونية الحالية هو : %s ريال سعودي', $data['debt']['debt']), 422);
            }
        }

        $transfer = DB::transaction(function () use ($request, $contract, $data) {
            $transferRequest = new TransferRequest();

            $transferRequest->contract_id = $contract->id;
            $transferRequest->next_school_year_id =  $data['next_school_year_id'];
            $transferRequest->tuition_fee = $data['tuition_fees']['tuition_fees'];
            $transferRequest->tuition_fee_vat = $data['tuition_fees']['vat_amount'];
            $transferRequest->period_discount = $data['tuition_fees']['period_discount'];
            $transferRequest->minimum_tuition_fee = $data['tuition_fees']['minimum_down_payment'];

            $transferRequest->next_level_id = $contract->next_level_id;
            $transferRequest->academic_year_id = $contract->academic_year_id;
            $transferRequest->plan_id = $request->plan_id;
            $transferRequest->period_id = $data['tuition_fees']['period_id'];
            $transferRequest->due_date = $data['tuition_fees']['due_date'];
            $transferRequest->payment_method_id = $request->payment_method_id;
            $transferRequest->bank_id = $request->bank_id && $request->bank_id != 'undefined' ? $request->bank_id : null;

            if ($request->transportation_required && isset($data['transportation']) && $request->filled('transportation_payment_id') && $request->filled('transportation_id')) {
                $transferRequest->bus_fees = $data['transportation']['fees'];
                $transferRequest->bus_fees_vat = $data['transportation']['vat_amount'];
                $transferRequest->transportation_id = $request->transportation_id;
                $transferRequest->transportation_payment = $request->transportation_payment_id;
            }

            if (isset($data['debt'])) {
                $transferRequest->total_debt = $data['debt']['debt'];
                $transferRequest->minimum_debt = $data['debt']['minumim_debt'];
                $transferRequest->dept_paid = $request->dept_to_pay;
            }

            $transferRequest->saveOrFail();

            $contract->updateQuietly(['status' => 2]);
            return $transferRequest;
        });

        switch ($request->payment_method_id) {
            case 1:
                $method = 'bank_transactions';
                break;
            case 2:
                $method = 'atSchool_transactions';
                break;
            case 3:
                $method = 'payfort_transactions';
                break;
            default:
                $method = 'MethodNotFound';
                break;
        }

        $amount  = $transfer->minimum_tuition_fee + $transfer->bus_fees + $transfer->bus_fees_vat + $transfer->dept_paid;

        // functions in PaymentRequestProcessing trait
        return call_user_func([self::class, $method], $request, $transfer, $amount);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransferRequest  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show($contract, $transfer)
    {
        $transferRequest = TransferRequest::select(
            'transfer_requests.id',
            'transfer_requests.tuition_fee',
            'transfer_requests.tuition_fee_vat',
            'transfer_requests.minimum_tuition_fee',
            "transfer_requests.bus_fees",
            "transfer_requests.bus_fees_vat",
            "transfer_requests.total_debt",
            "transfer_requests.minimum_debt",
            "transfer_requests.dept_paid",
            "transfer_requests.total_paid",
            "transfer_requests.next_school_year_id",
            "transfer_requests.next_level_id",
            "transfer_requests.plan_id",
            "transfer_requests.period_id",
            "transfer_requests.payment_method_id",
            "transfer_requests.transportation_id",
            "transfer_requests.transportation_payment",
            "transfer_requests.created_at",
        )
            ->leftjoin('contracts', 'contracts.id', 'transfer_requests.contract_id')
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->where('students.guardian_id',auth()->id())
            ->where('transfer_requests.contract_id', $contract)
            ->whereIB('transfer_requests.status', ['new','pending','NoPayment'])
            ->find($transfer);


        return $this->ApiSuccessResponse(['transferRequest' => $transferRequest], !$transferRequest ? 'لم يتم العثور علي طلب التحويل' : null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransferRequestRequest  $request
     * @param  \App\Models\TransferRequest  $transferRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransferRequestRequest $request, TransferRequest $transferRequest)
    {
        //
    }

    public function transaction_response(Request $request, $contract, $transfer)
    {
        $objFort = new PayfortIntegration(env('PAYFORT_TEST',true));
        $response = $objFort->processResponse(); 


        $transferModal = TransferRequest::where('payment_ref', $response['merchant_reference'])->find($transfer);
        
        if ($transferModal) {
            if ($response['status'] == '14' ||  $response['status'] == 14) {  
                $request->request->add(['method_id' => 3]); //add online payment to request
                
                $new_contract = $this->ConfirmTransferRequest($transferModal, $request);
                if ($new_contract) {
                    $total = $transferModal->minimum_tuition_fee + $transferModal->bus_fees + $transferModal->bus_fees_vat + $transferModal->dept_paid;
                    $transferModal->update(['status' => 3, 'total_paid' => $total]); // complete
                    $userMsg = 'تم تسجيل الطلب بنجاح في العام الدراسي القادم';
                    
                    $transferModal->status = 'complete';
                } else {
                    $userMsg = 'تمت عملية الدفع بنجاح ولكننا نأسف لأبلاعك انة بسبب خطأ تقني فشل اعادة تسيجل الطالب في العام القادم  تم اعلام الادارة بهذا الخطأ';
                }
            } else {
                $transferModal->status = 'NoPayment';
                $userMsg = $response['error_msg'] ?? 'لم تتم عملية اعادة التعاقد بسبب فشل عملية الدفع';
            }
            $transferModal->save();
        } else {
            $userMsg = 'لم يتم العقور علي طلب  تجديد التعاقد .. رجاء مراجعة الادارة : رقم الطلب '. $transfer;
        }

        # return payment array
        $responseToFront['contract_status'] = $userMsg;
        $responseToFront['status'] = $response['status'];

        if ($response['status'] == '14' ||  $response['status'] == 14) {
            $responseToFront['response_message'] = $response['response_message'];
        } else {
            $responseToFront['error_msg'] = $response['error_msg'] ?? 'لم نتمكن من تأكيد استلام الدفعة';
        }

        $return_url = 'https://student.abnayiy.com/contractForm/'. $transfer;
        // $return_url = 'https://student.abnayiy.com/student';

        if (isset($response['front_url'])) {
            $return_url = $response['front_url'];
        }
        return redirect()->away($return_url . '?' . http_build_query($responseToFront), 302, $responseToFront);
    }
}
