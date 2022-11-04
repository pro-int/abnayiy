@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('channels.index'), 'name' => "قنوات الأرسال"],['link' => route('channels.index'), 'name' => "قنوات الأرسال"]],['title'=> ' ادارة قنوات الأرسال']];
@endphp

@section('title', 'تعديل بنك جديد')

@section('content')

@component('components.forms.formCard',['title' => sprintf('تعديل معلومات قناة الأرسال %s', $channel->channel_name)])

{!! Form::model($channel,['route' => ['channels.update',$channel],'method'=>'PUT' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات قناة الأرسال</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="text-file" label="'اسم قناة الأرسال" name="channel_name" placeholder="ادخل اسم قناة الأرسال" />
        </div>

        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

    </div>
    @if($channel->config)
    <x-ui.divider>اعدادات قناة الأرسال</x-ui-divider>
        <div class="row mb-1">

            @foreach($channel->config as $k => $v)
            <div class="col-md-6 mb-1">
                <x-inputs.text.Input icon="file" label="'اسم قناة الأرسال" name="config[$k]" placeholder="ادخل اسم قناة الأرسال" :value="$v" />
            </div>
            @endforeach
        </div>
        @endif
        <div class="col-12 text-center mt-2">
            <x-inputs.submit>تعديل قناة الأرسال</x-inputs.submit>
            <x-inputs.link route="channels.index">عودة</x-inputs.link>
        </div>
        {!! Form::close() !!}

        @endcomponent

        @endsection