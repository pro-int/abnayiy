@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('appointments.sections.index'), 'name' => "اقسام المقابلات"],['link' => route('appointments.offices.index'), 'name' => "مكاتب المقابلات"],['link' => route('appointments.offices.edit',$office), 'name' => "تعديل : $office->office_name"]],['title'=> 'تعديل معلومات المكتب']];
@endphp

@section('title', sprintf('تعديل معلومات المكتب : %s (#%s)', $office->office_name,$office->id))

@section('content')

@component('components.forms.formCard',['title' => sprintf('تعديل معلومات المكتب : %s (#%s)',$office->office_name,$office->id)])

{!! Form::model($office,['route' => ['appointments.offices.update',$office],'method'=>'PUT' , 'onsubmit' => 'showLoader()'])  !!}

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
        <x-inputs.submit>تعديل معلومات المكتب</x-inputs.submit>
        <x-inputs.link route="appointments.offices.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection