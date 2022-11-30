@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('withdrawals.index'), 'name' => "الطلبات"],['name'=> 'طلبات الأنسحاب']],['title' => 'مشاهدة طلب الأنسحاب']];
@endphp

@section('title', sprintf('مشاهدة الطلب رقم : %s | %s',$withdrawalApplication->id , $withdrawalApplication->student_name))

@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/katex.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/monokai-sublime.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/quill.snow.css'))}}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<!-- Page css files -->
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')

@component('components.forms.formCard',['title' => sprintf('مشاهدة الطلب رقم : %s - %s',$withdrawalApplication->id , $withdrawalApplication->student_name)])

{{ Form::model($withdrawalApplication,['route' => ['parent.withdrawals.update',$withdrawalApplication->id],'method'=> 'PUT' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()']) }}

<x-ui.divider>معلومات الطالب</x-ui.divider>

    <div class="row mb-1" id="student_info">
        <div class="col-md">
            <x-inputs.text.Input label="اسم الطالب" name="student_name" placeholder="ادخل اسم الطالب" data-msg="'اسم الطالب بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="رقم الهوية" name="national_id" data-msg="' بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="الصف الدراسي" name="level_name" data-msg="' بشكل صحيح" />
        </div>

    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="سبب الانسحاب" name="reason" data-placeholder="ابحث عن سبب الانسحاب" data-msg="رجاءاختيار سبب الانسحاب"  :options="App\Models\WithdrawalApplication::getWithdrawalReasons()"/>
        </div>
        <div class="col-md">
            <x-inputs.text.Input label="اسم المدرسه المحول لها" name="school_name"  data-msg="' بشكل صحيح" />
        </div>

    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="رسوم الطلب" name="amount_fees" data-placeholder="رسوم الطلب" data-msg="رجاء اكتب تعليقك"/>
        </div>
        <div class="col-md">
            <x-inputs.text.Input type="textarea" label="تعليق مختصر عن سبب انسحابك" name="comment" data-placeholder="اكتب تعليقك" data-msg="رجاء اكتب تعليقك"/>
        </div>
    </div>


<div class="col-12 text-center mt-2">
    <x-inputs.link route="parent.withdrawals.index">عودة</x-inputs.link>
</div>

{!! Form::close() !!}

@endcomponent

@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

@endsection
