@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('types.index'), 'name' => "القسمات التعليمية "],['name' => "اضافة مسار " ]],['title'=> 'القسمات التعليمية المسجلة']];
@endphp

@section('title', 'اضافة مسار تعليمي ')

@section('content')

@component('components.forms.formCard',['title' => 'اضافة مسار دراسي '])

{!! Form::open(['route' => 'types.store','method'=>'POST' , 'onsubmit' => 'showLoader()']) !!}

<x-ui.divider>معلومات القسم الدراسي</x-ui-divider>

    <div class="row mb-1 center">
        <div class="col-md">
            <x-inputs.select.generic label="المجمع الدراسي" name="corporate_id" onchange="getSchools(this)" :options="corporates()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic label="المدرسة" name="school_id" :options="old('corporate_id') ? schools(old('corporate_id')) : ['' => 'اختر المجمع الدراسي']" />
        </div>
    </div>

    <div class="row mb-1 center">
        <div class="col-md-6  mb-1">
            <x-inputs.text.Input icon="align-justify" label="اسم القسم الدراسي" name="school_name" placeholder="ادخل اسم القسم الدراسي" data-msg="'اسم القسم الدراسي بشكل صحيح" />
        </div>

        <div class="col-md-6  mb-1">
            <x-inputs.text.Input icon="align-justify" label="'اسم القسم في نظام نور" name="school_name_noor" placeholder="ادخل اسم القسم في نظام نور" data-msg="'اسم القسم في نظام نور بشكل صحيح" />
        </div>
    </div>
    <div class="row mb-1 center">

        <label class="form-label mb-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة مسار دراسي </x-inputs.submit>

        <x-inputs.link route="types.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection