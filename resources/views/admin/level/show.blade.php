@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('levels.index'), 'name' => "الصفوف الدراسية "],['link' => route('levels.edit',$level), 'name' => "مشاهدة الصف : $level->level_name" ]],['title'=> 'الصف المسجلة']];
@endphp

@section('title', 'مشاهدة الصف الدراسي ')

@section('content')
@component('components.forms.formCard',['title' =>' مشاهدة الصف الدرسي : ' . $level->level_name ])

{!! Form::model($level, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['levels.update', $level->id]]) !!}

<x-ui.divider>معلومات الصف الدراسي</x-ui-divider>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="اسم الصف الدراسي" icon="file-text" name="level_name" placeholder="ادخل اسم الصف الدراسي" data-msg="ااسم الصف الدراسي بشكل صحيح" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input label="اسم الصف الدراسي في نظام نور" icon="file-text" name="level_name_noor" placeholder="ادخل اسم الصف الدراسي في نظام نور" data-msg="ااسم الصف الدراسي في نظام نور بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="اسم الصف الدراسي" icon="file-text" name="level_name" placeholder="ادخل اسم الصف الدراسي" data-msg="ااسم الصف الدراسي بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1 ">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="المدرسة" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="النوع" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار النوع" :options="old('school_id') ? App\Models\Gender::genders(true,old('school_id')) : App\Models\Gender::genders(true,$level->school_id)" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="المرحلة" name="grade_id" data-placeholder="اختر المرحلة" data-msg="رجاء اختيار المرحلة" :options="old('gender_id') ?App\Models\Grade::grades(true,old('gender_id')) : App\Models\Grade::grades(true,$level->gender_id)" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input type="number" label="الحد الادني لعدد الطلاب " icon="user-plus" name="min_students" placeholder="الحد الادني لعددالطلاب في قائمة الانتظار لتسجيل فصل جديد" data-msg="ادخل الحد الأدني لعدد الطاب" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input type="number" label="الرسوم المدرسية (ر.س)" icon="dollar-sign" name="tuition_fees" placeholder="ادخل الرسوم المدرسية (ر.س)" data-msg="االرسوم المدرسية (ر.س) بشكل صحيح" />
        </div>
    </div>
    <div class="row mb-1">

        <div class="col-md">
            <label class="form-label mb-1" for="active"> الحالة </label>
            <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>
        </div>
    </div>

    <x-ui.divider>حدود الخصومات</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input min="0" type="number" label="اقصي نسبة للخصومات الفترات" icon="percent" name="coupon_discount_persent" placeholder="اقصي نسبة لخصومات الفترات من الرسوم الدراسية" />
        </div>


        <div class="col-md">
            <x-inputs.text.Input type="number" label="اقصي نسبة خصومات من الرسوم الدراسية للقسائم" icon="percent" name="period_discount_persent" placeholder="ادخل اقصي نسبة خصومات من الرسوم الدراسية للقسائم" />
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.link route="levels.index">عودة</x-inputs.link>
    </div>

{!! Form::close() !!}

@endcomponent

@endsection