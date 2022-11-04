@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('levels.index'), 'name' => "الصفوف الدراسية "],['link' => route('levels.subjects.edit',[$level,$subject]), 'name' => "المواد الدراسية : $level->level_name" ]],['title'=> "تعديل مادة دراسبة"]];
@endphp

@section('title', 'تعديل صف الدراسي ')

@section('content')
@component('components.forms.formCard',['title' => "تعديل مادة دراسية للصف الدراسي : $level->level_name" ])

{!! Form::model($subject, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['levels.subjects.update',[$level,$subject]]]) !!}

<x-ui.divider>معلومات المادة الدراسية</x-ui-divider>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="اسم المادة الدراسية" icon="file-text" name="subject_name" placeholder="ادخل اسم المادة الدراسية" data-msg="ااسم المادة الدراسية بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input type="number" label="درجة النجاح" icon="minimize-2" name="min_grade" placeholder="اقل درجة يجب ان يحصل عليها الطالب للنجاح" data-msg="ادخل درجة النجاح يشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input type="number" label="الدرجة النهائية" icon="maximize-2" name="max_grade" placeholder="ادخل الدرجة النهائية" data-msg="ادخل الدرجة النهائية بشكل صحيح" />
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.link route="levels.subjects.index" :params="['level' => $level->id]">عودة</x-inputs.link>
    </div>

    {!! Form::close() !!}

    @endcomponent

    @endsection