@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('applications.index'), 'name' => "الطلبات"],['name'=> 'طلبات التحاق']],['title' => 'اضافة طلب التحاق']];
@endphp

@section('title', 'تسجيل طلب التحاق جديد')

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

@component('components.forms.formCard',['title' => sprintf('طلب التحاق جديد للعام الدراسي %s',$year->year_name)])

{{ Form::open(['route' => 'applications.store','method'=> 'POST' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()']) }}

<x-ui.divider>معلومات ولي الأمر</x-ui-divider>
    @php
    if(old('guardian_id')) {
    $guardian = App\Models\User::where('id', old('guardian_id'))->get()->pluck('first_name','id');
    }
    @endphp
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="ولي الأمر" name="guardian_id" data-placeholder="ابحث عن ولي الأمر" data-msg="رجاء ولي الأمر" :options="$guardian ?? []" />
        </div>
    </div>

<div class="row mb-1" id="user_info" style="display: none;">

    <div class="col-md">
        <x-inputs.text.Input label="اسم ولي الأمر" name="full_name" :disabled="true" placeholder="ادخل اسم ولي الأمر" data-msg="'اسم ولي الأمر بشكل صحيح" />
    </div>

    <div class="col-md">
        <x-inputs.text.Input label="رقم الجوال" name="phone" :disabled="true" data-msg="' بشكل صحيح" />
    </div>

    <div class="col-md">
        <x-inputs.text.Input label="رقم الهوية" name="user_national_id" :disabled="true" data-msg="' بشكل صحيح" />
    </div>

    <div class="col-md">
        <x-inputs.text.Input label="الفئة" name="category" :disabled="true" data-msg="' بشكل صحيح" />
    </div>
</div>

<x-ui.divider>معلومات الطالب</x-ui-divider>
    <input type="hidden" name="academic_year_id" value="{{$year->id}}">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="user" label="اسم الطالب" name="student_name" placeholder="ادخل اسم الطالب" data-msg="'اسم الطالب بشكل صحيح" />
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
        <label class="form-label">رعاية خاصة</label>

        <x-inputs.checkbox name="student_care">
            الطالب يحتاج الي رعاية خاصة
        </x-inputs.checkbox>
    </div>
</div>

<x-ui.divider>معلومات الصف الدراسي </x-ui-divider>

    <div class="row mb-1">
        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.select.generic select2="" label="المدرسة" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="schools()" :onLoad="old('school_id') ? '' : 'change'" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic select2="" label="القسم" name="gender_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="old('school_id') ? App\Models\Gender::genders(true,old('school_id')) : []" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic select2="" label="المسار" name="grade_id" data-placeholder="اختر المسار" data-msg="رجاء اختيار المسار" :options="old('gender_id') ?App\Models\Grade::grades(true,old('gender_id')) : []" />
            </div>

            <div class="col-md">
                <x-inputs.select.generic select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="old('grade_id') ? App\Models\Level::levels(true,old('grade_id')) : []" />
            </div>
        </div>
    </div>

<x-ui.divider>موعد المفابلة الشخصية</x-ui-divider>

<div class="row mb-1">
<div class="col-md">
    <x-inputs.text.Input label="تاريخ المقابلة" class="form-control flatpickr-basic" icon="calendar" name="selected_date" onchange="getMeetingSlots(this)" placeholder="ادخل متاح  ابتداء من" />
</div>

<div class="col-md">
    <x-inputs.select.generic label="موهد الأجتماع" name="selected_time" data-placeholder="اختر موهد الأجتماع" data-msg="رجاء اختيار موهد الأجتماع" :options="[]" />
</div>
</div>
<div class="row mb-1">
<div class="col-md">
    <label class="form-label mb-1">اجتماع عن بعد ؟</label>
    <x-inputs.checkbox name="online" onclick="toggleMeetingType(this)">
        ادخال معلومات الأجتماع عن بعد
    </x-inputs.checkbox>
</div>
</div>

<div class="row mb-1" id="meeting_info_div" style="{{ old('online') ? '' : 'display: none;' }}">
<div class="col-md-9">
    <x-inputs.text.Input :required="old('online') ? true : false" label="رايط الأجتماع" icon="link" name="online_url" placeholder="ادخل رايط الأجتماع بالصيغة الدولية" data-msg="ادخل رايط الأجتماع بشكل صحيح" />
</div>

<div class="col-md-3">
    <label class="form-label mb-1">اجتماع جديد ؟</label>
    <div>
        <a type="button" class="btn btn-sm btn-outline-danger waves-effect me-1" href="https://meet.google.com/" target="_blank" data-bs-toggle="popover" data-bs-content="اسم المستخدم: meet@nobala.edu.sa -  كلمة السر : rWD6y<4W  - بعد أن تقوم بإنشاء الاجتماع قم بنسخ رابط الاجتماع ولصقه في مربع رايط الأجتماع  " data-bs-trigger="hover" title="ستخدم بيانات الدخول التالية "> <em data-feather='external-link'></em> انشاء اجتماع جديد</a>


    </div>
</div>
</div>

<x-ui.divider>خطة دفع الرسوم الدراسية</x-ui-divider>

<div class="row mb-1">
    <div class="col-md">
        <x-inputs.select.generic select2="" label="خطة الدفع" name="plan_id" data-placeholder="اختر خطة الدفع" data-msg="رجاء اختيار خطة الدفع" :options="App\Models\Plan::plans()" />
    </div>
</div>

<x-ui.divider>خطة النقل</x-ui-divider>


<div class="row mb-1">
    <div class="col-md">
        <x-inputs.select.generic select2="" :required="false" label="'خطة النقل" name="transportation_id" data-placeholder="اختر النقل" data-msg="رجاء اختيار النقل" :options="['' => 'لا يرغب'] + App\Models\Transportation::transportations()" />
    </div>

    <div class="col-md">
        <x-inputs.select.generic select2="" :required="false" label="خطة دفع النقل" name="transportation_payment" data-placeholder="اختر خطة دفع النقل" data-msg="رجاء اختيار خطة دفع النقل" :options="['' => 'لا يرغب'] + App\Models\Transportation::payment_plans()" />
    </div>
</div>


<div class="col-12 text-center mt-2">
    <x-inputs.submit>تسجيل طلب الألتحاق</x-inputs.submit>
    <x-inputs.link route="applications.index">عودة</x-inputs.link>
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
    const selected_date = document.getElementById('selected_date');
    if (selected_date.value) {
        getMeetingSlots(selected_date).then(
            $('#selected_time').val('<?php echo old('selected_time') ?>') && $('#selected_time').trigger('change')
        )

    }

    $("#guardian_id").on('select2:select', function(e) {
        var user = e.params.data;

        document.getElementById('full_name').value = user.full_name;
        document.getElementById('phone').value = user.phone;
        document.getElementById('category').value = user.category_name;
        document.getElementById('user_national_id').value = user.national_id;
        document.getElementById('user_info').style.display = 'flex';
    });

    $("#guardian_id").select2({
        ajax: {
            url: "/admin_dashboard/json/search_users",
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
                    results: data.data.users,
                };
            },
            cache: true
        },
        placeholder: 'ابحث عن ولي الأمر بواسطة رقم الهوية او رقم الجوال',
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
            "<div class='select2-result-users__phone'></div>" +
            "</div>" +
            "</div>"
        );

        $container.find(".select2-result-users__title").html('<span class="text-danger">الاسم : </span>' + repo.full_name + '</span>');
        $container.find(".select2-result-users__national_id").html('<span class="text-danger">الهوية : </span>' + repo.national_id + '</span>');
        $container.find(".select2-result-users__phone").html('<span class="text-danger">الجمال : </span>' + repo.phone + '</span>');

        return $container;
    }

    function formatRepoSelection(repo) {
        if (repo.id === '') {
            return 'اختر ولي الأمر';
        }
        if (repo.full_name == undefined) {
            return repo.text
        }
        return repo.full_name + ' - (' + repo.phone + ')';
    }
</script>
@endsection
