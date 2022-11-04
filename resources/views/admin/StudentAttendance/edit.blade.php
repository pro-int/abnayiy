@extends('layouts.contentLayoutMaster')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-md-end">
                <div class="card-header">تعديل معلومات الطالب رقم # : {{ $student->id }} - {{ $student->student_name }}
                    @include('admin.inputs.buttons.back')
                </div>
                <div class="card-body">
                    {!! Form::model($student, ['method' => 'POST','route' => ['students.update', $student->id]]) !!}
                    @method('PUT')


                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => 'اسم الطالب','input_name' => 'student_name'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.number.generic',['text' => 'رقم الهوية','input_name' => 'national_id'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.text.generic',['text' => 'مكان الولادة','input_name' => 'birth_place'])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.date.generic',['text'=> 'تاريخ الميلاد', 'input_name'=> 'birth_date','item' => $student])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.select.generic',['text' => 'جنسية الطالب','input_name' => 'nationality_id', 'data' => App\Models\nationality::nationalities()])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.checkbox.generic',['text' => 'يحتاج الي رعاية','input_name' => 'student_care','label' => 'نعم'])
                    </div>
                    <hr>

                    <div class="row mb-3">
                        @include('admin.inputs.select.generic',['text' => 'المدرسة','input_name' => 'school_id', 'data' => schools()])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.select.generic',['text' => 'النوع','input_name' => 'gender_id', 'data' => App\Models\Gender::genders()])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.select.generic',['text' => 'المرحلة','input_name' => 'grade_id', 'data' => App\Models\Grade::grades()])
                    </div>

                    <div class="row mb-3">
                        @include('admin.inputs.select.generic',['text' => 'الصف الدراسي','input_name' => 'level_id', 'data' => App\Models\Level::levels()])
                    </div>
                    <hr>
                    <div class="row mb-3">
                        @include('admin.inputs.select.generic',['text' => 'خطة الدفع','input_name' => 'plan_id', 'data' => App\Models\Plan::plans()])
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