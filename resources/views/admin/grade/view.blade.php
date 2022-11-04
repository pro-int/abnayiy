@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('grades.index'), 'name' => "المسار "],['link' => route('grades.edit',$grade), 'name' => "مشاهدة المسار : $grade->grade_name" ]],['title'=> 'المسار المسجلة']];
@endphp

@section('title', 'مشاهدة المسار التعليمي ')

@section('content')

@component('components.forms.formCard',['title' => 'مشاهدة معلومات المسار '])

{!! Form::model($grade, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['grades.update', $grade->id]]) !!}

<x-ui.divider>معلومات المسار</x-ui-divider>

    <div class="row mb-1 center">
        <div class="col-md">
            <x-inputs.text.Input label="اسم المسار التعليمي" icon="file-text" name="grade_name" placeholder="ادخل اسم المسار التعليمي" data-msg="ااسم المسار التعليمي بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="اسم المسار التعليمي في نظام نور" icon="file-text" name="grade_name_noor" placeholder="ادخل اسم المسار التعليمي في نظام نور" data-msg="ااسم المسار التعليمي في نظام نور بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic  label="قسم المقابلات" name="appointment_section_id" data-placeholder="اختر قسم المقابلات" data-msg="رجاء اختيار قسم المقابلات" :options="App\Models\AppointmentSection::sections()" />
        </div>
    </div>
    
    <div class="row mb-1 center">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="المدرسة" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>
        
        <div class="col-md">
            <x-inputs.select.generic select2="" label="النوع" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار النوع" :options="request()->school_id ? App\Models\Gender::genders(true,request()->school_id) : App\Models\Gender::genders(true,$grade->school_id)" />
        </div>
    </div>


    <div class="row mb-1 center">
        <div class="col-md  mb-1">
            <label class="form-label mb-1" for="active"> الحالة </label>
            <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.link route="grades.index">عودة</x-inputs.link>
    </div>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection