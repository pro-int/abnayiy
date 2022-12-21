@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('contract_design.edit'), 'name' => 'تصميمات العقود'],['link' => route('contract_design.edit'), 'name' => "تعديل تمصميم "]],['title'=> 'تعديل تصميم']];
@endphp

@section('title', 'تعديل التصميم ')

@section('content')

@component('components.forms.formCard',['title' => 'تعديل تصميم '])

{!! Form::model($template,['route' => ['contract_design.update',$template],'method'=>'POST','files' => true]) !!}

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
                            <img src="{{ Storage::disk('s3')->exists($template->school_logo) ? getSpaceUrl($template->school_logo) : asset('assets/logo-removebg-preview.png') }}" id="blog-feature-image" class="rounded me-2 mb-1 mb-md-0" width="170" height="110" alt="Blog Featured Image" />
                            <div class="featured-info">
                                <small class="text-muted">غي حالة عدم رفع شعار المدرسية سيتم استخدام الشعار الأفتراضي</small>
                                <p class="my-50">
                                    <a href="#" id="blog-image-text">مسموح jpg/png/jpeg</a>
                                </p>
                                <div class="d-inline-block">
                                    {{ Form::file('school_logo', null, ['accept' => 'image/*','class'=>'form-control'])}}
                                    @error('school_logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md">
                    <div class="border rounded p-2">
                        <h4 class="mb-1">الشعار المائي</h4>
                        <div class="d-flex flex-column flex-md-row">
                            <img src="{{  Storage::disk('s3')->exists($template->school_watermark) ? getSpaceUrl($template->school_watermark) : asset('assets/reportLogo45d.png')}}" id="blog-feature-image" class="rounded me-2 mb-1 mb-md-0" width="170" height="110" alt="Blog Featured Image" />
                            <div class="featured-info">
                                <small class="text-muted">غي حالة عدم رفع شعار المدرسية سيتم استخدام الشعار الأفتراضي</small>
                                <p class="my-50">
                                    <a href="#" id="blog-image-text">مسموح jpg/png/jpeg</a>
                                </p>
                                <div class="d-inline-block">
                                    {{ Form::file('school_watermark', null, ['accept' => 'image/*','class'=>'form-control'])}}
                                    @error('school_watermark')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center mt-2">
                <x-inputs.submit> تعديل </x-inputs.submit>

                <x-inputs.link route="categories.index">عودة</x-inputs.link>
            </div>
            {!! Form::close() !!}

            @endcomponent

            @endsection
