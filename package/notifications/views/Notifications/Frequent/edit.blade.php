@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('home'), 'name' => "الرئيسية"],['link' => route('notifications.index'), 'name' => "الاشعارات"], ['link' => route('notifications.types.index',[$notification, 'selected_type' => $notification->type]), 'name' => "$notification->notification_name"], ['link' => route('notifications.types.frequent.index',[$notification,request('type')]), 'name' => "تعديل التكرار"], ['link' => route('notifications.types.frequent.edit',[$notification,request('type'),request('frequent')]), 'name' => "تعديل "]],['title'=> ' تعديل التكرار']];
@endphp


@section('title', sprintf('تعديل تعليمات التكرار للأشعار رقم #(%s) - %s - %s', $notification->id,$notification->section_name,$notification->event_name))

@section('content')


@component('components.forms.formCard',['title' => sprintf('تعديل تعليمات التكرار للأشعار رقم #(%s) - %s - %s', $notification->id,$notification->section_name,$notification->event_name)])

{!! Form::model($frequent, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['notifications.types.frequent.update',$notification->id,request()->type,$frequent->id]]) !!}

<x-ui.divider>معلومات الأشعار</x-ui-divider>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="شرط الأرسال" name="condition_type" data-placeholder="اختر شرط الأرسال" data-msg="رجاء اختيار شرط الأرسال" :options="['before' => 'قبل', 'after' => 'بعد']" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic label="المحتوي" name="content_id" data-placeholder="اختر المحتوي" data-msg="رجاء اختيار المحتوي" :options="Gtech\AbnayiyNotification\Models\NotificationContent::contents(1,$notification->event_id)" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input type="number" icon="clock" label="تكرار بعد او قبل (ساعة)" name="interval" placeholder="تكرار بعد او قبل (ساعة)" />
        </div>

        <div class="col-md">
            <label class="form-label mr-1" for="active"> الحالة </label>
            <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>تعديل</x-inputs.submit>
        <x-inputs.link route="notifications.types.frequent.index" :params="['notification' => request('notification'),'type' => request('type')]">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection