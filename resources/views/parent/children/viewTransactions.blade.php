@extends('layouts.contentLayoutMaster')

@php
    $breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$contract->student_id), 'name' => $contract->student_name],['link' => route('students.contracts.index',$contract->student_id), 'name' => 'التعاقدات'],['link' => route('students.contracts.index',[$contract->student_id,$contract->id]), 'name' => 'تعاقد '.$contract->year_name]],['title'=> 'دفعات التعاقد رقم #'. $contract->id]];
@endphp

@section('title', 'دفعات التعاقد رقم #'. $contract->id)

@section('page-style')
    <meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .modalDialog1 {
        position: fixed;
        font-family: Arial, Helvetica, sans-serif;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 99999;
        opacity:1;
        -webkit-transition: opacity 400ms ease-in;
        -moz-transition: opacity 400ms ease-in;
        transition: opacity 400ms ease-in;
        pointer-events: auto;
        display:none;
        /*	background:rgba(0,0,0,0.8);*/
    }
    .modal-backdrop1 {
        background: rgba(0,0,0,0.8);
        position: absolute;
        top: 0;
        height: 100%;
        width: 100%;
    }
    .modalDialog1:target {
        opacity:1;
        pointer-events: auto;
    }
    .modalDialog1 .overlay {
        width: 450px;
        position: relative;
        margin: 5% auto;
        padding: 40px 50px;
        border-radius:0;
        background:white;
        z-index: 9999;
    }
    .close1 {
        background:black;
        color: #FFFFFF;
        line-height: 25px;
        position: absolute;
        right: -12px;
        text-align: center;
        top: -10px;
        text-decoration: none;
        font-weight: bold;
        opacity: 1;
        width: 40px;
        height: 30px;
        border-radius: 50%;
        padding: 6px 0px;
    }
    .modal-backdrop1.in{
        opacity:0;
    }
    .close1:focus, .close1:hover {
        background:black;
        color:white;
        opacity:1;
        text-decoration:none;
    }
    .modal-body1 .coupon-btn1, .modal-body1 .thanks-btn1 {
        background: #dc241e;
        width: 36%;
        float: left;
        display: inline-block;
        margin: 30px 20px 20px;
        color: #fff;
        cursor: pointer;
        font-family: "Oswald", sans-serif;
    }
    .modal-head1 {
        text-align:center;
    }
    .modal-body1 .coupon-btn1 {
        background:gray;
    }
    body.modal-open {
        overflow:auto;
        padding-right:0 !important;
    }
    .heading {
        display:table;
        width:100%;
    }
    .middle-section1{
        margin-bottom: 10px;
    }
    #otpVerification{
        direction: ltr;
    }
    #otpVerification input{
        display:inline-block;
        width:50px;
        height:50px;
        text-align:center;
    }
    .customBtn{
        border-radius:0px;
        padding:10px;
        margin-top: 10px;
    }
</style>

@endsection

@section('content')

    <!-- Striped rows start -->
    <div class="row match-height">
        <div class="responseErrorMessage alert mb-1 rounded-0" role="alert" style="display: none">
            <div class="responseErrorMessageBody alert-body"></div>
        </div>

        @foreach($transactions as $key => $transaction)
        <div class="col-lg-6 col-md-6 col-12">
                <div class="card card-profile">
                    <div class="card-body">
                        <x-ui.table>
                            <x-slot name="tbody">
                                    <tr>
                                        <th>كود</th>
                                        <th>{{ $transaction->id }}</th>
                                    </tr>
                                    <tr>
                                        <th>الدفعة</th>
                                        <th>{{ $transaction->installment_name }}</th>
                                    </tr>
                                    <tr>
                                        <th>الاساسي</th>
                                        <th>{{ round($transaction->amount_before_discount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>الضرائب</th>
                                        <th>{{ round($transaction->vat_amount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>خ.فترة</th>
                                        <th>{{ round($transaction->period_discount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>خ.قسيمة</th>
                                        <th>{{ round($transaction->coupon_discount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>الأجمالي</th>
                                        <th>{{ round($transaction->amount_after_discount + $transaction->vat_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>المدفوع</th>
                                        <th>{{ round($transaction->paid_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>المتبقي</th>
                                        <th>{{ round($transaction->residual_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>تاريخ الدفع</th>
                                        <th>{{ $transaction->payment_status && $transaction->payment_date ? 'تم الدفع' . $transaction->payment_date : 'يجب الدفع قبل' . $transaction->payment_due }}</th>
                                    </tr>
                                    <tr>
                                        <th>اخر تحديث</th>
                                        <th><abbr title="تاريخ التسجيل : {{ $transaction->created_at->format('Y-m-d h:m:s') }}">{{ $transaction->updated_at->diffforhumans() }}</abbr></th>
                                    </tr>
                                    </tbody>
                            </x-slot>
                        </x-ui.table>
                        <hr class="mb-2" />
                        @if(!$transaction->payment_status)
                        <div class="d-flex justify-content-center align-items-center">
{{--                            <a href=" {{ route('parent.transactionPaymentAttempt', ['student' => $contract->student_id, 'contract' => $contract, 'transaction' => $transaction]) }}">--}}
                                <button type="button" class="openPayment btn btn-primary mb-1" value="{{ round($transaction->residual_amount, 2) }}">الدفع</button>
{{--                            </a>--}}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
            <div id="openModal1" class="modalDialog1">
                <div  class="overlay">
                    <a href="" title="Close" class="close1">X</a>
                    <div class="modal-head1">
                        <div class="modal-header1">
                            <h2 class="modal-title1" id="purchaseLabel">اجراءت الدفع</h2>
                        </div>
                        <div class="modal-body1">
                            <div class="middle-section1">
                                <form class="form-control" id="otpVerification" method="POST" class="mt-5">
                                    <div class="mb-3">
                                        <select style="direction: rtl;"  class="paymentGetaway form-select" aria-label="Default select example">
                                            <option value="-1" selected> -- اختر طريقة الدفع -- </option>
                                            <option value="1" >دفع عن طريق بنك</option>
                                            <option value="3">دفع اون لاين</option>
                                        </select>
                                    </div>

                                    <div class="bankFile mb-3" style="direction: rtl">
                                        <div class="mb-3" class="">
                                            <x-inputs.select.generic select2="" name="bank_id" label="البنك" :options="['-1' => 'اختر البنك'] + GetBanks()" />
                                        </div>
                                        <div class="uploadFile">
                                            <label for="formFile" class="form-label">صوره الايصال</label>
                                            <input required class="form-control" style="width: 74%;" type="file" accept="image/png, image/jpeg ,application/pdf" id="formFile">
                                        </div>
                                        <div class="errorMessage alert alert-danger mb-1 rounded-0" role="alert" style="display: none">
                                            <div class="errorMessageBody alert-body"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr class="mt-2">
                            <button class='btn btn-primary btn-block w-50 customBtn'>تاكيد</button>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop1"></div>
            </div>

    </div>

    <x-ui.SideDeletePopUp />

    <!-- Striped rows end -->
@endsection

@section('page-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var payment_amount = '';

        $(".openPayment").click(function () {
            payment_amount = this.value;
            $(".modalDialog1").css("display","block");
        });
        $(".close1").on('click',function(){
            $(".modalDialog1").css("display","none");
        });
        $(".modal-backdrop1").click(function () {
            $(".modalDialog1").css("display","none");
        });

        $(".bankFile").css("display","none");
        $(".customBtn").attr("disabled", true);

        var paymentGetaway = '';
        $('.paymentGetaway').on('change', function() {
            if(this.value == 1){
                $(".customBtn").attr("disabled", false);
                $(".bankFile").css("display","inline-block");
            }else if(this.value == 3){
                $(".customBtn").attr("disabled", false);
                $(".bankFile").css("display","none");
            }else{
                $(".bankFile").css("display","none");
                $(".customBtn").attr("disabled", true);
            }
            paymentGetaway = this.value;
        });
        var bankId = null;
        $("#bank_id").on('change', function() {
            if(this.value != -1){
                bankId = this.value;
            }else {
                bankId = null;
            }
        });

        $(".customBtn").on('click', function() {
            if(paymentGetaway == 1 && (!bankId || $('#formFile').prop('files').length == 0)){
                $(".errorMessage").css("display","block");
                $('.errorMessageBody').text("يرجي ادحال البنك ورفع الملف");
            }else if(paymentGetaway == 1){
                $(".errorMessage").css("display","none");
                console.log(payment_amount);
                console.log(paymentGetaway);
                console.log($('#formFile').prop('files')[0]);
                console.log(bankId);
                var formData = new FormData();
                formData.append('receipt', $('#formFile').prop('files')[0]);
                var objArr = [];

                objArr.push({
                    "requested_ammount": payment_amount,
                    "method_id": paymentGetaway,
                    "receipt": $('#formFile').prop('files')[0],
                    "bank_id": bankId,
                    "student": {{$contract->student_id}},
                    "contract": {{$contract->id}},
                    "transaction": {{$transaction->id}}
                });
                formData.append('data', JSON.stringify(objArr));

                $.ajax({
                    url: "{{route('parent.transactionPaymentAttempt')}}",
                    method: 'POST',
                    data : formData,
                    contentType: false,
                    processData: false,
                    cache : false,
                    async : false,
                    success: function (response){
                        $(".responseErrorMessage").css("display","block");
                        $('.responseErrorMessageBody').text(response.message);
                        if(response.code == 200){
                            $(".responseErrorMessage").addClass("alert-success");
                        }else{
                            $(".responseErrorMessage").addClass("alert-danger");
                        }
                        $(".modalDialog1").css("display","none");
                    }
                });
            }else if(paymentGetaway ==3){
                $.ajax({
                    url: "student/" + {{$contract->student_id}} + "/transaction/" + {{$transaction->id}},
                    method: 'POST',
                    data: {
                        "requested_ammount": payment_amount,
                        "method_id": paymentGetaway,
                        "receipt": $('#formFile').prop('files')[0],
                        "bank_id": bankId,
                        "student": {{$contract->student_id}},
                        "contract": {{$contract->id}},
                        "transaction": {{$transaction->id}}
                    },
                    success: function (response){
                        console.log(response.params);
                        $.ajax({
                            url: response.url,
                            headers: {
                                'Access-Control-Allow-Origin':  'http://127.0.0.1:8000',
                                'Access-Control-Allow-Methods': 'POST',
                                'Access-Control-Allow-Headers': 'Content-Type, Authorization'
                            },
                            method: 'POST',
                            data: response.params,
                            success: function (response){
                                console.log(response);
                            }
                        });
                    }
                });

            }
        });


    </script>
@endsection

