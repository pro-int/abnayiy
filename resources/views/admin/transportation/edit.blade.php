@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('transportations.index'), 'name' => "خطط النقل"], ['link' => route('transportations.edit',$transportation), 'name' => "تعديل خطة النقل"]],['title'=> 'تعديل']];
@endphp

@section('title', 'ادارة خطط النقل')

@section('content')

@component('components.forms.formCard',['title' => sprintf('تعديل معلومات خطة النفل : <span class="text-danger"> #%s - %s</span>', $transportation->id ,$transportation->transportation_type)])

{!! Form::model($transportation, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['transportations.update', $transportation->id]]) !!}

<x-ui.divider>معلومات خطة النقل</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="home" label="'اسم خطة النقل" name="transportation_type" placeholder="ادخل اسم خطة النقل" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input type="text" label="Odoo Product ID" icon="anchor" name="odoo_product_id" placeholder="ادخل Odoo Product ID" data-msg="ادخل Odoo Product ID بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.number.Input label="الرسوم السنوية" icon="dollar-sign" name="annual_fees" placeholder="ادخل الرسوم السنوية" data-msg="االرسوم السنوية بشكل صحيح" />
        </div>

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
        <x-inputs.submit>تعديل خطة النقل</x-inputs.submit>
        <x-inputs.link route="transportations.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection
