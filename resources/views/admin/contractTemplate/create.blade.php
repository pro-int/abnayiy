@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('contract_design.edit'), 'name' => 'تصميمات العقود'],['link' => route('contract_design.edit'), 'name' => "اضافة تمصميم "]],['title'=> 'اضافة تصميم']];
@endphp

@section('title', 'تعديل التصميم ')

@section('content')

@component('components.forms.formCard',['title' => 'اضافة تصميم '])

{!! Form::open(['route' => 'contract_design.store','method'=>'POST','files' => true]) !!}

<x-ui.divider>معلومات التصميم</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="align-justify" label="اسم التصميم" name="templates_name" placeholder="ادخل اسم التصميم" data-msg="اسم التصميم بشكل صحيح" />
        </div>
        <div class="col-3">
            <label class="form-label mb-1"> التصميم الافتراضي ؟ </label>
            <x-inputs.checkbox name="is_default">
                إفتراضي
            </x-inputs.checkbox>
        </div>
    </div>
    <x-ui.divider>معلومات المدرسة</x-ui-divider>

        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.text.Input label="اسم المدرسة" name="school_name" placeholder="ادخل اسم المدرسة" data-msg="اسم المدرسة بشكل صحيح" />
            </div>
        </div>
        <x-ui.divider>شعار المدرسة</x-ui-divider>

            <div class="row mb-1">

                <div class="col-md">
                    <div class="border rounded p-2">
                        <h4 class="mb-1">شعار المدرسة</h4>
                        <div class="d-flex flex-column flex-md-row">
                            <img src="{{asset('assets/reportLogo.png')}}" id="blog-feature-image" class="rounded me-2 mb-1 mb-md-0" width="170" height="110" alt="Blog Featured Image" />
                            <div class="featured-info">
                                <small class="text-muted">غي حالة عدم رفع شعار المدرسية سيتم استخدام الشعار الأفتراضي</small>
                                <p class="my-50">
                                    <a href="#" id="blog-image-text">مسموح jpg/png/jpeg</a>
                                </p>
                                <div class="d-inline-block">
                                    {{ Form::file('school_logo', null, ['accept' => 'image/*','class'=>'form-control'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md">
                    <div class="border rounded p-2">
                        <h4 class="mb-1">الشعار المائي</h4>
                        <div class="d-flex flex-column flex-md-row">
                            <img src="{{asset('assets/reportLogo45d.png')}}" id="blog-feature-image" class="rounded me-2 mb-1 mb-md-0" width="170" height="110" alt="Blog Featured Image" />
                            <div class="featured-info">
                                <small class="text-muted">غي حالة عدم رفع شعار المدرسية سيتم استخدام الشعار الأفتراضي</small>
                                <p class="my-50">
                                    <a href="#" id="blog-image-text">مسموح jpg/png/jpeg</a>
                                </p>
                                <div class="d-inline-block">
                                {{ Form::file('school_watermark', null, ['accept' => 'image/*','class'=>'form-control'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center mt-2">
                <x-inputs.submit> اضافة </x-inputs.submit>

                <x-inputs.link route="categories.index">عودة</x-inputs.link>
            </div>
            {!! Form::close() !!}

            @endcomponent

            @endsection