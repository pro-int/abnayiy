@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => "الطلاب"], ['name' => "مزامنة نظام نور"]],['title'=> 'مزامنة بيانات الطلاب']];
@endphp

@section('title', 'مزامنة بيانات الطلاب')

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

@component('components.forms.formCard',['title' => 'مزامنة بيانات الطلاب'])

{!! Form::open(['route' => 'noor.store','method'=>'POST', 'enctype' => 'multipart/form-data' , 'onsubmit' => 'showLoader(500000)']) !!}

@if(isset($skipped_students) && $skipped_students)
<x-ui.divider color="warning">طلاب لم يتم العثور عليهم </x-ui-divider>

<div class="row mb-1">
    @foreach($skipped_students as $id)
    <div class="col-md-2">
        <span class="badge bg-primary">رقم الهوية : </span>
        <span class="badge bg-warning"> {{ $id }}</span>
    </div>
    @endforeach
</div>
@endif
    <x-ui.divider>معلومات الطلاب</x-ui-divider>
       
        <div class="row mb-1">
            <div class="col-md">
                <label for="formFile" class="form-label">ملف معلومات الطلاب (.xlsx)</label>
                <input class="form-control {{ $errors->has('sheet_path') ? ' is-invalid' : null }}" name="sheet_path" type="file" id="formFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>

                @error('sheet_path')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-md">
                <label class="form-label mb-1" for="updateStudentName">تحديث اسم الطالب </label>
                <x-inputs.checkbox name="updateStudentName">مطابقة اسم الطالب مع نظام نور </x-inpurs.checkbox>
            </div>
        </div>
        <div class="col-12 text-center mt-2">
            <x-inputs.submit id="withLoader">مزامنة معلومات المعلومات</x-inputs.submit>
            <x-inputs.link route="years.index">عودة</x-inputs.link>
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