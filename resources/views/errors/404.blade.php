@php
$configData = Helper::applClasses();
@endphp
@extends('layouts.fullLayoutMaster')

@section('title', 'صفحة غير موجود 404')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-misc.css')) }}">
@endsection
@section('content')
<!-- Error page-->
<div class="misc-wrapper">
  <a class="brand-logo" href="{{ route('home') }}">
    <x-ui.logo />
  </a>
  <div class="misc-inner p-2 p-sm-3">
      <div class="w-100 text-center">
          <h2 class="mb-1">الصفحة المطلوبة غير موجودة 🕵🏻‍♀️</h2>
          <p class="mb-2">للاسف ! 😖 نعتذر لم نعثر علي الصفحة المطلوبة .. ربما تم نقلها الي رابط اخر .. او احد العناصر المطلوبة لعرض الصقحة غير متوفر.</p>
          @if($configData['theme'] === 'dark')
          <img class="img-fluid" src="{{asset('images/pages/error-dark.svg')}}" alt="Error page" />
          @else
          <img class="img-fluid" src="{{asset('images/pages/error.svg')}}" alt="Error page" />
          @endif
        </div>
        <div class="text-center mt-2">
          <a class="btn btn-primary mb-2 btn-sm-block" href="{{url()->previous() }}">العودة</a>
        </div>
      </div>
</div>
<!-- / Error page-->
@endsection
