@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('payment_networks.index'), 'name' => "شبكات السداد"]],['title'=> 'اضافة شبكة جديدة']];
@endphp

@section('title', 'مشاهدة  شبكة جديدة')

@section('content')


@component('components.forms.formCard',['title' => sprintf('مشاهدة  معلومات الشبكة : <span class="text-danger">%s</span> ', $PaymentNetwork->network_name)])

{!! Form::model($PaymentNetwork,['route' => ['payment_networks.update',$PaymentNetwork],'method'=>'PUT' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات الشبكة</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="home" label="'اسم الشبكة" name="network_name" placeholder="ادخل اسم الشبكة" data-msg="'اسم الشبكة بشكل صحيح" />
        </div>

    
        <div class="col-md">
            <x-inputs.text.Input label="رقم الحساب النكي" icon="edit" name="account_number" placeholder="ادخل رقم الحساب النكي بالصيغة الدولية" data-msg="ادخل رقم الحساب النكي بشكل صحيح" />
        </div>
       
    </div>
    
    <div class="row mb-1">
        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active" >مفعل</x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.link route="payment_networks.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection
