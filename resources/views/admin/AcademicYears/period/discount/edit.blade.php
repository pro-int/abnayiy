@extends('layouts.contentLayoutMaster')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header">تعديل الفترة  :  {{ $period->period_name }}</div>

                <div class="card-body">
                    {!! Form::model($period, ['method' => 'POST','route' => ['periods.update', $period->id]]) !!}
                    @method('PUT')
                    
                    <div class="row mb-3">
                        @include('admin.inputs.select.generic',['text' => 'السنة الدراسية','input_name' => 'year_id', 'data' => $AcademicYear])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => 'اسم الفترة','input_name' => 'period_name'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.date.generic',['text'=> 'تاريخ البدء', 'input_name'=> 'apply_start','item' => $period])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.date.generic',['text'=> 'تاريخ الانتهاء', 'input_name'=> 'apply_end','item' => $period])
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