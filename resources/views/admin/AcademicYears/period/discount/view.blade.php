@extends('layouts.contentLayoutMaster')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header">مشاهدة الفترة  :  {{ $period->period_name }}</div>

                <div class="card-body">
                    {!! Form::model($period, ['method' => 'POST','route' => ['periods.discounts.destroy', ['discount' => $discount->id,'period' => $period->id]]]) !!}
                    @method('PUT')
                    
                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => 'اسم الفترة','input_name' => 'period_name'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.date.generic',['text'=> 'تاريخ البدء', 'input_name'=> 'apply_start','item' => $period])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.date.generic',['text'=> 'تاريخ الانتهاء', 'input_name'=> 'apply_end','item' => $period])
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}



@endsection