@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header">{{ sprintf('اضافة تكرار جديد  للأشعار رقم #(%s) - %s - %s', $notification->id,$notification->section_name,$notification->event_name) }}
                    @include('admin.inputs.buttons.back')
                </div>

                <div class="card-body">
                    {!! Form::open(['route' => ['notifications.types.frequent.store',$notification->id,$type],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

                    <div class="row mb-3">
                        @include('admin.inputs.select.generic',['text' => 'الشرط','input_name' => 'condition_type', 'data' => ['before' => 'قبل', 'after' => 'بعد']])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.select.generic',['text' => 'المحتوي','input_name' => 'content_id', 'data' => Gtech\AbnayiyNotification\Models\NotificationContent::contents(1,$notification->event_id)])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.number.generic',['text' => 'الساعات','input_name' => 'interval'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.checkbox.active')
                    </div>

                    <div class="row mb-0">
                        @include('admin.inputs.buttons.submit',['text' => 'اضافة'])
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}



@endsection