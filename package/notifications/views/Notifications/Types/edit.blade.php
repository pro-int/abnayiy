@extends('layouts.contentLayoutMaster')
@php
$type = $notification_type->type == 'external' ? 'الخارجي' : 'الداخلي';

$breadcrumbs = [[['link' => route('notifications.index'), 'name' => "الأشعارات"], ['link' => route('notifications.types.edit',[$notification_type->notification_id, $notification_type->id]), 'name' => "sprintf('تعديل الاشعار : %s - رقم (%s)',$type, $notification_type->id)"]],['title'=> "تعديل"]];@endphp

@section('title', sprintf('تعديل الاشعار : %s - رقم (%s)',$type, $notification_type->id))

@section('content')


@component('components.forms.formCard',['title' => sprintf('تعديل الاشعار : %s - رقم (%s)',$type, $notification_type->id)])

{!! Form::model($notification_type, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['notifications.types.update', $notification_type->notification_id,$notification_type->id]]) !!}

<x-ui.divider>معلومات الأشعار</x-ui-divider>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input :disabled="true" icon="file-text" label="التكرار" name="frequent" placeholder=" التكرار" />
        </div>
    </div>

    <div class="row mb-1">
        @if($notification_type->type == 'external')
        <div class="col-md">
            <x-inputs.select.generic multiple label="قنوات الأرسال" name="channels[]" data-placeholder="اختر قنوات الأرسال" data-msg="رجاء اختيار قنوات الأرسال" :options="Gtech\AbnayiyNotification\Models\NotificationChannel::channels()" />
        </div>
        @endif

        <div class="col-md">
            <x-inputs.text.Input :disabled="true" icon="user-plus" label="الهدف" name="target_user" placeholder=" الهدف" />
        </div>
    </div>

    <div class="row mb-1">

        @if($notification_type->getRawOriginal('frequent') == 'single')
        <div class="col-md">
            <x-inputs.select.generic label="المحتوي" name="content_id" data-placeholder="اختر المحتوي" data-msg="رجاء اختيار المحتوي" :options="Gtech\AbnayiyNotification\Models\NotificationContent::contents(1,$notification_type->event_id)" />
        </div>
        @endif

        @if($notification_type->target_user == 'admin')
        <div class="col-md">
            <x-inputs.select.generic multiple label="المديرين" name="to_notify[]" data-placeholder="اختر المديرين" data-msg="رجاء اختيار المديرين" :options="$roles" />
        </div>
        @endif
    </div>

    <div class="row mb-1">
        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>تعديل</x-inputs.submit>
        <x-inputs.link route="notifications.types.index" :params="['notification' => $notification_type->notification_id,'selected_type' => $notification_type->type]">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection
    