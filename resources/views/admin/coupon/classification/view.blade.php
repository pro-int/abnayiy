@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('coupons.index'), 'name' => 'قسائم الخصم'], ['link' => route('classifications.index'), 'name' => 'تصنيفات القسائم'],['link' => route('classifications.edit',$classification), 'name' => "مشاهدة معلومات التصنيف" ]],['title'=> 'مشاهدة معلومات التصنيف']];
@endphp

@section('title', 'مشاهدة معلومات التصنيف')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')
@component('components.forms.formCard',['title' => sprintf('مشاهدة معلومات التصنيف : <span class="text-danger">%s</span>', $classification->classification_name)])

{!! Form::model($classification, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['classifications.update', $classification->id]]) !!}

<x-ui.divider>معلومات التصنيف</x-ui-divider>

    <div class="row mb-1 ">
        <div class="col-md">
            <x-inputs.text.Input label="اسم التضنيف" icon="file-text" name="classification_name" placeholder="ادخل اسم التضنيف" data-msg="رجاء ادخال اسم التصنيف بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input :readonly="true" label="بادئة التضنيف" icon="tag" name="classification_prefix" placeholder="ادخل بادئة التضنيف" data-msg="رجاء ادخال بادئة التصنيف بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.select.color label="اللون المميز" name="color_class" :selected="$classification->color_class" placeholder="اختر اللون المميز للتصنيف" data-msg="رجاء اختر اللون المميز " />
        </div>
    </div>


    <x-ui.divider>اعدادات التصنيف</x-ui-divider>

        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.select.generic :disabled="true" label="السنة الدراسية" name="academic_year_id" data-placeholder="اختر السنة الدراسية" :options="App\Models\AcademicYear::years()" />
            </div>

            <div class="col-md">
                <x-inputs.text.Input min="0" type="number" label="مبلغ الحد الأقصي لأستخراج القسائم بهذا التصنيف" icon="dollar-sign" name="limit" placeholder="ادخل مبلغ الحد الأقصي لأستخراج القسائم بهذا التصنيف" data-msg="رجاء ادخال بادئة التصنيف بشكل صحيح" />
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.select.generic class="select2" label="انواع الدفعات التي يمكن تطبيق الخصم بها" name="allowed_types[]" data-placeholder="اختر انواع الدفعات التي يمكن تطبيق الخصم بها" :options="['tuition' => 'الرسوم الدراسية','bus' => 'رسوم النقل', 'debt' => 'المديونيات']" multiple/>
            </div>
            <div class="col-md">
                <label class="form-label mb-1" for="active"> الحالة </label>
                <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>
            </div>
        </div>

        <div class="col-12 text-center mt-2">
            <x-inputs.link route="classifications.index">عودة</x-inputs.link>
        </div>

        {!! Form::close() !!}

        @endcomponent

        @endsection

        @section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        @endsection
        @section('page-script')
        <script type="text/javascript">
        </script>
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
        @endsection
