@extends('layouts/fullLayoutMaster')

@section('title', 'التحقق من كلمة المرور')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-basic px-2">
  <div class="auth-inner my-2">
    <!-- Login basic -->
    <div class="card mb-0">
      <div class="card-body">
        <a href="javascript:void(0);" class="brand-logo">
          <x-ui.logo />
        </a>

        <h4 class="card-title mb-1">لحظة قبل ان نكمل 👋</h4>
        <p class="card-text mb-2">رجاء تأكيد كلمة المرور ادنا لتصل الي المحتوي المطلوب</p>

        <form class="auth-login-form mt-2" method="POST" action="{{ route('password.confirm') }}">
          @csrf
          <div class="mb-1">
            <x-inputs.password  required name="password"></x-inputs.password>

          </div>
          <x-inputs.submit class="btn btn-primary w-100">تأكيد كلمة المرور</x-inputs.submit>
        </form>

        <p class="text-center mt-2">
          @if (Route::has('password.request'))
          <a class="btn btn-link" href="{{ route('password.request') }}">
            نسيت كلمة المرور ؟

          </a>
          @endif
        </p>

      </div>
    </div>
    <!-- /Login basic -->
  </div>
</div>
@endsection