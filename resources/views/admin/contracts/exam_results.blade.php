@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => "الطلاب"], ['link' => route('students.show_exam_result'), 'name' => "نتائج الطلاب"]],['title'=> 'تسجيل نتائج الطلاب']];
@endphp

@section('title', 'تسجيل نتائج الطلاب')

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

@component('components.forms.formCard',['title' => 'تسجيل نتائج الطلاب'])

{!! Form::open(['route' => 'students.store_exam_result','method'=>'POST', 'enctype' => 'multipart/form-data']) !!}

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
    <x-ui.divider>نتائج الطلاب</x-ui-divider>
        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.select.generic label="السنة الدراسية" name="academic_year_id" data-placeholder="السنة الدراسية" :options="['' => 'اختر السنة الدراسية'] + App\Models\AcademicYear::years()" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic label="نتيجة الطلب" name="exam_result" data-placeholder="رجاء تحديد حالة الطلاب في هذا الملف" :options="['' => 'اختر نتيجة الطلاب', '1' => 'ناجح' , '2' => 'راسب']" />
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-md">
                <label for="formFile" class="form-label">ملف نتائج الطلاب (.xlsx)</label>
                <input class="form-control {{ $errors->has('sheet_path') ? ' is-invalid' : null }}" name="sheet_path" type="file" id="formFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>

                @error('sheet_path')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-md">
                <label class="form-label mb-1" for="ignore_old_result">الأجراء في حالة وجود نتيجة سابقة في نفس العام </label>
                <x-inputs.checkbox name="ignore_old_result">تجاهل نتائج الطالب لنفس العام واعادة تسجيل النتيجة </x-inpurs.checkbox>
            </div>
        </div>
        <div class="col-12 text-center mt-2">
            <x-inputs.submit id="withLoader">تسجيل النتائج</x-inputs.submit>
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