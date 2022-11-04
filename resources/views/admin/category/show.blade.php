@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('categories.index'), 'name' => "فئات العملاء"],['name' => 'مشاهدة']],['title'=> 'مشاهدة فئة العملاء']];
@endphp

@section('title', sprintf('مشاهدة معلومات الفئة : %s | %s',$category->id , $category->category_name))

@section('content')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css'))}}">

@endsection



@component('components.forms.formCard',['title' => sprintf('مشاهدة الفئة رقم : %s - %s',$category->id , $category->category_name)])

{{ Form::model($category,['route' => ['categories.update',$category->id],'method'=> 'PUT' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()']) }}

<x-ui.divider>معلومات الفئة</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="file-text" label="'اسم الفئة" name="category_name" placeholder="ادخل اسم الفئة" data-msg="'اسم الفئة بشكل صحيح" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="اسم الفئة الترويجي" icon="bell" name="promotion_name" placeholder="ادخل اسم الفئة الترويجي" data-msg="ااسم الفئة الترويجي بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="align-justify" label="'وصف الفئة" name="description" placeholder="ادخل وصف الفئة" data-msg="'وصف الفئة بشكل صحيح" />
        </div>

        <div class="col-md input-group">
        <x-inputs.number.input class="touchspin-icon" label="النقاط المطلوبة للترقية" name="required_points" placeholder="ادخل النقاط المطلوبة للترقية" data-msg="االنقاط المطلوبة للترقية بشكل صحيح" data-min="-1" data-max="5"/>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-3">
        <x-inputs.select.color label="اللون المميز" name="color" :selected="$category->color" placeholder="ادخل اللون" data-msg="رجاء ادخال اللون المميز للفئة" />
        </div>

        <div class="col-3">
            <label class="form-label mb-1">الحالة </label>
            <x-inputs.checkbox name="active">
                مفعل
            </x-inputs.checkbox>
        </div>

        <div class="col-3">
            <label class="form-label mb-1"> الفئة الافتراضية ؟ </label>
            <x-inputs.checkbox name="is_default">
                تحديد الفئة الافتراضية
            </x-inputs.checkbox>
        </div>

        <div class="col-3">
            <label class="form-label mb-1"> فئة ذات طابع خاص ؟
                <span data-bs-toggle="tooltip" class="text-danger" data-bs-placement="top" title="لا يتأثر اولياء الأمور في هذة الفئة بنظام اعادة تعيين الفئة بناء علي النقاط">
                    <em data-feather="info"></em></span>
            </label>
            <x-inputs.checkbox name="is_fixed" onclick="CheckCategoryType(this)">
                تحديد كفئة خاصة
            </x-inputs.checkbox>
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.link route="categories.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection

    @section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js'))}}"></script>

    @endsection
    @section('page-script')
    <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-number-input.js'))}}"></script>
  <Script>
        function CheckCategoryType(e)
        {
            const required_points = document.getElementById('required_points')         
            if (e.checked) {
                required_points.value = '-1' 
                required_points.setAttribute('readonly',1) 
            } else {
                required_points.removeAttribute('readonly') 
            } 
        }

    </Script>
    @endsection