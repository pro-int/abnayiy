@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('transportations.index'), 'name' => "خطط النقل"], ['link' => route('transportations.create'), 'name' => "اضافة خطة النقل"]],['title'=> 'اضافة']];
@endphp

@section('title', 'اضافة خطط النقل')

@section('content')

@component('components.forms.formCard',['title' => 'اضافة خطة نقل جديدة'])

{!! Form::open(['route' => ['transportations.store'],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات خطة النقل</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="home" label="'اسم خطة النقل" name="transportation_type" placeholder="ادخل اسم خطة النقل" />
        </div>
        <div class="col-md">
            <x-inputs.number.Input label="الرسوم السنوية" icon="dollar-sign" name="annual_fees" placeholder="ادخل الرسوم السنوية" data-msg="االرسوم السنوية بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.number.Input label="رسوم الفصل الدراسي" icon="dollar-sign" name="semester_fees" placeholder="ادخل رسوم الفصل الدراسي" data-msg="ارسوم الفصل الدراسي بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.number.Input label="الرسوم الشهرية" icon="dollar-sign" name="monthly_fees" placeholder="ادخل الرسوم الشهرية" data-msg="االرسوم الشهرية بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <label class="form-label mb-1" for="active"> الحالة </label>
            <x-inputs.checkbox name="active">مفعل </x-inpurs.checkbox>
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة خطة النقل</x-inputs.submit>
        <x-inputs.link route="transportations.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection
