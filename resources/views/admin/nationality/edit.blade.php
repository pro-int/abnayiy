@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('nationalities.index'), 'name' => "الجنسيات"], ['link' => route('nationalities.edit',$nationality), 'name' => "تعديل معلومات الجنسية"]],['title'=> 'تعديل']];
@endphp

@section('title', 'ادارة الجنسيات')

@section('content')

@component('components.forms.formCard',['title' => sprintf('تعديل معلومات الجنسية : <span class="text-danger"> %s </span>', $nationality->nationality_name)])

{!! Form::model($nationality, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['nationalities.update', $nationality->id]]) !!}

<x-ui.divider>معلومات الجنسية</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="home" label="'اسم الجنسية" name="nationality_name" placeholder="ادخل اسم الجنسية" />
        </div>

        <div class="col-md">
            <x-inputs.number.Input label="قيمة الضرائب" icon="dollar-sign" name="vat_rate" placeholder="ادخل قيمة الضرائب" data-msg="اقيمة الضرائب بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">

        <div class="col-md">
            <label class="form-label mb-1" for="active"> الحالة </label>
            <x-inputs.checkbox name="active">مفعل </x-inpurs.checkbox>
        </div>
    </div>


    <div class="col-12 text-center mt-2">
        <x-inputs.submit>تعديل معلومات الجنسية</x-inputs.submit>
        <x-inputs.link route="nationalities.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection