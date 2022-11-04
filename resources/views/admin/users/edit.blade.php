@extends('layouts.contentLayoutMaster')

@section('title', 'تعديل حساب ')
@php
$breadcrumbs = [[['link' => route('users.index'), 'name' => "حسابات المستخدمين"], [ 'name' => "تعديل حساب "]],['title' => 'تعديل حساب']];
@endphp

@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/katex.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/monokai-sublime.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/quill.snow.css'))}}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection



@section('content')

@component('components.forms.formCard',['title' => sprintf('تعديل حساب المستخدم <span class="text-danger">%s</span>', $user->getFullName()) ])

{{ Form::model($user ,['route' => ['users.update', $user->id],'method'=> 'PUT' , 'class' => 'row','id' => 'adminform']) }}

<x-ui.divider>معلومات المستخدم</x-ui-divider>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="user" label="الاسم الاول" name="first_name" placeholder="ادخل الاسم الاول" data-msg="الاسم الاول بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="الاسم الاخير" icon="user" name="last_name" placeholder="ادخل الاسم الاخير" data-msg="الاسم الاخير بشكل صحيح" />
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input type="email" icon="mail" label="البريد الألكتروني" name="email" placeholder="ادخل البريد الألكتروني" data-msg="رجاء ادخال البريد الألكتروني بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="رقم الهاتف" icon="smartphone" name="phone" placeholder="ادخل رقم الهاتف بالصيغة الدولية" data-msg="ادخل رقم الهاتف بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md-6">
            <x-inputs.select.generic label="الدولة" name="country_id" data-placeholder="اختر الدولة" data-msg="رجاء اختيار الدولة" :options="getCountries()" class="select2" />
        </div>
    </div>
    <x-ui.divider>كلمة المرور</x-ui-divider>

        <div class="row mb-1">
            <x-inputs.checkbox name="change_password" onchange="togglegChangePassword()">
                تغيير كلمة المرور ؟
            </x-inputs.checkbox>
        </div>
        <div class="row mb-1">
            <div class="col-6">
                <x-inputs.password required name="password" label="كلمة المرور" />
            </div>

            <div class="col-6">
                <x-inputs.password required name="password_confirmation" label="تاكيد كلمة المرور" />
            </div>
        </div>

        <div class="row mb-1 mt-1">
            <div class="col-4">
                <label class="form-label mr-1" for="isAdmin">عضوية الأدارة ؟</label>
                <x-inputs.checkbox :checked="old('isAdmin') ?? (bool) $user->admin" onchange="togglegStutus(this)" name="isAdmin">انشاء حساب مدير</x-inpurs.checkbox>
            </div>

            <div class="col-4">
                <label class="form-label mr-1" for="isGuardian">عضوية ولي امر ؟</label>
                <x-inputs.checkbox :checked="old('isGuardian') ?? (bool) $user->guardian" onchange="togglegStutus(this)" name="isGuardian"> انشاء حساب ولي امر</x-inpurs.checkbox>
            </div>

            <div class="col-4">
                <label class="form-label mr-1" for="isTeacher">عضوية معلم ؟</label>
                <x-inputs.checkbox :checked="old('isTeacher') ??  (bool) $user->teacher" onchange="togglegStutus(this)" name="isTeacher"> انشاء حساب معلم</x-inpurs.checkbox>
            </div>
        </div>

        <div id="isAdminDiv">
            <x-ui.divider color="danger">معلومات عضوية مدير</x-ui-divider>

                <div class="row mb-1">
                    <div class="col-md">
                        <x-inputs.text.Input :required="false" icon="mail" label="المسمي الوظيفي" class="required-on-checked" name="job_title" :value="$user->admin->job_title ?? ''" placeholder="ادخل المسمي الوظيفي" data-msg="رجاء ادخال المسمي الوظيفي بشكل صحيح" />
                    </div>

                    <div class="col-md">
                        <x-inputs.select.generic :required="false" label="الأدوار" name="roles[]" :selected="$user->roles->pluck('name') ?? []" data-placeholder="اختر الدور" data-msg="رجاء اختيار الدور" :options="getRoles()" class="select2 required-on-checked" multiple />
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-4">
                        <label class="form-label mr-1" for="admin_active">حالة عضوية المدير</label>
                        <x-inputs.checkbox :checked="old('admin_active') ?? $user->admin && $user->admin->active" name="admin_active">مفعل</x-inpurs.checkbox>
                    </div>
                </div>
        </div>

        <div id="isGuardianDiv">
            <x-ui.divider>معلومات عضوية ولي الامر</x-ui-divider>

                <div class="row mb-1">
                    <div class="col-md">
                        <x-inputs.select.generic label="الدولة" name="nationality_id" :selected="$user->guardian->nationality_id ?? []" data-placeholder="اختر الدولة" data-msg="رجاء اختيار الدولة" :options="App\Models\Country::countries()" />
                    </div>

                    <div class="col-md">
                        <x-inputs.text.Input icon="file-text" label="رقم الهوية" name="national_id" :value="$user->guardian->national_id ?? ''" placeholder="ادخل رقم الهوية" data-msg="رجاء ادخال رقم الهوية بشكل صحيح" />
                    </div>

                    <div class="col-md">
                        <x-inputs.text.Input icon="map-pin" label="عنوان الاقامة" name="address" :value="$user->guardian->address ?? ''" placeholder="ادخل عنوان الاقامة" data-msg="رجاء اسم ادخال عنوان الاقامة بشكل صحيح" />
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-md">
                        <x-inputs.text.Input label="مدينة الاقامة" icon="map" name="city_name" :value="$user->guardian->city_name ?? ''" placeholder="ادخل مدينة الاقامة" data-msg="ادخل مدينة الاقامة بشكل صحيح" />
                    </div>
                    <div class="col-md">
                        <x-inputs.select.generic label="فئة ولي الأمر" name="category_id" :selected="$user->guardian->category_id ?? []" data-placeholder="اختر فئة ولي الأمر" data-msg="رجاء اختيار فئة ولي الأمر" :options="$roles" class="select2" :options="App\Models\Category::categories()" />
                    </div>
                    <div class="col-md">
                        <label class="form-label mr-1" for="guardian_active">حالة عضوية ولي الامر</label>
                        <x-inputs.checkbox :checked="old('guardian_active') ?? $user->guardian && $user->guardian->active" name="guardian_active">مفعل</x-inpurs.checkbox>
                    </div>
                </div>
        </div>

        <div id="isTeacherDiv">
            <x-ui.divider color="warning">معلومات عضوية المعلم</x-ui-divider>

                <div class="row mb-1">
                    <div class="col-4">
                        <label class="form-label mr-1" for="teacher_active">حالة عضوية المعلم</label>
                        <x-inputs.checkbox :checked="old('teacher_active') ?? $user->teacher && $user->teacher->active" name="teacher_active">مفعل</x-inpurs.checkbox>
                    </div>
                </div>
        </div>

        <div class="col-12 text-center mt-2">
            <x-inputs.submit>تعديل معلومات الحساب</x-inputs.submit>
            <x-inputs.link route="users.index">عودة</x-inputs.link>
        </div>

        {!! Form::close() !!}

        @endcomponent
        @endsection

        @section('vendor-script')
        <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        @endsection

        @section('page-script')
        <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
        <script>
            function togglegStutus(e) {
                let div = document.getElementById(e.id + 'Div');

                div.style = !e.checked ? 'display:none;' : '';

                const inputs = div.getElementsByClassName('required-on-checked')


                for (const key in inputs) {
                    if (e.checked) {
                        inputs[key].required = true;
                    } else {
                        inputs[key].required = false;
                    }
                }
            }

            function togglegChangePassword() {
                let change_passsword = document.getElementById('change_password');
                let password = document.getElementById('password');
                let password_confirmation = document.getElementById('password_confirmation');

                password.required = change_passsword.checked
                password_confirmation.required = change_passsword.checked
            }

            togglegStutus(document.getElementById('isAdmin'));
            togglegStutus(document.getElementById('isGuardian'));
            togglegStutus(document.getElementById('isTeacher'));
            togglegChangePassword();
        </script>
        @endsection