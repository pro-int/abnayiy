@extends('layouts.contentLayoutMaster')


@section('content')

{!! Form::open(['route' => 'countries.store','method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card text-md-end">
                <div class="card-header">اضافة دولة جديدة   
                    @include('admin.inputs.buttons.back')
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => 'اسم الدولة','input_name' => 'country_name'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => 'كود الدولة','input_name' => 'country_code'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.checkbox.active')
                    </div>
                    
                    <div class="row mb-0">
                        @include('admin.inputs.buttons.submit',['text' => 'تسجيل دولة جديدة'])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection