@php
$configData = Helper::applClasses();
@endphp
@extends('layouts.fullLayoutMaster')

@section('title', 'خطأ في اعدادات النظام')

@section('page-style')
<link rel="stylesheet" href="{{asset(mix('css/base/pages/page-misc.css'))}}">
@endsection

@section('content')
<!-- Not authorized-->
<div class="misc-wrapper">
  <a class="brand-logo" href="{{ route('home') }}">
   <x-ui.logo />
  </a>
  <div class="misc-inner p-2 p-sm-3">
    <div class="w-100 text-center">
      <h2 class="mb-1">خطأ في اعدادات النظام <em data-feather='alert-circle'></em></h2>
      <p class="mb-2">للاسف ! 😖 نعتذر ولكن اعدادات النظام لم تتم بالشكل الصحيح .</p>

      <h3 class="mb-2  text-danger">{{ $message }}</h3>
      @if($configData['theme'] === 'dark')
      <img class="img-fluid" src="{{asset('images/pages/error-dark.svg')}}" alt="Not authorized page" />
      @else
      <img class="img-fluid" src="{{asset('images/pages/error.svg')}}" alt="Not authorized page" />
      @endif
    </div>
    <div class="text-center">
      <a class="btn btn-primary mb-1 btn-sm-block mt-2" href="{{ url()->previous() }}">العودة للصفحة السابقة</a>
    </div>
  </div>
</div>
<!-- / Not authorized-->
</section>
<!-- maintenance end -->
@endsection
