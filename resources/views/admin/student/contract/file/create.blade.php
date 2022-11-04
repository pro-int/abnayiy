@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.index',['search' => $contract->national_id,'academic_year_id' => $contract->academic_year_id]), 'name' => $contract->student_name],['link' => route('students.contracts.transactions.index',[$contract->student_id,$contract->id]), 'name' => 'تعاقد '. $contract->year_name],['name' => "مرفقات التعاقد"]],['title'=> 'ادارة مرفقات التعاقد']];
@endphp

@section('title', 'اضافة مرفق جديد')

@section('content')

@component('components.forms.formCard',['title' => 'اضافة مرفق جديد'])

{!! Form::open(['route' => ['students.contracts.files.store',[$contract->student_id,$contract->id]],'method'=>'POST' , 'onsubmit' => 'showLoader(10000)','enctype'=>"multipart/form-data"]) !!}

<x-ui.divider>معلومات الملف المرفق</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="نوع الملف" name="file_type" data-placeholder="اختر نوع الملف" data-msg="رجاء اختيار نوع الملف" :options="['' => 'اختر نوع الملف'] + getFileTypes()" />
        </div>
 
        <div class="col-md">
        <label for="file_path" class="form-label" for="file_path">الملف</label>
            <input type="file" class="form-control {{ $errors->has('file_path') ? ' is-invalid' : null }}" id="file_path" name="file_path" accept="image/png, image/jpeg ,application/pdf">
            @error('file_path')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة المرفق</x-inputs.submit>
        <x-inputs.link route="students.index" :params="['search' => $contract->national_id,'academic_year_id' => $contract->academic_year_id]">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection