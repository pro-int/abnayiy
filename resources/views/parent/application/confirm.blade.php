@extends('layouts.contentLayoutMaster')


@section('content')

<div class="container">
    <div class="row justify-content-center p-2">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header"> الطلب رقم # : {{ $application->id }} - {{ $application->student_name }} <span class="badge badge-{{ $application->color }}"> {{ $application->status_name }}</span>
                    @include('admin.inputs.buttons.back')
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'اسم الطالب','input_name' => 'student_name','item' => $application])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'رقم الهوية','input_name' => 'national_id','item' => $application])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'مكان الولادة','input_name' => 'birth_place','item' => $application])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text'=> 'تاريخ الميلاد', 'input_name'=> 'birth_date','item' => $application])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'جنسية الطالب','input_name' => 'nationality_name','item' => $application])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.checkbox.generic',['text' => 'يحتاج الي رعاية','input_name' => 'student_care', 'label' => 'نعم','item' => $application])
                    </div>
                    <hr>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'المدرسة','input_name' => 'school_name','item' => $application])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'النوع','input_name' => 'gender_name','item' => $application])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'المرحلة','input_name' => 'grade_name','item' => $application])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'الصف الدراسي','input_name' => 'level_name','item' => $application])
                    </div>
                    <hr>
                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'خطة الدفع','input_name' => 'plan_name','item' => $application])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'حالة الطلب','input_name' => 'status_name','item' => $application])
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($application->meeting)
    <div class="row justify-content-center p-2">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header">
                    المقابلة الشخصية
                </div>
                <div class="card-body">

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text'=> 'موعد الاجتماع', 'input_name'=> 'day','item' => $application->meeting])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.label.generic',['text' => 'الساعة','input_name' => 'time','item' => $application->meeting])
                    </div>

                    <div class="row mb-3">
                        <label for="meeting_location" class="col-md-4 col-form-label text-md-right">مكان المقابلة</label>
                        <div class="col-md-6">
                            @if($application->meeting->online == 1)
                            مقابلة افتراضية : <a href="{{ null !== $application->online_url ? $application->online_url : '#' }}">رابط المقابلة</a>
                            @else
                            <label>مقايلة شخصية بمقر المدرسة</label>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                    <label for="meeting_location" class="col-md-4 col-form-label text-md-right">نتيجة المقابلة</label>
                        <div class="col-md-6">
                            @if($application->meeting->attended == 1)
                             <textarea disabled cols="30" rows="10" class="form-control">{{ $application->meeting->summary }}</textarea>
                            @else
                            <label>لم تتم المقابلة حتي الان</label>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
{!! Form::close() !!}



@endsection