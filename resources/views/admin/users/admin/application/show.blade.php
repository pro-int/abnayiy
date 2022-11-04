@extends('layouts.contentLayoutMaster')

@section('title', 'مشاهدة مشرف')

@php
$breadcrumbs = [[['link' => route('admins.index'), 'name' => "مديرين النظام"], ['link' => route('ApplicationManagers.index'), 'name' => "مشرفين الطلبات"], [ 'name' => "مشاهدة مشرف"]],['title' => 'تسجيل مشرف']];
@endphp

@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<x-forms.formCard title="مشاهدة مشرف الطلبات ">

{!! Form::model($ApplicationManager, ['method' => 'PUT','route' => ['ApplicationManagers.update', $ApplicationManager->admin_id]]) !!}

    <x-ui.divider>اختر احد المديرين </x-ui-divider>

    <div class="row mb-1 justify-content-center">
        <div class="col-md-6">
            <x-inputs.text.Input name="admin_name" data-placeholder=" المدير" data-msg="رجاء اختيار المدير"  />
        </div>
    </div>
    <x-ui.divider> قائمة اقسام الأشراف</x-ui-divider>

        <div class="row mb-1 justify-content-center">
            <div class="col-6">
                <select name="grade_id[]" class="form-control {{ $errors->has('grade_id') ? ' is-invalid' : '' }}" id="grade_id" multiple required style="min-height: 350px;">

                    @foreach($schools as $school)
                    @foreach($school->genders as $gender)
                    @if(count($gender->grades) > 0)
                    <optgroup label="{{ $school->school_name }} -> {{ $gender->gender_name }}">
                        @foreach($gender->grades as $grade)

                        <option @if(in_array($grade->id,$ids)) selected @endif value="{{ $grade->id }}">{{ $grade->grade_name }}</option>

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