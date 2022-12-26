@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('genders.index'), 'name' => "الأقسام "],['link' => route('genders.edit',$gender), 'name' => "مشاهدة الأقسام : $gender->gender_name" ]],['title'=> 'مشاهدة معلومات القسم']];
@endphp

@section('title', 'مشاهدة القسم ')

@section('content')

@component('components.forms.formCard',['title' => 'مشاهدة معلومات القسم '])

{!! Form::model($gender, ['method' => 'POST','route' => ['genders.update', $gender->id]]) !!}

<x-ui.divider>معلومات القسم</x-ui-divider>

  <div class="row mb-1 center">
    <div class="col-md">
      <x-inputs.select.generic label="المدرسة" onLoad="{{ old('school_id') ? null : 'change'}}" name="school_id" data-placeholder="اختر المدرسة " data-msg="رجاء اختيار المدرسة " :options="['' => 'اختر المدرسة '] + schools()" />
    </div>

    <div class="col-md">
      <x-inputs.text.Input label="اسم القسم" icon="file-text" name="gender_name" placeholder="ادخل اسم القسم" data-msg="ااسم القسم بشكل صحيح" />
    </div>

    <div class="col-md  mb-1">
      <x-inputs.select.generic label="نوع" name="gender_type" data-placeholder="اختر نوع" data-msg="رجاء اختيار نوع" :options="['1' => 'بنين' , '0' => 'بنات' ,'2' => 'مشترك']" />
    </div>
  </div>

    <div class="row mb-1 center">
        <div class="col-md">
            <x-inputs.text.Input type="text" label="Odoo Product ID رسوم دراسيه" icon="anchor" name="odoo_product_id_study" placeholder="ادخل Odoo Product ID" data-msg="ادخل Odoo Product ID بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input type="text" label="Odoo Account Code رسوم دراسيه" icon="anchor" name="odoo_account_code_study" placeholder="ادخل Odoo Account Code" data-msg="ادخل Odoo Account Code بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input type="text" label="Odoo Product ID رسوم نقل" icon="anchor" name="odoo_product_id_transportation" placeholder="ادخل Odoo Product ID" data-msg="ادخل Odoo Product ID بشكل صحيح" />
        </div>
        
        <div class="col-md">
            <x-inputs.text.Input type="text" label="Odoo Account Code رسوم نقل" icon="anchor" name="odoo_account_code_transportation" placeholder="ادخل Odoo Account Code" data-msg="ادخل Odoo Account Code بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1 center">
        <div class="col-md">
            <x-inputs.text.Input label="اسم القسم التعليمي في نظام نور" icon="file-text" name="grade_name_noor" placeholder="ادخل اسم القسم التعليمي في نظام نور" data-msg="ااسم القسم التعليمي في نظام نور بشكل صحيح" />
        </div>
        <div class="col-md">
            <x-inputs.select.generic label="حساب نظام نور" name="noor_account_id" data-placeholder="اختر حساب نظام نور" data-msg="رجاء اختيار حساب نظام نور" :options="App\Models\NoorAccount::accounts()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic label="قسم المقابلات" name="appointment_section_id" data-placeholder="اختر قسم المقابلات" data-msg="رجاء اختيار قسم المقابلات" :options="App\Models\AppointmentSection::sections()" />
        </div>
    </div>
  <div class="row mb-1 center">

    <div class="col-md  mb-1">
      <label class="form-label mb-1" for="active"> الحالة </label>
      <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>
    </div>
  </div>

  <div class="col-12 text-center mt-2">
    <x-inputs.link route="genders.index">عودة</x-inputs.link>
  </div>
  </div>
  {!! Form::close() !!}

  @endcomponent

  @endsection
