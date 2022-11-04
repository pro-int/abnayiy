@extends('layouts.contentLayoutMaster')


@section('content')

{!! Form::open(['route' => 'roles.store','method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header">تسجيل دور جديد
                    @include('admin.inputs.buttons.back')
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => 'اسم الدور بالعربية','input_name' => 'display_name'])
                    </div>


                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => ' اسم الدور E','input_name' => 'name'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.select.colors',['text' => 'اللون','input_name' => 'color'])
                    </div>

                    <div class="row mb-12">
                        <strong>الصلاحيات:</strong>


                        @foreach($PermissionsCategory as $category)
                        <div class="col-md-4">
                            <strong>{{ $category->category_name }}:</strong>

                            @foreach($category->permissions as $permission)
                            <div class="form-check">
                                {!! Form::checkbox('permission[]',$permission->id,old('permission[]'),['id'=> 'ch' .$permission->id ,'class'=>'form-check-input']) !!}
                                {{ Form::label('ch'. $permission->id ,$permission->display_name ,['class'=> 'form-check-label']) }}
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>

                    <div class="row mb-0">
                        @include('admin.inputs.buttons.submit',['text' => 'تسجيل دور جديد'])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}



@endsection