@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('home'), 'name' => "الرئيسية"],['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year->id), 'name' => $year->year_name],['link' => route('years.semesters.index',$year->id), 'name' => 'الفصول الدراسية'],['name'=> 'تعديل فصل دراسي', 'link' => route('years.semesters.edit',[$year->id,$semester->id])] ],['title' => 'تعديل فصل دراسي']];
@endphp

@section('title', 'تعديل فصل دراسي')

@section('content')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">

@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@component('components.forms.formCard',['title' => 'تعديل الفصل الدراسي '. $semester->semester_name])

{!! Form::model($semester, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['years.semesters.update', $year->id,$semester->id]]) !!}

<x-ui.divider>معلومات الفصل الدراسي</x-ui-divider>

    <div class="row mb-1">      
        <div class="col-md">
            <x-inputs.text.Input label="اسم الفصل الدراسي" icon="bookmark" name="semester_name" placeholder="ادخل اسم الفصل الدراسي" data-msg="ااسم الفصل الدراسي بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ بداية الفصل الدراسي" icon="calendar" name="semester_start" placeholder="ادخل تاريخ بداية الفصل الدراسي " data-msg="ادخل تاريخ بداية الفصل الدراسي بشكل صحيح" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ نهاية الفصل الدراسي" icon="calendar" name="semester_end" placeholder="ادخل تاريخ نهاية الفصل الدراسي " data-msg="ادخل تاريخ نهاية الفصل الدراسي بشكل صحيح" />
        </div>
    </div>


    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input type="number" icon="dollar-sign" label="نسبة % الرسوم للغصل الدراسي" name="semester_in_fees" placeholder="ادخل انسبة % الرسوم للغصل الدراسي" data-msg="'انسبة % الرسوم للغصل الدراسي بشكل صحيح" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input type="number" icon="dollar-sign" label="نسبة % الرسوم المستردة للانسحاب" name="semester_out_fees" placeholder="ادخل انسبة % الرسوم المستردة للانسحاب" data-msg="'انسبة % الرسوم المستردة للانسحاب بشكل صحيح" />
        </div>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit >تعديل الفصل الدراسي</x-inputs.submit>
        <x-inputs.link route="years.semesters.index" :params="[$year]">عودة</x-inputs.link>
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
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>

    @endsection
    @section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

    @endsection