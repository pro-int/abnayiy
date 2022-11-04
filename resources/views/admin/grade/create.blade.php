@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('grades.index'), 'name' => "المسارات الدراسية "],['link' => route('grades.create'), 'name' => 'اضافة مسار' ]],['title'=> 'اضافة مسار جديدة']];
@endphp

@section('title', 'اضافة مسار دراسية ')

@section('content')

@component('components.forms.formCard',['title' => 'اضافة مسار دراسية جديدة '])

{!! Form::open(['route' => 'grades.store','method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات المسار</x-ui-divider>


    <div class="row mb-1 center">
        <div class="col-md">
            <x-inputs.text.Input label="اسم المسار التعليمي" icon="file-text" name="grade_name" placeholder="ادخل اسم المسار التعليمي" data-msg="ااسم المسار التعليمي بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="اسم المسار التعليمي في نظام نور" icon="file-text" name="grade_name_noor" placeholder="ادخل اسم المسار التعليمي في نظام نور" data-msg="ااسم المسار التعليمي في نظام نور بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic label="قسم المقابلات" name="appointment_section_id" data-placeholder="اختر قسم المقابلات" data-msg="رجاء اختيار قسم المقابلات" :options="App\Models\AppointmentSection::sections()" />
        </div>
    </div>

    <div class="row mb-1 center">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="المدرسة" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="النوع" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار النوع" :options="old('school_id') ? App\Models\Gender::genders(true,old('school_id')) : []" />
        </div>
    </div>

    <div class="row mb-1 center">
        <div class="col-md  mb-1">
            <label class="form-label mb-1" for="active"> الحالة </label>
            <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة مسار </x-inputs.submit>
        <x-inputs.link route="grades.index">عودة</x-inputs.link>
    </div>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection