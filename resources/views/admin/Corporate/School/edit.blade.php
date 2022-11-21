@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('schools.index'), 'name' => "المدارس"]],['title'=> 'تعديل معلومات المدرسة']];
@endphp

@section('title', 'تعديل معلومات المدرسة')

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

@component('components.forms.formCard',['title' => sprintf('تعديل معلومات المدرسة %s', $school->school_name)])

{!! Form::model($school,['route' => ['schools.update',$school],'method'=>'PUT' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات المدرسة</x-ui.divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="المجمع الدراسي" name="corporate_id" data-placeholder="اختر المجمع الدراسي" :options="corporates(true)" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input icon="home" label="اسم المدرسة" name="school_name" placeholder="ادخل اسم المدرسة" data-msg="'اسم المدرسة بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <label class="form-label mr-1" for="active"> الحالة </label>
            <x-inputs.checkbox name="active">مفعل</x-inputs.checkbox>
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit >تعديل المجمع</x-inputs.submit>
        <x-inputs.link route="schools.index">عودة</x-inputs.link>
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
