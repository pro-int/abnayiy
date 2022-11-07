@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('years.index'), 'name' => "السنوات الدراسية "],['link' => route('years.periods.index',$year), 'name' => "$year->year_name" ]],['title'=> 'اضافة فترة سداد']];
@endphp

@section('title', 'اضافة فترة طلب انسحاب')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css'))}}">

@endsection

@section('content')
@component('components.forms.formCard',['title' => "اضافة فترة طلب انسحاب للعام الدراسي : $year->year_name" ])

{!! Form::open(['route' => ['years.withdrawalPeriods.store',$year],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>تفاصيل فترة السداد</x-ui-divider>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="اسم الفترة" icon="file-text" name="period_name" placeholder="ادخل اسم الفترة" data-msg="ااسم الفترة بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ بداية الفترة" icon="calendar" name="apply_start" placeholder="ادخل تاريخ بداية الفترة" data-msg="ادخل تاريخ بداية الفترة بشكل صحيح" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ نهاية الفترة" icon="calendar" name="apply_end" placeholder="ادخل تاريخ نهاية الفترة" data-msg="ادخل تاريخ نهاية الفترة بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="الرسوم المستخدمه" name="fees_type" data-placeholder="اختر الرسوم المستخدمه" data-msg="رجاء اختيار الرسوم المستخدمه" :options="['money' => 'مبلغ', 'percentage' => 'نسبة']" />
        </div>

        <div class="col-md">
            <x-inputs.number.Input label="المبلغ المستحق" name="fees" placeholder="ادخل المبلغ المستحق" data-msg="االمبلغ المستحق بشكل صحيح" data-min="1"/>
        </div>

        <div class="col-md">
            <label class="form-label mb-1" for="active"> الحالة </label>
            <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة فنرة </x-inputs.submit>
        <x-inputs.link route="years.withdrawalPeriods.index" :params="['year' => $year]">عودة</x-inputs.link>
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
    <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js'))}}"></script>
    @endsection
    @section('page-script')
    <!-- Page js files -->
    <script>
        $("#fees_type").on("change",function() {
            if($("#fees_type").val() == "percentage"){
                $("#fees").attr("placeholder", "ادخل النسبه");
                $("[for=fees]").text("النسبة");
            }else{
                $("#fees").attr("placeholder", "ادخل المبلغ المستحق");
                $("[for=fees]").text("المبلغ المستحق");
            }
        });
    </script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-number-input.js'))}}"></script>
    @endsection
