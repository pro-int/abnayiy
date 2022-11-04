@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('levels.index'), 'name' => "الصفوف الدراسية "],['link' => route('levels.edit',$level), 'name' => "تعديل الدراسي التالي : $level->level_name" ]],['title'=> 'تعديل الصف الدراسي التالي']];
@endphp

@section('title', 'تعديل الصف الدراسي التالي ')

@section('content')
@component('components.forms.formCard',['title' =>' تحديد الصف الدراسي التالي : ' . $level->level_name ])

{!! Form::model($level, ['method' => 'POST','route' => ['levels.nextLevel', $level->id]]) !!}

<x-ui.divider>الصف الدراس التالي في حالة النجاح</x-ui-divider>
    <div class="row mb-1" id="selection">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="المدرسة" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="النوع" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار النوع" :options="$level->school_id  ? App\Models\Gender::genders(true,$level->school_id ) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="المرحلة" name="grade_id" data-placeholder="اختر المرحلة" data-msg="رجاء اختيار المرحلة" :options="$level->gender_id ? App\Models\Grade::grades(true,$level->gender_id) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="$level->grade_id ? App\Models\Level::levels(true,$level->grade_id) : []" />
        </div>
    </div>

    <div class="row mb-1">
        <label class="form-label mr-1" for="is_graduated">متخرج ؟</label>
        <x-inputs.checkbox :checked="$level->is_graduated" onchange="togglegraduatedStutus(this)" name="is_graduated">تحديد الطالب الناجح في هذا الصف كطالب متخرج </x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>تعديل </x-inputs.submit>
        <x-inputs.link route="levels.index">عودة</x-inputs.link>
    </div>

    {!! Form::close() !!}

    @endcomponent

    @endsection

    @section('page-script')
    <script>
        function togglegraduatedStutus(e) {
            let div = document.getElementById('selection');
            div.style = e.checked ? 'pointer-events: none;opacity: 0.4;' : '';
        }

        togglegraduatedStutus(document.getElementById('is_graduated'));
    </script>
    @endsection