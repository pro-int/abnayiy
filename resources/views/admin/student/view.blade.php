@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => "الطلاب"],['name'=> $student->student_name]],['title' => 'مشاهدة ']];
@endphp

@section('title', sprintf('مشاهدة معلومات الطالب : %s | %s',$student->id , $student->student_name))

@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/katex.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/monokai-sublime.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/quill.snow.css'))}}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<!-- Page css files -->
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

@component('components.forms.formCard',['title' => sprintf('مشاهدة الطالب رقم : %s - %s',$student->id , $student->student_name)])

{{ Form::model($student,['route' => ['students.update',$student->id],'method'=> 'GET' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()']) }}

<x-ui.divider color="warning">معلومات ولي الأمر </x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input readonly icon="user" label="اسم ولي الأمر" name="guardian_name" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input readonly icon="info" label="هوية ولي الأمر" name="guardian_national_id" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input readonly icon="phone" label="رقم الجوال" name="phone" />
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input readonly icon="mail" label="البريد الأليكتروني" name="email" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input readonly icon="flag" label="جنسية ولي الامر" name="nationality_name" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input readonly icon="bookmark" label="الفئة" name="category_name" />
        </div>
    </div>
    
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input readonly icon="map" label="العنوان" name="address" />
        </div>
    
        <div class="col-md">
            <x-inputs.text.Input readonly icon="map-pin" label="المدينة" name="city_name" />
        </div>
    </div>

    <x-ui.divider>معلومات الطالب</x-ui-divider>

        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.text.Input icon="user" label="'اسم الطالب" name="student_name" placeholder="ادخل اسم الطالب" data-msg="'اسم الطالب بشكل صحيح" />
            </div>

            <div class="col-md">
                <x-inputs.text.Input label="رقم الهوية" icon="file-text" name="national_id" placeholder="ادخل رقم الهوية" data-msg="ارقم الهوية بشكل صحيح" />
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.text.Input icon="map-pin" label="مكان الولادة" name="birth_place" placeholder="ادخل مكان الولادة" data-msg="رجاء ادخال مكان الولادة بشكل صحيح" />
            </div>

            <div class="col-md">
                <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ الميلاد" icon="calendar" name="birth_date" placeholder="ادخل تاريخ الميلاد بالصيغة الدولية" data-msg="ادخل تاريخ الميلاد بشكل صحيح" />
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.select.generic label="جنسية الطالب" name="nationality_id" data-placeholder="اختر جنسية الطالب" data-msg="رجاء اختيار جنسية الطالب" :options="App\Models\nationality::nationalities()" />
            </div>

            <div class="col-md">
                <label class="form-label">هل الطالب يحتاج الي رعاية خاصة</label>

                <x-inputs.checkbox name="student_care">
                    الطالب يحتاج الي رعاية
                </x-inputs.checkbox>
            </div>
            <div class="col-md">
                <label class="form-label"> السداد المتأخر</label>

                <x-inputs.checkbox name="allow_late_payment">
                    السماح بالسداد بعد انتهاء العام المالي
                </x-inputs.checkbox>
            </div>
        </div>


        <div class="col-12 text-center mt-2">
            <x-inputs.link route="students.index">عودة</x-inputs.link>
        </div>
        {!! Form::close() !!}

        @endcomponent

        @endsection

        @section('vendor-script')
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        @endsection

        @section('page-script')
        <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

        @endsection