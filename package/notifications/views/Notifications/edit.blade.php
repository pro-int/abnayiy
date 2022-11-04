@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('notifications.index'), 'name' => "الأشعارات"], ['link' => route('notifications.edit',$notification), 'name' => "تعديل : $notification->notification_name"]],['title'=> "تعديل : $notification->notification_name"]];@endphp

@section('title', sprintf('تعديل الاشعار : %s - %s',$notification->notification_name, $notification->frequent))

@section('content')


@component('components.forms.formCard',['title' => sprintf('تعديل الاشعار : %s - %s',$notification->notification_name, $notification->frequent)])

{!! Form::model($notification, ['method' => 'PUT','route' => ['notifications.update', $notification->id]]) !!}

<x-ui.divider>معلومات الأشعار</x-ui-divider>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="file-text" label="وصف الاشعار" name="notification_name" placeholder="ادخل وصف الاشعار" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="القسم" name="section_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="Gtech\AbnayiyNotification\Models\NotificationSection::sections()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="المناسبة" name="event_id" data-placeholder="اختر المناسبة" data-msg="رجاء اختيار المناسبة" :options="Gtech\AbnayiyNotification\Models\NotificationEvent::events(1,$notification->section_id)" />
        </div>
    </div>

    <div class="row mb-1">
        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>تعديل الأشعار</x-inputs.submit>
        <x-inputs.link route="notifications.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection