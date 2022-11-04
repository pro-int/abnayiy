@extends('layouts.contentLayoutMaster')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header">تعديل معلومات الدولة : {{ $country->country_name }}
                @include('admin.inputs.buttons.back')
                </div>

                <div class="card-body">
                    {!! Form::model($country, ['method' => 'POST','route' => ['countries.update', $country->id]]) !!}
                    @method('PUT')
                    <input type="hidden" name="country_id" value="{{ $country->id }}">

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