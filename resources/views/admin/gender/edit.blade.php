@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('genders.index'), 'name' => "الأقسام "],['link' => route('genders.edit',$gender), 'name' => "تعديل الأقسام : $gender->gender_name" ]],['title'=> 'تعديل القسم']];
@endphp

@section('title', 'تعديل القسم التعليمي ')

@section('content')

@component('components.forms.formCard',['title' => 'تعديل معلومات القسم '])

{!! Form::model($gender, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['genders.update', $gender->id]]) !!}
<x-ui.divider>معلومات القسم</x-ui-divider>

  <div class="row mb-1 center">
    <div class="col-md">
      <x-inputs.select.generic label="المدرسة" onLoad="{{ old('school_id') ? null : 'change'}}" name="school_id" data-placeholder="اختر المدرسة " data-msg="رجاء اختيار المدرسة " :options="['' => 'اختر المدرسة '] + schools()" />
    </div>

    <div class="col-md">
      <x-inputs.text.Input label="اسم القسم" icon="file-text" name="gender_name" placeholder="ادخل اسم القسم" data-msg="ااسم القسم بشكل صحيح" />
    </div>

      <div class="col-md">
          <x-inputs.text.Input type="text" label="Odoo Product ID" icon="anchor" name="odoo_product_id" placeholder="ادخل Odoo Product ID" data-msg="ادخل Odoo Product ID بشكل صحيح" />
      </div>

  </div>
  <div class="row mb-1 center">

    <div class="col-md  mb-1">
      <x-inputs.select.generic label="نوع" name="gender_type" data-placeholder="اختر نوع" data-msg="رجاء اختيار نوع" :options="['1' => 'بنين' , '0' => 'بنات' ,'2' => 'مشترك']" />
    </div>

    <div class="col-md  mb-1">
      <label class="form-label mb-1" for="active"> الحالة </label>
      <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>
    </div>
  </div>

  <div class="col-12 text-center mt-2">
    <x-inputs.submit>تعديل القسم </x-inputs.submit>

    <x-inputs.link route="genders.index">عودة</x-inputs.link>
  </div>
  </div>
  {!! Form::close() !!}

  @endcomponent

  @endsection
