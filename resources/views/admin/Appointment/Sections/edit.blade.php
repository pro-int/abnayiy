@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('appointments.sections.index'), 'name' => "اقسام المقابلات"], ['link' => route('appointments.sections.edit',$section), 'name' => "نعديل معلومات القسم : $section->section_name"]],['title'=> 'تعديل معلومات القسم']];
@endphp

@section('title', 'تعديل معلومات القسم')

@section('content')

@component('components.forms.formCard',['title' =>  sprintf('تعديل معلومات القسم : %s (#%s)',$section->section_name,$section->id)])

{!! Form::model($section,['route' => ['appointments.sections.update',$section],'method'=>'PUT' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات القسم</x-ui-divider>

<div class="row mb-1">
    <div class="col-md">
        <x-inputs.text.Input icon="file-text" label="اسم القسم" name="section_name" placeholder="ادخل اسم القسم" data-msg="'اسم القسم بشكل صحيح" />
    </div>

    <div class="col-md">
        <x-inputs.text.Input type="number" label="أقصى موعد خلال" icon="clock" name="max_day_to_reservation" placeholder="ادخل اقصي عدد ايام يمكن حجز موعد خلالة" />
    </div>
</div>

<div class="col-12 text-center mt-2">
    <x-inputs.submit >تعديل القسم</x-inputs.submit>
    <x-inputs.link route="appointments.sections.index">عودة</x-inputs.link>
</div>
{!! Form::close() !!}

@endcomponent

@endsection
