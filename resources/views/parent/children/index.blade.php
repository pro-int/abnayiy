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
        @if(request()->has('status'))
            <div class="alert {{request()->get('status') == 14 ? 'alert-success' : 'alert-danger'}} mb-1 rounded-0" role="alert">
                <div class="alert-body">{{request()->get('status') == 14 ? request()->get('response_message') : request()->get('error_msg')}}</div>
            </div>
        @endif
        @foreach ($guardianChildrens as $children)
            <div class="col-lg-3 col-md-3 col-12">
                <div class="card card-profile">
                    <div class="card-body">
                        <h3 class="text-success">{{ $children->student_name }} </h3>
                        <h4>{{$children->school_name}} - {{$children->id}}</h4>
                        <h5>({{ $children->level_name }}) {{ $children->gender_name }}</h5>
                        <h5>الفصل: {{$children->class_name}}</h5>
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
