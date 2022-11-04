@extends('layouts/fullLayoutMaster')

@section('title', 'استعادة كلمة المرور')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
  <div class="auth-wrapper auth-basic px-2">
    <div class="auth-inner my-2">
      <!-- Forgot Password basic -->
      <div class="card mb-0">
        <div class="card-body">
          <a href="javascript:void(0);" class="brand-logo">
         <x-ui.logo />
          </a>

          <h4 class="card-title mb-1">تسيت كلمة المرور ؟ 🔒</h4>
          <p class="card-text mb-2">ادخل البريد الأليكتروني المسجل لدينا وسنقوم بأرسال رابط استعادة كلمة المرور فورا !!</p>

          @if (session('status'))
            <div class="mb-1 text-success">
              {{ session('status') }}
            </div>
          @endif

          <form class="auth-forgot-password-form mt-2" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-1">
              <x-inputs.text.Input tpye="email" name="email" label="البريد الأليكتروني" />
            </div>
            <x-inputs.submit class="btn btn-primary w-100">
              ارسال رابط اسعادة كلمة المرور
            </x-inputs.submit>
          </form>

          <p class="text-center mt-2">
            @if (Route::has('login'))
              <a href="{{ route('login') }}"> تسجيل الدخول <em data-feather="chevron-right"></em> </a>
            @endif
          </p>
        </div>
      </div>
      <!-- /Forgot Password basic -->
    </div>
  </div>
@endsection
