@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('home'), 'name' => "الرئيسية"],['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year), 'name' => "$year->year_name"], ['link' => route('years.classrooms.index',$year), 'name' => 'الفصول الدراسية'],['name' => 'اضافة']],['title'=> 'تسجيل فصل دراسي ']];
@endphp

@section('title', "اضافة فصل دراسي للعام $year->year_name")

@section('content')


@component('components.forms.formCard',['title' => "اضافة فصل دراسي للعام $year->year_name"])

{!! Form::open(['route' => ['years.classrooms.store',$year],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

<x-ui.divider>معلومات الفصل</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="align-justify" label="'اسم الفصل" name="class_name" placeholder="ادخل اسم الفصل" data-msg="'اسم الفصل بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input icon="align-justify" label="'اسم الفصل في نور" name="class_name_noor" placeholder="ادخل اسم الفصل في نور" data-msg="'اسم الفصل في نور بشكل صحيح" />
        </div>
    </div>

    <x-ui.divider>معلومات المرحلة الخاصة بالفصل</x-ui-divider>

        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.select.generic select2="" label="المدرسة" :onLoad="!old('school_id') ? 'change' : null" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="schools()" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic select2="" label="النوع" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار النوع" :options="old('school_id') ? App\Models\Gender::genders(true,old('school_id')) : []" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic select2="" label="المرحلة" name="grade_id" data-placeholder="اختر المرحلة" data-msg="رجاء اختيار المرحلة" :options="old('gender_id') ?App\Models\Grade::grades(true,old('gender_id')) : []" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="old('grade_id') ? App\Models\Level::levels(true,old('grade_id')) : []" />
            </div>
        </div>

        <div class="col-12 text-center mt-2">
            <x-inputs.submit>اضافة فصل جديد </x-inputs.submit>

            <x-inputs.link route="years.classrooms.index" :params="[$year]">عودة</x-inputs.link>
        </div>
        {!! Form::close() !!}

        @endcomponent

        @endsection