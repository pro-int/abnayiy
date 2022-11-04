<?php

namespace App\Http\Traits;

use App\Helpers\PayfortIntegration;
use App\Models\PaymentAttempt;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

trait PaymentRequestProcessing
{
    use TransactionTrait;
    /**
     * @param \Illuminate\Http\Request $request
     */

    protected function atSchool_transactions(Request $request, $transfer, $amount)
    {
        $transfer->status = 'pending';
        $transfer->save();

        return $this->ApiSuccessResponse(null, 'برجاء التوجة الي قسم الحسابات لدفع مبلع : ' . $amount . ' ر.س ' . $transfer->payment_due);
    }

    protected function bank_transactions(Request $request, $transfer, $amount)
    {
        // cache the file
        $file = $request->file('receipt');

        // generate a new filename. getClientOriginalExtension() for the file extension
        $filename = Auth::id() . '/receipt-byUser-U' . Auth::id() . '-Transfer-' . $transfer->id . '-' . time() . '.' . $file->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs(
            'receipts',
            $file,
            $filename
        );

        $transfer->payment_ref = $path;
        $transfer->status = 'pending';
        $transfer->save();

        return $this->ApiSuccessResponse(null, 'تم استلام ايصال سداد مبلغ   : ' . $amount . ' ر.س بنجاح .. سيتم مراجعة التحويل من خلال الأدارة في خلال 3 ايام عمل');
    }

    public function payfort_transactions(Request $request, $transfer, $amount)
    {
        $ref = rand(0, getrandmax());

        $objFort = new PayfortIntegration(env('PAYFORT_TEST',true));

        $objFort->customerEmail = Auth::user()->email;
        $objFort->amount = $amount;
        $objFort->itemName = 'سداد  رسوم العام القادم';
        $objFort->return_url = route('transaction_response', ['contract' => $transfer->contract_id, 'transfer' => $transfer->id]);
        $form_array = $objFort->processRequest($ref); // 'url' => $gatewayUrl, 'params' => $postData, 'paymentMethod' => $paymentMethod)
        // $form_array['params']['front_url'] = 'https://' . $request->returnUrl;

        $transfer->payment_ref = $ref;
        $transfer->status = 'pending';
        $transfer->save();

        return $this->ApiSuccessResponse(['form_array' => $form_array]);
    }

    protected function MethodNotFound()
    {
        return $this->ApiErrorResponse('لا يمكن العثور علي طريقة السداد المختارة');
    }
}