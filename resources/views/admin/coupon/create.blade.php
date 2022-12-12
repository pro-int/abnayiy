@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('coupons.index'), 'name' => "قسائم الخصم"],['link' => route('coupons.create'), 'name' => "اضافة قسيمة" ]],['title'=> 'اضافة قسيمة']];
@endphp

@section('title', 'اضافة قسيمة خصم ')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection


@section('content')
@component('components.forms.formCard',['title' =>' اضافة قسيمة خصم' ])

{!! Form::open(['route' => 'coupons.store','method'=>'POST' , 'onsubmit' => 'showLoader()']) !!}

<x-ui.divider>معلومات الصف</x-ui-divider>

    <div class="row mb-1 ">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="العام الدراسي" name="academic_year_id" data-placeholder="اختر العام الدراسي" data-msg="رجاء اختيار العام الدراسي" :options="['' => 'اختر العام الدراسي'] + App\Models\AcademicYear::years()" onchange="get_CouponClassification()" />
        </div>

        <div class="col-md">
            <span id="special_span" style="display:none;" data-bs-toggle="tooltip" class="text-danger" data-bs-placement="top" title="لن يتم خصم قيمة القسيمة من الحد الأقصي للخصومات طبقا لأعدادات النظام">
                <em data-feather="info"></em></span>
            <x-inputs.select.generic :required="false" select2="" label="نوع القسيمة" name="classification_id" data-placeholder="اختر نوع القسيمة" data-msg="رجاء اختيار نوع القسيمة" :options="old('classification_id') ? ['' => 'قسائم عامة'] + getCouponClassification(old('academic_year_id')) : []" onchange="get_discount_values()" />
        </div>
    </div>

    <div class="row mb-1" id="selection">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="المدرسة" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] + schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="القسم" name="gender_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="old('school_id')  ? App\Models\Gender::genders(true,old('school_id') ) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="المسار" name="grade_id" data-placeholder="اختر المسار" data-msg="رجاء اختيار المسار" :options="old('gender_id')  ? App\Models\Grade::grades(true,old('gender_id') ) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="old('grade_id') ?  ['' => 'اختر الصف'] + App\Models\Level::levels(true,old('grade_id')) : []" onchange="get_discount_values()" />
        </div>
    </div>


    <div class="row mb-1 ">
        <div class="col-md">
            <label for="academic_year_id" class="form-label">خصومات القسائم</label>
            <span id="total_discount_span" class="badge bg-primary"></span>
            <div class="progress progress-bar-primary mt-1">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="total_discount" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </div>

        <div class="col-md">
            <label for="academic_year_id" class="form-label">قسائم صالحة</label>
            <span id="unused_discount_span" class="badge bg-warning"></span>
            <div class="progress progress-bar-warning mt-1">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="unused_discount" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </div>

        <div class="col-md">
            <label for="academic_year_id" class="form-label">الخصومات المستخدمة</label>
            <span id="used_discount_span" class="badge bg-danger"></span>
            <div class="progress progress-bar-danger mt-1">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="used_discount" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </div>

        <div class="col-md">
            <label for="academic_year_id" class="form-label">الخصومات المتاحة</label>
            <span id="remain_discount_span" class="badge bg-success"></span>
            <div class="progress progress-bar-success mt-1">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="remain_discount" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </div>
    </div>


    <x-ui.divider>معلومات القسيمة</x-ui-divider>

        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.text.Input :required="false" label="رمز القسيمة (اختياري)"  onchange="toUpperCase(this)" class="only-english" icon="file-text" name="code" placeholder="في حالة ترك الخانة فارغة .. سيتم توليد رمز القسيمة تلقائيا" data-msg="ارمز القسيمة بشكل صحيح" />
            </div>
            <div class="col-md">
                <x-inputs.text.Input type="number" min="0" label="قيمة الخصم" icon="file-text" name="coupon_value" placeholder="ادخل قيمة الخصم" data-msg="رجاء ادخال قيمة االخصم بشكل صحيح" />
            </div>
        </div>


        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.text.Input label="متاح ابتداء من" class="form-control flatpickr-basic" icon="calendar" name="available_at" placeholder="ادخل متاح ابتداء من" />

            </div>

            <div class="col-md">
                <x-inputs.text.Input label="تاريخ الانتهاء" class="form-control flatpickr-basic" icon="calendar" name="expire_at" placeholder="ادخل تاريخ الانتهاء" />

            </div>
        </div>
        <div class="row mb-1">
            <div class="col-md">
                <label class="form-label mb-1" for="active"> الحالة </label>
                <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>
            </div>
        </div>

        <div class="col-12 text-center mt-2">
            <x-inputs.submit>اضافة القسيمة </x-inputs.submit>
            <x-inputs.link route="coupons.index">عودة</x-inputs.link>
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
        @endsection
        @section('page-script')
        <script type="text/javascript">
            get_discount_values();
        </script>
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
        @endsection
