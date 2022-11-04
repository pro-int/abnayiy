@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('noorAccounts.index'), 'name' => "حسابات نور"],['link' => route('noorAccounts.create'), 'name' => "اضافة حساب جديد" ]],['title'=> 'اضافة حساب جديد']];
@endphp

@section('title', 'اضافة حساب نور ')

@section('content')
@component('components.forms.formCard',['title' =>' اضافة حساب نور' ])

{!! Form::open(['route' => 'noorAccounts.store','method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}
<x-ui.divider>معلومات الحساب</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="الأسم التعريفي للحساب"  icon="file-text" name="account_name"  placeholder="ادخل الأسم التعريفي للحساب"/>
        </div>

        <div class="col-md">
            <x-inputs.text.Input :required=false label="اسم المدرسة" icon="user-plus" name="school_name" placeholder="ادخل اسم المدرسة فقط في حالة ان الحساب يدير اكثر من مدرية" data-msg="ادخل اسم المدرسة" />
        </div>
    </div>

    <x-ui.divider>تفاصيل دخول نظام نور</x-ui-divider>
        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.text.Input  label="اسم مستخدم الحساب نور" icon="file-text" name="username" placeholder="ادخل اسم مستخدم الحساب نور" />
            </div>

            <div class="col-md">
                <x-inputs.password label="كلمة مرور حساب نور في نظام نور" icon="file-text" name="password" placeholder="ادخل كلمة مرور حساب نور في نظام نور" data-msg="اكلمة مرور حساب نور في نظام نور بشكل صحيح" />
            </div>
        </div>

        <div class="col-12 text-center mt-2">
            <x-inputs.submit>اضافة الحساب </x-inputs.submit>
            <x-inputs.link route="noorAccounts.index">عودة</x-inputs.link>
        </div>

        {!! Form::close() !!}

        @endcomponent

        @endsection