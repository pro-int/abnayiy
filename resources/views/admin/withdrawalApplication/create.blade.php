@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('withdrawals.index'), 'name' => "الطلبات"],['name'=> 'طلبات الانسحاب']],['title' => 'اضافة طلب انسحاب']];
@endphp

@section('title', 'تسجيل طلب انسحاب جديد')

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

@component('components.forms.formCard',['title' => sprintf('تسجيل طلب انسحاب جديد')])

{{ Form::open(['route' => 'withdrawals.store','method'=> 'POST' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()']) }}

<x-ui.divider>معلومات الطالب</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="الطالب" name="student_id" data-placeholder="ابحث عن اسم الطالب" data-msg="رجاء اسم الطالب"  />
        </div>
    </div>

<div class="row mb-1" id="student_info" style="display: none;">
    <div class="col-md">
        <x-inputs.text.Input label="اسم الطالب" name="student_name" :disabled="true" placeholder="ادخل اسم الطالب" data-msg="'اسم الطالب بشكل صحيح" />
    </div>

    <div class="col-md">
        <x-inputs.text.Input label="رقم الهوية" name="national_id" :disabled="true" data-msg="' بشكل صحيح" />
    </div>

    <div class="col-md">
        <x-inputs.text.Input label="الصف الدراسي" name="level_name" :disabled="true" data-msg="' بشكل صحيح" />
    </div>

</div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="سبب الانسحاب" name="reason" data-placeholder="ابحث عن سبب الانسحاب" data-msg="رجاءاختيار سبب الانسحاب"  :options="App\Models\WithdrawalApplication::getWithdrawalReasons()"/>
        </div>
        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ الانسحاب :اذا لم تقم باختيار تاريخ فسوف يتم تسجيل الطلب بتاريخ اليوم" data-msg="اذا لم تقم باختيار تاريخ فسوف يتم تسجيل الطلب بتاريخ اليوم"  name="date" placeholder="yyyy-mm-dd" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input label="اسم المدرسه المحول لها" name="school_name"  data-msg="' بشكل صحيح" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input type="textarea" label="اكتب تعليق مختصر عن سبب انسحابك" name="comment" data-placeholder="اكتب تعليقك" data-msg="رجاء اكتب تعليقك"/>
        </div>

    </div>

<div class="col-12 text-center mt-2">
    <x-inputs.submit>تسجيل طلب الأنسحاب</x-inputs.submit>
    <x-inputs.link route="withdrawals.index">عودة</x-inputs.link>
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

<script>

    $("#student_id").on('select2:select', function(e) {
        var student = e.params.data;

        document.getElementById('student_name').value = student.student_name;
        document.getElementById('national_id').value = student.national_id;
        document.getElementById('level_name').value = student.level_name;
        document.getElementById('student_info').style.display = 'flex';
    });

    $("#student_id").select2({
        ajax: {
            url: "/admin_dashboard/json/search_students",
            method: "post",
            delay: 500,
            data: function(params) {
                return {
                    q: params.term, // search term
                    _token: document.getElementsByName('_token')[0].value
                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                return {
                    results: data.data.students,
                };
            },
            cache: true
        },
        placeholder: 'ابحث عن الطالب بواسطة الاسم او رقم الهوية',
        minimumInputLength: 3,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return " ...جاري البحث في قاعدة البيانات";
        }

        var $container = $(
            "<div class='select2-result-users clearfix'>" +
            "<div class='select2-result-users__meta'>" +
            "<div class='select2-result-users__title'></div>" +
            "<div class='select2-result-users__national_id'></div>" +
            "<div class='select2-result-users__level_name'></div>" +
            "</div>" +
            "</div>"
        );
        $container.find(".select2-result-users__title").html('<span class="text-danger">الاسم : </span>' + repo.student_name + '</span>');
        $container.find(".select2-result-users__national_id").html('<span class="text-danger">الهوية : </span>' + repo.national_id + '</span>');
        $container.find(".select2-result-users__level_name").html('<span class="text-danger">الصف الدراسي : </span>' + repo.level_name + '</span>');

        return $container;
    }

    function formatRepoSelection(repo) {
        if (repo.id === '') {
            return 'اختر اسم الطالب';
        }
        if (repo.student_name == undefined) {
            return repo.text
        }
        return repo.student_name + ' - (' + repo.level_name + ')';
    }
</script>
@endsection
