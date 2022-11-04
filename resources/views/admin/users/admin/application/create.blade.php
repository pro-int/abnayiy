@extends('layouts.contentLayoutMaster')

@section('title', 'اضافة مشرف')

@php
$breadcrumbs = [[['link' => route('admins.index'), 'name' => "مديرين النظام"], ['link' => route('ApplicationManagers.index'), 'name' => "مشرفين الطلبات"], [ 'name' => "اضافة مشرف"]],['title' => 'تسجيل مشرف']];
@endphp

@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<x-forms.formCard title="اضافة مشرف جديد">

    {!! Form::open(['route' => 'ApplicationManagers.store','method'=>'POST' , 'onsubmit' => 'showLoader()']) !!}

    <x-ui.divider>اختر احد المديرين </x-ui-divider>

        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <x-inputs.select.generic label="المدير" name="admin_id" data-placeholder="اختر المدير" data-msg="رجاء اختيار المدير" :options="$users" />
            </div>
        </div>
        <x-ui.divider>الاقسام</x-ui-divider>

            <div class="row mb-1 justify-content-center">
                <div class="col-6">
                    <select name="grade_id[]" class="form-control {{ $errors->has('grade_id') ? ' is-invalid' : '' }}" id="grade_id" multiple required style="min-height: 350px;">

                        @foreach($schools as $school)
                        @foreach($school->genders as $gender)
                        @if(count($gender->grades) > 0)
                        <optgroup label="{{ $school->school_name }} -> {{ $gender->gender_name }}">
                            @foreach($gender->grades as $grade)

                            <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>

                            @endforeach
                            @endif
                            @endforeach
                            @endforeach
                    </select>
                    @error('grade_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="col-12 text-center mt-2">
                <x-inputs.submit>اضافة مشرف جديد</x-inputs.submit>
                <x-inputs.link route="ApplicationManagers.index">عودة</x-inputs.link>
            </div>

            {!! Form::close() !!}

            </x-forms.fromCard>

            @endsection
            @section('vendor-script')
            <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
            @endsection

            @section('page-script')
            <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

            @endsection