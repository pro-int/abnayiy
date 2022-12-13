@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('appointments.sections.index'), 'name' => "اقسام المقابلات"]],['title'=> 'اضافة قسم مقابلات جديد']];
@endphp

@section('title', 'اضافة قسم مقابلات جديد')

@section('content')

@component('components.forms.formCard',['title' => 'اضافة قسم مقابلات جديد'])

{!! Form::open(['route' => ['appointments.sections.store'],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات قسم المقابلات</x-ui-divider>

<div class="row mb-1">
    <div class="col-md">
        <x-inputs.text.Input icon="file-text" label="اسم قسم المقابلات" name="section_name" placeholder="ادخل اسم قسم المقابلات" data-msg="'اسم قسم المقابلات بشكل صحيح" />
    </div>

    <div class="col-md">
        <x-inputs.text.Input type="number" label="أقصى موعد خلال" icon="clock" name="max_day_to_reservation" placeholder="ادخل اقصي عدد ايام يمكن حجز موعد خلالة" />
    </div>
</div>

<div class="col-12 text-center mt-2">
    <x-inputs.submit >اضافة قسم المقابلات</x-inputs.submit>
    <x-inputs.link route="appointments.sections.index">عودة</x-inputs.link>
</div>
{!! Form::close() !!}

@endcomponent

@endsection
