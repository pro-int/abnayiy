@extends('layouts.contentLayoutMaster')

@php
    $breadcrumbs = [[['link' => route('parent.showChildrens'), 'name' => 'الابناء'],['link' => route('parent.contractTransaction',["student_id" => $contract->student_id, "contract_id" => $contract->id]), 'name' => $contract->student_name],['link' => route('parent.contractTransaction',["student_id" => $contract->student_id, "contract_id" => $contract->id]), 'name' => 'تعاقد '.$contract->year_name]],['title'=> 'دفعات التعاقد رقم #'. $contract->id]];
@endphp

@section('title', 'دفعات التعاقد رقم #'. $contract->id)

@section('page-style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                            <x-slot name="thead">
                                <tr>
                                    <th>كود</th>
                                    <th>{{ $transaction->id }}</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">

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
                                <button type="button" class="openPayment btn btn-primary mb-1" value="{{ round($transaction->residual_amount, 2) . "," . $transaction->id }}">الدفع</button>
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
                                        <div class="mb-3 uploadFile">
                                            <label for="formFile" class="form-label">صوره الايصال</label>
                                            <input required class="form-control" style="width: 74%;" type="file" accept="image/png, image/jpeg ,application/pdf" id="formFile">
                                        </div>
                                        <div class="errorMessage alert alert-danger mb-1 rounded-0" role="alert" style="display: none">
                                            <div class="errorMessageBody alert-body"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3" style="direction: rtl">
                                        <label class="form-label">كود الخصم</label>
                                        <input class="form-control" style="width: 74%;" id="coupon" type="text" placeholder="ادخل كود الخصم">
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
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        var payment_amount = '';
        var trans_id = '';
        $(".openPayment").click(function () {
            payment_amount = this.value.split(",")[0];
            trans_id = this.value.split(",")[1];
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

            var regExp = new RegExp("^[A-Za-z0-9_-]{1,20}$");
            var couponStatus =  regExp.test($("#coupon").val());
            var coupon = null;
            if(couponStatus){
                coupon = $("#coupon").val();
            }

            if(paymentGetaway == 1 && (!bankId || $('#formFile').prop('files').length == 0)){
                $(".errorMessage").css("display","block");
                $('.errorMessageBody').text("يرجي ادحال البنك ورفع الملف");
            }else if(paymentGetaway == 1){
                $(".errorMessage").css("display","none");
                var formData = new FormData();
                formData.append('receipt', $('#formFile').prop('files')[0]);
                var objArr = [];

                objArr.push({
                    "requested_ammount": payment_amount,
                    "method_id": paymentGetaway,
                    "receipt": $('#formFile').prop('files')[0],
                    "bank_id": bankId,
                    "coupon": coupon,
                    "student": {{$contract->student_id}},
                    "contract": {{$contract->id}},
                    "transaction": trans_id
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
                        location.reload();
                    }
                });
            }else if(paymentGetaway ==3){
                $.ajax({
                    url: "student/" + {{$contract->student_id}} + "/transaction/" + trans_id,
                    method: 'POST',
                    data: {
                        "requested_ammount": payment_amount,
                        "method_id": paymentGetaway,
                        "receipt": null,
                        "bank_id": null,
                        "coupon": coupon,
                        "student": {{$contract->student_id}},
                        "contract": {{$contract->id}},
                        "transaction": trans_id
                    },
                    success: function (response){
                        console.log(response);
                        if(response.url){
                            $.ajax({
                                url: '{{ route('parent.sendPayfortRequest') }}',
                                method: 'POST',
                                dataType: "html",
                                data: {
                                    "path": response.url,
                                    "params": response.params
                                },
                                success: function (response){
                                    console.log(response);
                                }
                            });
                        }
                    }
                });

            }
        });


    </script>
@endsection

