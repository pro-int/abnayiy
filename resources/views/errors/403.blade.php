@php
$configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'وصول غير مسموح')

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
      <h2 class="mb-1">وصول غير مسموح بة 🔐</h2>
      <p class="mb-2">نعتذر انت تحاول الوصول الي صفحة ليست ضمن حدود الصلاحيات الممنوحة لك .. رجاء التواصل مع مدير النظام لطلب صلاحية الوصول اولا .. قم حاول مرة اخري</p>
      <a class="btn btn-primary mb-1 btn-sm-block" href="{{  url()->previous() }}">العودة للصفحة السابقة</a>
      @if($configData['theme'] === 'dark')
      <img class="img-fluid" src="{{asset('images/pages/not-authorized-dark.svg')}}" alt="Not authorized page" />
      @else
      <img class="img-fluid" src="{{asset('images/pages/not-authorized.svg')}}" alt="Not authorized page" />
      @endif
    </div>
  </div>
</div>
<!-- / Not authorized-->
</section>
<!-- maintenance end -->
@endsection
