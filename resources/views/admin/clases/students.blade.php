@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('home'), 'name' => "الرئيسية"],['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year), 'name' => "$year->year_name"],['link' => route('years.classrooms.index',$year), 'name' => "الفصول الدراسية"],['link' => route('years.classrooms.students.view',[$year, $classroom]),'name' => "$classroom->class_name"]],['title'=> "الفصول الدراسية"]];
@endphp

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/dragula.min.css')) }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-drag-drop.css')) }}">
@endsection

@section('title', 'ادارة الفصول الدراسية')


@section('content')

<!-- Sortable lists section start -->
<section id="sortable-lists">
    <div class="row">
        <!-- Multiple List Group starts -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-primary ">توزيع الطلاب علي الفصول <span class="text-danger">{{ $classroom->class_name .' - '. $year->year_name }}</span></h4>
                    <x-inputs.link route="years.classrooms.index" :params="$year">عودة</x-inputs.link>

                </div>
                <div class="card-body">
                    <p class="card-text text-worrning">لتسجيل الطالب في الفصل الدراسي اسحب الطالب في جهة الفصل و العكس</p>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            {!! Form::open(['route' => ['years.classrooms.students.store',[$year->id,$classroom->id]],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}
                            <h4 class="my-1">طلاب مقيدين في الفصل  (<span class="text-danger" id="studentCount">{{ $students->where('class_id', $classroom->id)->count() }}</span>)</h4>
                            <ul class="list-group list-group-flush" id="multiple-list-group-a">
                                @foreach($students->where('class_id', $classroom->id) as $student)
                                <li class="list-group-item draggable">
                                    <div class="d-flex">
                                        <input type="hidden" name="students[]" class="studentsInputs" value="{{ $student->student_id }}">
                                        <div class="avatar-wrapper">
                                            <div class="avatar bg-light-info me-1"><span class="avatar-content">{{ $student->getAvatar() }}</span></div>
                                        </div>
                                        <div class="more-info">
                                            <h5 class="text-primary">{{ $student->student_name }}</h5>
                                            <span>{!! sprintf('رقم الهوية : %s - تاريخ الميلاد : %s - الجنسيية: %s - يحتاج الي رعاية : %s',$student->national_id ,$student->birth_date, $student->nationality_name, $student->student_care ? 'نعم' : 'لا') !!}</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <div class="col-12 text-center mt-2">
                                <x-inputs.submit>تحديث قائمة الطلاب </x-inputs.submit>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <h4 class="my-1">طلاب غير مقيدين في فصل (<span class="text-danger" id="studentNotInClassCount">{{ $students->whereNull('class_id')->count() }}</span>)</h4>
                            <ul class="list-group list-group-flush" id="multiple-list-group-b">
                                @foreach($students->whereNull('class_id') as $student)
                                <li class="list-group-item draggable">
                                    <div class="d-flex">
                                        <input type="hidden" name="students[]" value="{{ $student->student_id }}">
                                        <div class="avatar-wrapper">
                                            <div class="avatar bg-light-info me-1"><span class="avatar-content">{{ $student->getAvatar() }}</span></div>
                                        </div>
                                        <div class="more-info">
                                            <h5 class="text-primary">{{ $student->student_name }}</h5>
                                            <span>{!! sprintf('رقم الهوية : %s - تاريخ الميلاد : %s - الجنسيية: %s - يحتاج الي رعاية : %s',$student->national_id ,$student->birth_date, $student->nationality_name, $student->student_care ? 'نعم' : 'لا') !!}</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-2">

                        <x-inputs.link route="years.classrooms.index" :params="$year">عودة</x-inputs.link>
                    </div>
                </div>
            </div>
        </div>
        <!-- Multiple List Group ends -->
    </div>
</section>
<!-- Sortable lists section end -->

@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/extensions/dragula.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/extensions/ext-component-drag-drop.js')) }}"></script>

@endsection