@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('notifications.index'), 'name' => "الأشعارات"]],['title'=> "اضافة"]];
@endphp

@section('title', 'اضافة اشعار جديد')

@section('content')


@component('components.forms.formCard',['title' => 'اضافة اشعار جديد'])

{!! Form::open(['route' => 'notifications.store','method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات الأشعار</x-ui-divider>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="file-text" label="وصف الاشعار" name="notification_name" placeholder="ادخل وصف الاشعار" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="القسم" name="section_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="['' => 'اختر'] + Gtech\AbnayiyNotification\Models\NotificationSection::sections()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="المناسبة" name="event_id" data-placeholder="اختر المناسبة" data-msg="رجاء اختيار المناسبة" :options="[]" />
        </div>
    </div>

    <div class="row mb-1">
        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة اشعار جديد</x-inputs.submit>
        <x-inputs.link route="notifications.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection
    
    