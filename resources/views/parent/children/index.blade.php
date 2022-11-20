@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('parent.showChildrens'), 'name' => "الأبناء"],['name'=> 'جميع الأبناء']],['title'=> 'ادارة الأبناء']];
@endphp

@section('title', 'الأبناء')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection


@section('content')

    <div class="row match-height">
        @foreach ($guardianChildrens as $children)
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card card-profile">
                    <div class="card-body">
                        <h1 class="text-success">{{ $children->student_name }} </h1>
                        <h2>{{$children->school_name}} - {{$children->id}}</h2>
                        <h3>({{ $children->level_name }}) {{ $children->gender_name }}</h3>
                        <h4>الفصل: {{$children->class_name}}</h4>
                        <hr class="mb-2" />
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('parent.childrenDetails', ["id" => $children->id]) }}">
                                <button type="button" class="btn btn-primary mb-1">التفاصيل</button>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection

@section('page-script')
<script type="text/javascript">

</script>
@endsection
