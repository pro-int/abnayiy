@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('corporates.index'), 'name' => "البنوك"]],['title'=> 'تعديل معلومات المجمع']];
@endphp

@section('title', 'تعديل معلومات المجمع')


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

@component('components.forms.formCard',['title' => sprintf('تعديل معلومات المجمع %s', $corporate->corporate_name)])

{!! Form::model($corporate,['route' => ['corporates.update',$corporate],'method'=>'PUT' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات المجمع</x-ui-divider>

<div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="home" label="اسم المجمع" name="corporate_name" placeholder="ادخل اسم المجمع" data-msg="'اسم المجمع بشكل صحيح" />
        </div>
   
        <div class="col-md">

        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

    </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit >تعديل المجمع</x-inputs.submit>
        <x-inputs.link route="corporates.index">عودة</x-inputs.link>
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
