@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('applications.index'), 'name' => "الطلبات"],['name'=> 'طلبات الألتحاق']],['title' => 'مشاهدة طلب الألتحاق']];
@endphp

@section('title', sprintf('مشاهدة الطلب رقم : %s | %s',$application->id , $application->student_name))

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

@component('components.forms.formCard',['title' => sprintf('مشاهدة الطلب رقم : %s - %s',$application->id , $application->student_name)])

{{ Form::model($application,['route' => ['applications.update',$application->id],'method'=> 'PUT' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()']) }}

<x-ui.divider>معلومات ولي الأمر</x-ui-divider>

    <div class="row mb-1">

        <div class="col-md">
            <x-inputs.text.Input label="اسم ولي الأمر" name="full_name" :disabled="true" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="رقم الجوال" name="phone" :disabled="true" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="رقم الهوية" name="user_national_id" :disabled="true" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="الفئة" name="category_name" :disabled="true" />
        </div>
    </div>

    <x-ui.divider>معلومات الطالب</x-ui-divider>
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
                        <x-inputs.select.generic select2="" label="المدرسة" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="schools()" :onLoad="$application->school_id ? '' : 'change'" />
                    </div>

                    <div class="col-md">
                        <x-inputs.select.generic select2="" label="القسم" name="gender_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="$application->school_id ? App\Models\Gender::genders(true,$application->school_id) : []" />
                    </div>

                    <div class="col-md">
                        <x-inputs.select.generic select2="" label="المسار" name="grade_id" data-placeholder="اختر المسار" data-msg="رجاء اختيار المسار" :options="$application->gender_id ? App\Models\Grade::grades(true,$application->gender_id) : []" />
                    </div>

                    <div class="col-md">
                        <x-inputs.select.generic select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="$application->grade_id ? App\Models\Level::levels(true,$application->grade_id) : []" />
                    </div>
                </div>
            </div>


            <x-ui.divider>الموعد الحالي</x-ui-divider>

                <div class="row mb-1">
                    <div class="col-md">
                        <x-inputs.text.Input disabled label="تاريخ المقابلة الحالي" class="form-control flatpickr-basic" icon="calendar" name="old_selected_date" :value="$application->selected_date" />
                    </div>

                    <div class="col-md">
                        <x-inputs.text.Input disabled label="موهد الأجتماع الحالي" name="current_selected_time" icon="watch" :value="$application->appointment_time" />
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md">
                        <x-inputs.text.Input disabled label="المكتب" icon="flag" name="office_name" />
                    </div>
                    <div class="col-md">
                        <x-inputs.text.Input disabled label="الموظف" icon="flag" name="employee_name" />
                    </div>
                </div>


                <div class="row mb-1">
                    <div class="col-md">
                        <label class="form-label mb-1">موقع الأجتماع</label>
                        <x-inputs.checkbox name="online" onclick="toggleMeetingType(this)">
                            اجتماع عن بعد ؟
                        </x-inputs.checkbox>
                    </div>
                </div>

                <div class="row mb-1" id="meeting_info_div" style="{{ $application->online ? '' : 'display: none;' }}">
                    <div class="col-md-9">
                        <x-inputs.text.Input :required="$application->online ? true : false" label="رايط الأجتماع" icon="link" name="online_url" placeholder="ادخل رايط الأجتماع بالصيغة الدولية" data-msg="ادخل رايط الأجتماع بشكل صحيح" />
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

                        @endsection
