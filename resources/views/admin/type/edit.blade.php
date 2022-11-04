@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('types.index'), 'name' => "المسارات التعليمية "],['link' => route('types.edit',$type), 'name' => "تعديل المسار : $type->school_name" ]],['title'=> 'المسارات التعليمية المسجلة']];
@endphp

@section('title', 'تعديل المسار التعليمي ')

@section('content')

@component('components.forms.formCard',['title' => 'تعديل معلومات الفصل '])

{!! Form::model($type, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['types.update', $type->id]]) !!}

<x-ui.divider>معلومات المسار الدراسي</x-ui-divider>

    <div class="row mb-1 center">
        <div class="col-md-6  mb-1">
            <x-inputs.text.Input icon="align-justify" label="'اسم المسار الدراسي" name="school_name" placeholder="ادخل اسم المسار الدراسي" data-msg="'اسم المسار الدراسي بشكل صحيح" />
        </div>

        <div class="col-md-6  mb-1">
            <x-inputs.text.Input icon="align-justify" label="'اسم المسار في نظام نور" name="school_name_noor" placeholder="ادخل اسم المسار في نظام نور" data-msg="'اسم المسار في نظام نور بشكل صحيح" />
        </div>

    </div>
    <div class="row mb-1 center">

        <label class="form-label mb-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>تعديل المسار الدراسي </x-inputs.submit>

        <x-inputs.link route="types.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection