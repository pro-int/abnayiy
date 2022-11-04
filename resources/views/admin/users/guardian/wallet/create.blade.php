@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('guardians.index'), 'name' => "اولياء الأمور"], ['link' => route('users.edit',$guardian->user->id), 'name' => $guardian->user->getFullName()], ['link' => route('guardians.wallets.index',$guardian->user->id), 'name' => 'المحافظ'], [ 'name' => sprintf('اضافة الي المحفظة (%s)',$wallet->name)]],['title' => 'سحب/ ايداع الأموال']];
@endphp

@section('title', 'سحب / ايداع الرصيد الي محفظة ولي الأمر')

@section('content')

@component('components.forms.formCard',['title' => sprintf('سحب / ايداع الرصيد الي المحفظة <span class="text-danger">(%s)</span> - ولي الأمر <span class="text-danger">(%s)</span>',$wallet->name, $guardian->user->getFullName()) ])

{{ Form::open(['route' => ['guardians.wallets.store',$guardian->guardian_id],'method'=> 'POST' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()','enctype'=>"multipart/form-data"]) }}

<x-ui.divider>محلومات المحفظة</x-ui-divider>

    <input type="hidden" name="wallet" value="{{ request('wallet') }}">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input readonly label="المحفظة" icon="tag" name="name" :value="$wallet->name" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input readonly icon="dollar-sign" label="رصيد المحفظة الحالي" name="balance" :value="$wallet->balanceFloat. ' ر.س'" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="نوع العملية" onchange="updateTransactionType(this)" name="transaction_type" data-msg="رجاء اختيار نوع العملية" :options="$types" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input type="number" label="المبلغ" step=".01" placeholder="رجاء ادخال المبلغ  ر.س" icon="dollar-sign" name="amount" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input label="وصف الحركة" step=".01" placeholder="رجاء كتابة وصف تفصيلي عن الحركة" icon="file-text" name="description" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <label for="receipt" class="form-label" for="receipt">الأيصال</label>
            <input {{ $wallet->slug == DEFAULT_WALLET_SLUG ? 'required' : null }} type="file" class="form-control {{ $errors->has('receipt') ? ' is-invalid' : null }}" id="receipt" name="receipt" accept="image/png, image/jpeg ,application/pdf">
            @error('receipt')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة الحركة المالية</x-inputs.submit>
        <x-inputs.link route="guardians.wallets.show" :params="[$guardian->guardian_id,$wallet->id]">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection

    @section('page-script')
    <script>
        function updateTransactionType(t) {
            const amount = document.getElementById('amount')
            const receipt = document.getElementById('receipt')
            const input_label = $('label[for='+amount.name+']')[0];
            if (t.value){
                if (t.value == 'withdraw') {
                    input_label.innerHTML = 'الميلغ المطلوب سحبة';
                } else if (t.value == 'deposit') {
                    
                    input_label.innerHTML = 'الميلغ المطلوب ايداعة ';
                    
                } 
            } else {

            }
        }
    </script>

    @endsection