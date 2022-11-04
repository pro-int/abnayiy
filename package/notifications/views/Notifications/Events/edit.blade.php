@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('sections.index'), 'name' => "مناسبات الأشعار"], ['link' => route('sections.edit', $section), 'name' => "$section->section_name"],['link' => route('sections.events.edit',[$section,$event]), 'name' => "$event->event_name"]],['title'=> 'تعديل مناسبة الأشعار :' . $event->event_name]];
@endphp

@section('title', ' تعديل المناسبة : '. $event->event_name )

@section('content')


@component('components.forms.formCard',['title' => 'تعديل المناسبة : ' .$event->event_name])

{!! Form::model($event, ['method' => 'PUT','route' => ['sections.events.update', [$section,$event] ]]) !!}

<x-ui.divider>معلومات المناسبة</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="file-text" label="اسم المناسبة" name="event_name" placeholder="ادخل اسم القسم" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <label class="form-label mr-1" for="single_allowed"> الاشعار اللحظي </label>
            <x-inputs.checkbox name="single_allowed">مفعل</x-inpurs.checkbox>
        </div>

        <div class="col-md">
            <label class="form-label mr-1" for="frequent_allowed"> متكرر ؟ </label>
            <x-inputs.checkbox name="frequent_allowed">تمكين التكرار في هذة المناسبة'</x-inpurs.checkbox>
        </div>
    </div>

    @if($event->content_vars)
    <x-ui.divider>المحتوي المتغيير</x-ui-divider>
        <div class="row mb-1">
            @foreach($event->content_vars as $k => $v)
            <div class="col-md mb-1">
                <x-inputs.text.Input icon="file" :label="sprintf('المحتوي المتغيير (%s)',$v)" name="content_vars[{{$k}}]" placeholder="ادخل اسم قناة الأرسال" :value="$v" />
            </div>
            @endforeach
        </div>
        @endif
        <div class="col-12 text-center mt-2">
            <x-inputs.submit>تعديل </x-inputs.submit>
            <x-inputs.link route="sections.events.index" :params="$section">عودة</x-inputs.link>
        </div>
        {!! Form::close() !!}

        @endcomponent

        @endsection