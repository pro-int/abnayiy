@extends('layouts.contentLayoutMaster')


@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$student), 'name' => "طالب #$student"],['link' => route('students.contracts.index',[$student,$transaction->contract_id]), 'name' => 'تعاقد #'.$transaction->contract_id],['link' => route('students.contracts.transactions.show',[$student,$transaction->contract_id,$transaction->id]), 'name' => "دفعة #$transaction->id"]],['title'=> 'اضافة دفعة جديدة']];
@endphp


@section('title', "اضافة سجل جديد للعقد رقم #$transaction->contract_id - دفعة #$transaction->id")

@section('vendor-style')
<!-- vendor css files -->
<link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
<link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/modal-create-app.css')) }}">
@endsection
@section('content')
    @if($errors->any())
        <div class="alert alert-danger mb-1 rounded-0" role="alert">
            @foreach($errors->all() as $error)
                <div class="alert-body">{{ $error }}</div>
            @endforeach
        </div>
    @endif
@component('components.forms.formCard',['title' => sprintf('تسجيل دفعة %s #%s - متبقي %s',$transaction->installment_name,$transaction->id,$transaction->residual_amount)])

<x-ui.divider>معلومات الدفعة</x-ui-divider>

    <div class="row mb-1 ">
        <div class="col-md">
            <x-inputs.text.Input label="قيمة الدفعة" icon="file-text" name="amount_before_discount" :disabled="true" :value="$transaction->amount_before_discount" />
        </div>

        @if($transaction->vat_amount)
        <div class="col-md">
            <x-inputs.text.Input label="قيمة الضرائب" icon="file-text" name="vat_amount" :disabled="true" :value="$transaction->vat_amount" />
        </div>
        @endif


        @if($transaction->period_discount)
        <div class="col-md">
            <x-inputs.text.Input label="خصومات الفترة" icon="file-text" name="period_discount" :disabled="true" :value="$transaction->period_discount" />
        </div>
        @endif

        @if($transaction->coupon_discount)
        <div class="col-md">
            <x-inputs.text.Input label="خصومات الفسيمة" icon="file-text" name="coupon_discount" :disabled="true" :value="$transaction->coupon_discount" />
        </div>
        @endif

        @if($transaction->amount_before_discount != $transaction->amount_after_discount )
        <div class="col-md">
            <x-inputs.text.Input label="بعد الخصم" icon="file-text" name="amount_after_discount" :disabled="true" :value="$transaction->amount_after_discount" />
        </div>
        @endif

        <div class="col-md">
            <x-inputs.text.Input label="الاجمالي" icon="file-text" name="total" :value="$transaction->amount_after_discount + $transaction->vat_amount" :disabled="true" />
        </div>

        @if($transaction->paid_amount)
        <div class="col-md">
            <x-inputs.text.Input label="مدفوع" icon="file-text" name="paid_amount" :disabled="true" :value="$transaction->paid_amount" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="متبقي" icon="file-text" name="total" :disabled="true" :value="$transaction->residual_amount > 0 ? $transaction->residual_amount : 'مدفوع'" />
        </div>
        @endif

    </div>


    <x-ui.divider>تفاصيل الدفعة الجديدة</x-ui-divider>

        @if($transaction->residual_amount > 0)
        @if($transaction_info['new_period_discount'])
        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <x-inputs.text.Input label="خصم الفترة الحالية" icon="dollar-sign" name="new_period_discount" :value="$transaction_info['new_period_discount']" class="is-valid" divClass="is-valid"  readonly />
            </div>
        </div>
        @endif

        @if($transaction_info['coupon_code'] && $transaction_info['coupon_discount'])
        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <x-inputs.text.Input label="خصم قسيمة ({{ $transaction_info['coupon_code'] }})" icon="dollar-sign" name="coupon_discount" :value="$transaction_info['coupon_discount']" class="is-valid" divClass="is-valid" />
            </div>
        </div>
        @endif


        {!! Form::open(['route' => ['students.contracts.transactions.attempts.store',['student' => $student,'contract' => $contract,'transaction' => $transaction]],'method'=>'POST','enctype'=>"multipart/form-data" ,'onsubmit' => 'showLoader()']) !!}

        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <x-inputs.text.Input label="المطلوب سداداة" icon="file-text" name="residual_amount" :disabled="true" :value="$transaction_info['residual_amount']" />
            </div>
        </div>

        @if(!request()->has('coupon_code') || empty(request()->coupon_code))
        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <button type="button" class="btn btn-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#refuseCoupon">
                    اضافة قسيمة
                </button>
            </div>
        </div>

        @else

        <div class="row mb-1 justify-content-center mt-1">
            <div class="col-md-6">
                {!! Form::label('coupon_code','القسيمة') !!}
                {!! Form::label('coupon_code',request()->coupon_code,['class' => 'form-control '. ($transaction_info['is_coupon_valid'] ? 'is-valid' : 'is-invalid')]) !!}
                @if(!$transaction_info['is_coupon_valid'])
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $transaction_info['message'] ?? 'قسيمة غير صالحة' }}</strong>
                </span>
                @else
                <span class="valid-feedback">
                    {{ $transaction_info['message'] ??  'تم تطبيق القسيمة' }}
                </span>
                <input type="hidden" name="coupon" value="{{ request()->coupon_code }}">
                @endif
            </div>
        </div>

        <div class="row mb-1 justify-content-center mt-1">
            <div class="col-md-6">
                <a href="{{ url()->current() }}" class="btn btn-sm btn-danger">ازالة القسيمة <em data-feather="trash"></em></a>
            </div>
        </div>

        @endif


        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <x-inputs.text.Input :required="false" label="المبلغ المدفوع" icon="file-text" name="requested_ammount" :value="old('requested_ammount')" :placeholder="sprintf('فيمة الدفعة بحد اقصي %s ', $transaction_info['residual_amount'])" />
                <small id="hint" class="form-text text-danger">اترك هذا الحقل فارغ لدفع كامل المبلغ</small>
                <input type="hidden" name="max_amount" value="{{ $transaction->residual_amount - $transaction_info['coupon_discount'] - $transaction_info['new_period_discount'] }}">
            </div>
        </div>

        <div class="row mb-1 justify-content-center">

            <div class="col-md-6">
                <x-inputs.select.generic select2="" name="method_id" label="طريقة الدفع" onchange="checkPaymentMethod()" :options="App\Models\PaymentMethod::paymentMethods(1,[1,2,4])" />
            </div>
        </div>

        <div class="row mb-1 justify-content-center">
            <div class="col-md-3">
                <x-inputs.select.generic select2="" name="bank_id" label="البنك" :options="['' => 'اختر البنك'] + GetBanks()" />
            </div>
            <div class="col-md-3">
                <x-inputs.select.generic select2="" name="payment_network_id" label="الشبكة" :options="['' => 'اختر الشبكة'] + GetNetworks()" />
            </div>
        </div>

        <div class="row mb-1 justify-content-center">
            <div class="col-md-3">
                <label class="form-label mb-1" for="is_confirmed"> دفعة مؤكدة </label>
                <x-inputs.checkbox name="is_confirmed">خصم الدفعة مباشرة من حساب الطالب</x-inputs.checkbox>
            </div>

            <div class="col-md-3">
                <label class="form-label mb-1" for="notifyuser"> ارسال اشعار </label>
                <x-inputs.checkbox name="notifyuser">اعلام ولي الامر بأستلام الدفعة</x-inputs.checkbox>
            </div>
        </div>

        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <label for="receipt" class="form-label mb-1" for="receipt">صوره الايصال </label>
                <input required type="file" class="form-control" id="receipt" name="receipt" accept="image/png, image/jpeg ,application/pdf">
            </div>
        </div>


        <div class="col-12 text-center mt-2">
            <x-inputs.submit>تسجيل الدفعة</x-inputs.submit>
            <x-inputs.link route="students.contracts.index" :params="[$student,$contract]">عودة</x-inputs.link>
        </div>

        {!! Form::close() !!}
        @endif
        @endcomponent


        <div class="modal fade add_back" id="refuseCoupon" tabindex="-1" aria-labelledby="AddCouponLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="res">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddCoupon">اضافة قسيمة خصم</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form role="form" method="GET" name="transactionsrefuse" action="{{ url()->current() }}">
                        <div class="modal-body">
                            <div class="col-md">
                                <x-inputs.text.Input label="قسيمة الخصم" icon="file-text" name="coupon_code" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                عوده
                            </button>
                            <x-inputs.submit class="btn btn-warning  me-1">تطبيق القسيمة</x-inputs.submit>

                        </div>

                    </form>
                </div>
            </div>
        </div>
        @endsection

        @section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
        @endsection
        @section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/pages/modal-add-new-cc.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/pages/page-pricing.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/pages/modal-add-new-address.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/pages/modal-create-app.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/pages/modal-two-factor-auth.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/pages/modal-share-project.js')) }}"></script>

        <script>
            function checkPaymentMethod() {
                let method_id = document.getElementById('method_id')
                let bank_id = document.getElementById('bank_id')
                let payment_network_id = document.getElementById('payment_network_id')
                bank_id.value = ''
                payment_network_id.value = ''
                method_id.value == 1 ? bank_id.removeAttribute('disabled') : bank_id.setAttribute('disabled', 1)
                method_id.value == 4 ? payment_network_id.removeAttribute('disabled') : payment_network_id.setAttribute('disabled', 1)
            }

            checkPaymentMethod()
        </script>
        @endsection
