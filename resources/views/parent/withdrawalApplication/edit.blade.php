@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('parent.withdrawals.index'), 'name' => "الطلبات"],['name'=> 'طلبات الأنسحاب']],['title' => 'تعديل طلب الأنسحاب']];
@endphp

@section('title', sprintf('تعديل الطلب رقم : %s | %s',$withdrawalApplication->id , $withdrawalApplication->student_name))

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
@endsection

@section('content')

@component('components.forms.formCard',['title' => sprintf('تعديل طلب الأنسحاب رقم : %s - %s',$withdrawalApplication->id , $withdrawalApplication->student_name)])

{{ Form::model($withdrawalApplication ,['route' => ['parent.withdrawals.update',$withdrawalApplication->id],'method'=> 'PUT' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()']) }}

<div class="row mb-1">
    <div class="col-md">
        <x-inputs.select.generic label="سبب الانسحاب" name="reason" data-placeholder="ابحث عن سبب الانسحاب" data-msg="رجاءاختيار سبب الانسحاب"  :options="['r1' => 'السبب الاول', 'r2' => 'السبب الثاني']"/>
    </div>
    <div class="col-md">
        <x-inputs.text.Input type="textarea" label="اكتب تعليق مختصر عن سبب انسحابك" name="comment" data-placeholder="اكتب تعليقك" data-msg="رجاء اكتب تعليقك"/>
    </div>

</div>


<div class="col-12 text-center mt-2">
    <x-inputs.submit>تعديل طلب الأنسحاب</x-inputs.submit>
    <x-inputs.link route="parent.withdrawals.index">عودة</x-inputs.link>
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
