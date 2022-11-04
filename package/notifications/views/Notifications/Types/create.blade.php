@extends('layouts.contentLayoutMaster')
@php
$type = request('selected_type') && request('selected_type') == 'external' ? 'الخارجي' : 'الداخلي';

$breadcrumbs = [[['link' => route('notifications.index'), 'name' => "الأشعارات"], ['link' => route('notifications.types.create',[$notification->id]), 'name' => sprintf('اضافة اشعار : %s ',$type)]],['title'=> "اضافة اشعار $type"]];@endphp

@section('title',"اضافة $type اشعار جديد")

@section('content')


@component('components.forms.formCard',['title' => "اضافة اشعار $type جديد"])

{!! Form::open(['route' => ['notifications.types.store',$notification->id],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}
<input type="hidden" value="{{ request('selected_type') ?? 'external' }}" name="type">

<x-ui.divider>معلومات الأشعار</x-ui-divider>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="التكرار" name="frequent" data-placeholder="اختر التكرار" data-msg="رجاء اختيار التكرار" :options="Gtech\AbnayiyNotification\Models\NotificationType::GetAllowedTypes($notification->event_id)" />
        </div>

        @if(request('selected_type') == 'external')
        <div class="col-md">
            <x-inputs.select.generic multiple label="قنوات الأرسال" name="channels[]" data-placeholder="اختر قنوات الأرسال" data-msg="رجاء اختيار قنوات الأرسال" :options="Gtech\AbnayiyNotification\Models\NotificationChannel::channels()" />
        </div>
        @endif
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="الهدف" name="target_user" data-placeholder="اختر الهدف" data-msg="رجاء اختيار الهدف" :options="['user' => 'المستخدم', 'admin' => 'الأدارة']" />
        </div>
    </div>

    <div class="row mb-1">

        <div class="col-md">
            <x-inputs.select.generic label="المحتوي" name="content_id" data-placeholder="اختر المحتوي" data-msg="رجاء اختيار المحتوي" :options="Gtech\AbnayiyNotification\Models\NotificationContent::contents(1,$notification->event_id)" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic multiple label="المديرين" name="to_notify[]" data-placeholder="اختر المديرين" data-msg="رجاء اختيار المديرين" :options="$roles" id="to_notify" />
        </div>
    </div>

    <div class="row mb-1">
        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة</x-inputs.submit>
        <x-inputs.link route="notifications.types.index" :params="['notification' => $notification->id,'selected_type' => request('selected_type')]">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection