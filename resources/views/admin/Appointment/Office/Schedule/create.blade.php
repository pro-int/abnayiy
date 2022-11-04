@extends('layouts.contentLayoutMaster')


@section('content')

{!! Form::open(['route' => ['appointments.offices.days.store',[$office->id]],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header"> تسجيل ميعاد جديد
                    @include('admin.inputs.buttons.back')
                </div>

                <div class="card-body">
                    <div class="row mb-3">

                        @include('admin.inputs.select.generic',['text' => 'اليوم ','input_name' => 'day_of_week','data' =>App\Models\officeSchedule::daysArray()])

                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-right" for="time_from">بداية المواعيد</label>
                        <div class="col-md-6">
                            <input class="form-control {{ $errors->has('time_from') ? ' is-invalid' : null }}" step="{{ env('MEETING_PERIOD',30) * 60 }}" id="time_from" type="time" name="time_from" value="{{ old('time_from') }}">

                            @error('time_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-right" for="time_to">نهاية المواعيد</label>
                        <div class="col-md-6">
                            <input class="form-control {{ $errors->has('time_to') ? ' is-invalid' : null }}" step="{{ env('MEETING_PERIOD',30) * 60 }}" type="time" id="time_to" name="time_to" value="{{ old('time_to') }}">
                            @error('time_to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        @include('admin.inputs.checkbox.active')
                    </div>
                    <div class="row mb-0">
                        @include('admin.inputs.buttons.submit',['text' => 'تسجيل ميعاد جديد'])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection