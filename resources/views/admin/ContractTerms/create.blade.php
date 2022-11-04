@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('contract_terms.index'), 'name' => 'شروط التعاقد'],['link' => route('contract_terms.create'), 'name' => "اضافة شروط "]],['title'=> 'اضافة شروط']];
@endphp

@section('title', 'اضافة الشروط ')

@section('content')

@component('components.forms.formCard',['title' => 'اضافة شروط تعاقد'])

{!! Form::open(['route' => 'contract_terms.store','method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات الشروط</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input type="textarea" id="editor" label="نص الشروط والاحكام" name="content" placeholder="ادخل نص الشروط والاحكام" data-msg="نص الشروط والاحكام بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="align-justify" label="رقم النسخه" name="version" placeholder="ادخل رقم النسخه" data-msg="رقم النسخه بشكل صحيح" />
        </div>



        <div class="col-md">
            <label class="form-label mb-1"> الشروط الافتراضي ؟ </label>
            <x-inputs.checkbox name="is_default">
                إفتراضي
            </x-inputs.checkbox>
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit> اضافة </x-inputs.submit>

        <x-inputs.link route="contract_terms.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection

