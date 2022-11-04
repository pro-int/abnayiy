@extends('layouts.contentLayoutMaster')

@section('title', 'مشاهدة صلاحيات المشرف')

@php
$breadcrumbs = [[['link' => route('admins.index'), 'name' => "مديرين النظام"], ['link' => route('AttendanceManagers.index'), 'name' => "مشرفين الغياب"], [ 'name' => "مشاهدة صلاحيات المشرف"]],['title' => 'تسجيل مشرف']];
@endphp

@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<x-forms.formCard title="مشاهدة صلاحيات المشرف ">

    {!! Form::model($AttendanceManager, ['method' => 'PUT','route' => ['AttendanceManagers.update', $AttendanceManager->admin_id]]) !!}

    <x-ui.divider>اختر احد المديرين </x-ui-divider>

        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <x-inputs.select.generic label="المدير" name="admin_id" data-placeholder="اختر المدير" data-msg="رجاء اختيار المدير" :options="$users" />
            </div>
        </div>
        <x-ui.divider>الاقسام</x-ui-divider>

            <div class="row mb-1 justify-content-center">
                <div class="col-6">
                    <select name="level_id[]" class="form-control {{ $errors->has('level_id') ? ' is-invalid' : null }}" id="level_id" multiple required style="min-height: 350px;">

                        @foreach($types as $type)
                        @foreach($type->genders as $gender)
                        @if(count($gender->grades) > 0)
                        <optgroup label="{{ $type->school_name }} -> {{ $gender->gender_name }}">
                            @foreach($gender->grades as $grade)
                            @foreach($grade->levels as $level)
                            <option @if(in_array($level->id,$ids)) selected @endif value="{{ $level->id }}">{{ $grade->grade_name }} -> {{ $level->level_name }}</option>
                            @endforeach
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
                <x-inputs.link route="AttendanceManagers.index">عودة</x-inputs.link>
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