@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('home'), 'name' => "الرئيسية"],['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year), 'name' => "$classroom->year_name"], ['link' => route('years.classrooms.index',$year), 'name' => 'الفصول الدراسية'],['name' => 'تعديل']],['title'=> 'تعديل فصل دراسي ']];
@endphp


@section('title', 'تعديل معلومات الفصل ')

@section('content')


@component('components.forms.formCard',['title' => 'تعديل معلومات الفصل '])

{!! Form::model($classroom, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['years.classrooms.update', [$year,$classroom->id] ]]) !!}

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
                <x-inputs.select.generic select2="" label="المدرسة" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="schools()" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic select2="" label="القسم" name="gender_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="$roles" :options="App\Models\Gender::genders(true,$classroom->school_id)" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic select2="" label="المسار" name="grade_id" data-placeholder="اختر المسار" data-msg="رجاء اختيار المسار" :options="$roles" :options="App\Models\Grade::grades(true,$classroom->gender_id)" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="$roles" :options="App\Models\Level::levels(true,$classroom->grade_id)" />
            </div>
        </div>

        <div class="col-12 text-center mt-2">
            <x-inputs.submit>تعديل معلومات الفصل </x-inputs.submit>

            <x-inputs.link route="years.classrooms.index" :params="[$year]">عودة</x-inputs.link>
        </div>
        {!! Form::close() !!}

        @endcomponent

        @endsection
