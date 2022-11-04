@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('noorAccounts.index'), 'name' => "حسابات نور"],['link' => route('noorAccounts.edit',$noorAccount), 'name' => "تعديل حساب نور" ]],['title'=> 'تعديل حساب نور']];
@endphp

@section('title', 'تعديل حساب نور ')

@section('content')
@component('components.forms.formCard',['title' =>' تعديل حساب نور' ])

@section('content')
@component('components.forms.formCard',['title' =>' تعديل الصف الدرسي : ' . $noorAccount->account_name ])

{!! Form::model($noorAccount, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['noorAccounts.update', $noorAccount->id]]) !!}

<x-ui.divider>معلومات الحساب</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="الأسم التعريفي للحساب"  icon="file-text" name="account_name"  placeholder="ادخل الأسم التعريفي للحساب"/>
        </div>

        <div class="col-md">
            <x-inputs.text.Input required=false label="اسم المدرسة" icon="user-plus" name="school_name" placeholder="ادخل اسم المدرسة فقط في حالة ان الحساب يدير اكثر من مدرية" data-msg="ادخل اسم المدرسة" />
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
            <x-inputs.link route="noorAccounts.index">عودة</x-inputs.link>
        </div>

        {!! Form::close() !!}

        @endcomponent

        @endsection