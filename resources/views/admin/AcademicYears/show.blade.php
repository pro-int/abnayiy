@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('years.index'), 'name' => "السنوات الدراسية"],['name' => 'مشاهدة']],['title'=> 'مشاهدة السنة الدراسية']];
@endphp

@section('title', sprintf('مشاهدة معلومات العام الدراسي : %s | %s',$year->id , $year->year_name))

@section('content')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css'))}}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@component('components.forms.formCard',['title' => sprintf('مشاهدة السنة الدراسية رقم : %s - %s',$year->id , $year->year_name)])

{{ Form::model($year,['route' => ['years.update',$year->id],'method'=> 'PUT' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()']) }}

<x-ui.divider>معلومات السنة الدراسية</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="user" label="اسم العام الدراسي" name="year_name" placeholder="ادخل اسم العام الدراسي" data-msg="'اسم العام الدراسي بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input type="number" label="العام الدراسي الميلادي" icon="file-text" name="year_numeric" placeholder="ادخل العام الدراسي الميلادي" data-msg="االعام الدراسي الميلادي بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input type="number" icon="calendar" label="العام الدراسي الهجري" name="year_hijri" placeholder="ادخل االعام الدراسي الهجري" data-msg="'االعام الدراسي الهجري بشكل صحيح" />
        </div>
    </div>
    <div class="row mb-1">

        <div class="col-md">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ بداية الدراسة" icon="calendar" name="year_start_date" placeholder="ادخل تاريخ بداية الدراسة" data-msg="ادخل تاريخ بداية الدراسة بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ نهاية الدراسة" icon="calendar" name="year_end_date" placeholder="ادخل تاريخ نهاية الدراسة" data-msg="ادخل تاريخ نهاية الدراسة بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ ترحيل الطلاب الناجحين" icon="calendar" name="start_transition" placeholder="ادخل تاريخ ترحيل الطلاب الناجحين" data-msg="ادخل تاريخ ترحيل الطلاب الناجحين بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md-4">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="تاريخ نهاية العام المالي" icon="calendar" name="fiscal_year_end" placeholder="ادخل تاريخ نهاية العام المالي" data-msg="ادخل تاريخ نهاية العام المالي بشكل صحيح" />
        </div>

        <div class="col-md-4">
            <x-inputs.select.generic :required="false" label="العامل الدرسي السابق" name="previous_year_id" :options="['' => 'لا يوجد'] + App\Models\AcademicYear::years()" />
        </div>

        <div class="col-md input-group">
            <x-inputs.number.Input min="0" max="100" class="touchspin-icon" type="number" label="قيمة دفعة التعاقد %" icon="percent" name="min_tuition_percent" placeholder="اقل قيمة يجب علي ولي الأمر تسديدها لاتمام التعاقد" />
        </div>
        <div class="col-md input-group">
            <x-inputs.number.Input min="0" max="100" class="touchspin-icon" type="number" icon="percent" label="الحد الأدني من الديون ان وجدت %" name="min_debt_percent" placeholder="الحد الأدني المطلوب من الديون السابقة لأتمام التعاقد" />
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <label class="form-label">هل متاح للتقديم ؟ </label>

            <x-inputs.checkbox name="is_open_for_admission">
                متاخ للتقديم
            </x-inputs.checkbox>
        </div>
        <div class="col-md">
            <label class="form-label">العام الدراسي الحالي </label>

            <x-inputs.checkbox name="current_academic_year">
                العام الدراسي الحالي
            </x-inputs.checkbox>
        </div>
    </div>
    <x-ui.divider color="danger">اعدادات خطة السداد (تقسيط)</x-ui.divider>
    <div class="row">
        <div class="col-md">
            <x-inputs.text.Input class="form-control flatpickr-basic" label="اخر موعد للأستفادة من خطة التقسيط" icon="calendar" name="installments_available_until" placeholder="ادخل اخر موعد للأستفادة من خطة التقسيط" data-msg="ادخل اخر موعد للأستفادة من خطة التقسيط بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input lang="ar" :value="$year->last_installment_date->format('Y-m')" type="month" label="اقصي موهد للقسط يوم (27) من شهر" name="last_installment_date" placeholder="ادخل اخر قسط في شهر" data-msg="ادخل اخر قسط في شهر بشكل صحيح" />
        </div>

    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.link route="years.index">عودة</x-inputs.link>
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
    <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js'))}}"></script>
    @endsection

    @section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-number-input.js'))}}"></script>

    @endsection