@extends('layouts.fullLayoutMaster')

@section('title', 'تسجيل الدخول')

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
        <a href="/" class="brand-logo">
          <x-ui.logo />
        </a>

        <h4 class="card-title mb-1">👋 اهلا بك في ابنائي!</h4>
        <p class="card-text mb-2">رجاء استخدام رقم الجوال او البريد الأليكتروني لتسجيل الدخول</p>

        @if (session('status'))
        <div class="alert alert-success mb-1 rounded-0" role="alert">
          <div class="alert-body">
            {{ session('status') }}
          </div>
        </div>
        @endif

        <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-1">
            <x-inputs.text.Input label="الجوال/ البريد الأليكتروني" name="username" placeholder="رقم الجوال او البريد الألكيتروني" required />

          </div>

          <div class="mb-1">
            <x-inputs.password required enableForgotPassword=true name="password" label="كلمة المرور" />

          </div>
          <div class="mb-1">
            <x-inputs.checkbox name="remember">
              تذكرني
            </x-inputs.checkbox>
          </div>

          <x-inputs.submit class="btn btn-primary w-100">تسجيل الدخول</x-inputs.submit>
        </form>

        <p class="text-center mt-2">
          <span style="font-weight: bold">هل تريد تسجيل ولي امر ؟</span>
          @if (Route::has('showRegistrationPage'))
          <a href="{{ route('showRegistrationPage') }}">
            <span>تسجيل ولي امر</span>
          </a>
          @endif
        </p>
      </div>
    </div>
    <!-- /Login basic -->
  </div>
</div>
@endsection
