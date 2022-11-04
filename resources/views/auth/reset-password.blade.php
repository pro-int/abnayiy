@extends('layouts/fullLayoutMaster')

@section('title', 'اعادة تعيين كلمة المرور')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
  <div class="auth-wrapper auth-basic px-2">
    <div class="auth-inner my-2">
      <!-- Reset Password basic -->
      <div class="card mb-0">
        <div class="card-body">
          <a href="javascript:void(0);" class="brand-logo">
          <x-ui.logo />
        </a>

          <h4 class="card-title mb-1">استعادة  كلمة المرور 🔒</h4>
          <p class="card-text mb-2">رجاء اختيار كلمة مرور مختلفة عن كلمة المرور المستخدمة حاليا</p>

          <form class="auth-reset-password-form mt-2" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-1">
              <x-inputs.text.Input type="email" label="البريد الأليكتروني" name="email" autofocus>
             
            </div>

            <div class="mb-1">
            <x-inputs.password required name="password" label="كلمة المرور" />
            
          </div>
          <div class="mb-1">
              <x-inputs.password required name="password_confirmation" label="تاكيد كلمة المرور" />
             
            </div>
            <x-inputs.submit class="btn btn-primary w-100">
              تغيير كلمة المرور
            </x-inputs.submit>
          </form>

          <p class="text-center mt-2">
            @if (Route::has('login'))
              <a href="{{ route('login') }}">
                <em data-feather="chevron-left"></em> العود و تسجيل الدخول
              </a>
            @endif
          </p>
        </div>
      </div>
      <!-- /Reset Password basic -->
    </div>
  </div>
@endsection
