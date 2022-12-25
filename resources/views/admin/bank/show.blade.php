@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('banks.index'), 'name' => "البنوك"]],['title'=> 'مشاهدة معلومات البنك ']];
@endphp

@section('title', 'مشاهدة معلومات البنك ')

@section('content')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@component('components.forms.formCard',['title' => 'مشاهدة معلومات البنك جديج'])

{!! Form::model($bank,['route' => ['banks.update',$bank],'method'=>'GET']) !!}

<x-ui.divider>معلومات البنك</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="home" label="'اسم البنك" name="bank_name" placeholder="ادخل اسم البنك" data-msg="'اسم البنك بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="اسم الحياب" icon="file-text" name="account_name" placeholder="ادخل اسم الحياب" data-msg="ااسم الحياب بشكل صحيح" />
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="رقم الحساب النكي" icon="edit" name="account_number" placeholder="ادخل رقم الحساب النكي بالصيغة الدولية" data-msg="ادخل رقم الحساب النكي بشكل صحيح" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input label="رقم IBAN" icon="anchor" name="account_iban" placeholder="ادخل رقم IBAN بالصيغة الدولية" data-msg="ادخل رقم IBAN بشكل صحيح" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input label="Odoo Journal ID" icon="anchor" name="journal_id" placeholder="ادخل Odoo Journal ID" data-msg="ادخل Odoo Journal ID بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active" >مفعل</x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.link route="banks.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection

    @section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    @endsection
    @section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    @endsection
