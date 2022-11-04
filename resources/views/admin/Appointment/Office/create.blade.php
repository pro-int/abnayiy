@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('appointments.sections.index'), 'name' => "اقسام المقابلات"],['link' => route('appointments.offices.index'), 'name' => "مكاتب المقابلات"],['link' => route('appointments.offices.create'), 'name' => "اضافة مكتب"]],['title'=> 'اضافة مكتب جديد']];
@endphp

@section('title', 'اضافة مكتب جديد')

@section('content')

@component('components.forms.formCard',['title' => 'اضافة مكتب جديد'])

{!! Form::open(['route' => ['appointments.offices.store'],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات المكتب</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="file-text" label="اسم المكتب" name="office_name" placeholder="ادخل اسم المكتب" data-msg="'اسم المكتب بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="user" label="اسم الموظف" name="employee_name" placeholder="ادخل اسم الموظف" data-msg="'اسم الموظف بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input icon="phone" label="رقم الجوال" name="phone" placeholder="ادخل رقم الجوال" data-msg="'رقم الجوال بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <x-inputs.select.generic label="الاقسام" name="sections[]" :options="App\Models\AppointmentSection::sections()" multiple />
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة مكتب جديد</x-inputs.submit>
        <x-inputs.link route="appointments.offices.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection