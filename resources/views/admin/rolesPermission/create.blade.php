@extends('layouts.contentLayoutMaster')

@section('title', 'اضافة دور جديد')

@php 
$breadcrumbs = [[['link' => route('roles.index'), 'name' => "الأدوار"]], ['title'=>'اضافة دور جديد']];
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

@endsection
@php
$breadcrumbs = [[['link' =>route('home'), 'name' => "الرئيسية"], ['link' => route('roles.index'), 'name' => "الأدوار"], ['name' => "اضافة"]],['title' => 'تعديل الدور']];
@endphp
@section('content')

<section id="multiple-column-form">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">اضافة دور جديد</h4>

        </div>
        <div class="card-body">
          <!-- Add role form -->
          {{ Form::open(['route' => 'roles.store','method'=>'POST','id' => 'addRoleForm', 'class' => 'row','onsubmit' => 'return false']) }}

          <div class="row">

            <div class="col-md">
              <x-inputs.text.Input label="اسم الدور  انجليزي" name="name" placeholder="ادخل اسم الدور انجليزي" data-msg="رجاء ادخال اسم الدور انجليزي بشكل صحيح" />
            </div>

            <div class="col-md">
              <x-inputs.text.Input label="اسم الدور عربي" name="display_name" placeholder="ادخل اسم الدور عربي" data-msg="رجاء ادخال اسم الدور عربي بشكل صحيح" />
            </div>

            <div class="col-md">
              <x-inputs.select.color label="اللون المميز" name="color" placeholder="ادخل اللون" data-msg="رجاء ادخال اللون المميز للدور" />
            </div>
          </div>
          <div class="col-12">
            <h4 class="mt-2 pt-50">صلاحيات الدور</h4>
            <!-- Permission table -->
            <div class="table-responsive">
              <table class="table table-flush-spacing">
                <tbody>
                  <tr>
                    <td class="text-nowrap fw-bolder">
                      جميع الصلاحيات ؟
                      <span data-bs-toggle="tooltip" data-bs-placement="top" title="تحديد جميع الصلاحيات المتاحة بالنظام">
                        <em data-feather="info"></em></span>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll" />
                        <label class="form-check-label" for="selectAll"> تحديد الكل </label>
                      </div>
                    </td>
                  </tr>
                  @foreach($PermissionsCategory as $category)
                  <tr>
                    <td class="text-nowrap fw-bolder">{{ $category->category_name }}</td>
                    <td>
                      <div class="d-flex">
                        @foreach($category->permissions as $permission)
                        <x-inputs.checkbox data-msg="رجاء تحديد صلاحية واحدة علي الاقل" divClass="form-check col-md" name="permission[]" :value="$permission->id" id="permission{{$permission->id}}">
                          {{$permission->display_name}}
                        </x-inputs.checkbox>
                        @endforeach

                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- Permission table -->
          </div>
          <div class="col-12 text-center mt-2">
            <x-inputs.submit >اضافة</x-inputs.submit>
            <x-inputs.link route="roles.index">عودة</x-inputs.link>
          </div>
          {!! Form::close() !!}
          <!--/ Add role form -->
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/pages/modal-add-role.js')) }}"></script>
@endsection