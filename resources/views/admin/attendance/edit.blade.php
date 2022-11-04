@extends('layouts.contentLayoutMaster')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header">تعديل النظام الدراسي {{ $category->category_name }}
                    @include('admin.inputs.buttons.back')
                </div>

                <div class="card-body">
                    {!! Form::model($category, ['method' => 'POST','route' => ['categories.update', $category->id]]) !!}
                    @method('PUT')

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
                        @include('admin.inputs.buttons.submit',['text' => 'تعديل'])
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}



@endsection