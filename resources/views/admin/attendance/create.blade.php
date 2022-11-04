@extends('layouts.contentLayoutMaster')


@section('content')

{!! Form::open(['route' => 'categories.store','method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header">تسجيل نظام تعليمي جديدة
                    @include('admin.inputs.buttons.back')
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => 'اسم الفئة','input_name' => 'category_name'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => 'اسم الفئة الترويجي','input_name' => 'promotion_name'])
                    </div>


                    <div class="row mb-3">
                        @include('admin.inputs.textarea.generic',['text' => 'وصف الفئة','input_name' => 'description'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.number.generic',['text' => 'اقل عدد للأيناء','input_name' => 'min_students'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.checkbox.generic',['text' => 'الفئة الافتراضية','input_name' => 'is_default'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.checkbox.active')
                    </div>

                    <div class="row mb-0">
                        @include('admin.inputs.buttons.submit',['text' => 'تسجيل فئة جديد'])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection