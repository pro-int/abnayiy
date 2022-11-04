@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('students.contracts.index',$student), 'name' => "الطالب : $student->student_name"], ['link' => route('students.contracts.transportations.index' ,[$student->id, $contract]), 'name' => "مشاهدة خدمة النقل"]],['title' => 'مشاهدة خدمة النقل ']];
@endphp

@section('title', sprintf('مشاهدة حدمة النقل للطالب %s - العقد رقم #%s', $student->student_name, $contract))

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
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

@component('components.forms.formCard',['title' => sprintf('مشاهدة حدمة النقل للطالب <span class="text-danger">%s - العقد رقم #%s</span>', $student->student_name, $contract)])

{!! Form::model($transportation, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['students.contracts.transportations.update', [$student->id,$contract,$transportation->id]]]) !!}

<x-ui.divider>معلومات الطالب</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="خطة النقل" name="transportation_id" data-placeholder="اختر خطة النقل" :options="App\Models\Transportation::transportations()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic label="خطة السداد" name="payment_type" data-placeholder="اختر خطة السداد" :options="App\Models\Transportation::payment_plans()" />
        </div>
    </div>
    <div class="row mb-1">

        <div class="col-md">
            <x-inputs.text.Input label="الرسوم" name="base_fees" :disabled="true" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="الضرائب"  name="vat_amount" :disabled="true"  />
        </div>
    </div>
    
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="الأجمالي" name="total_fees" :disabled="true"  />
        </div>

        <div class="col-md">
            <x-inputs.text.Input icon="map-pin" label="عنوان النقل" name="address"  />
        </div>

        <div class="col-md">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ الانتهاء" icon="calendar" name="expire_at" placeholder="ادخل تاريخ الانتهاء بالصيغة الدولية" data-msg="ادخل تاريخ الانتهاء بشكل صحيح" />
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.link route="students.contracts.transportations.index" :params="[$student, $contract]">عودة</x-inputs.link>
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
