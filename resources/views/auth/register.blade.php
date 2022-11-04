@extends('layouts.fullLayoutMaster')

@section('title', 'تسجيل مدير جديد')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-basic px-2">
  <div class="auth-inner my-2">
    <!-- Register Basic -->
    <div class="card mb-0">
      <div class="card-body">
        <a href="/" class="brand-logo">
          <x-ui.logo />
        </a>

        <h4 class="card-title mb-1">اهلا بك في ابنائي! 👋</h4>
        <p class="card-text mb-2">نظام ادارة المدارس الأكثر تطورا ..</p>


        <form class="auth-register-form mt-2" method="POST" action="{{ route('register') }}">
          @csrf
          <div class="row">
            <div class="col-4 mb-1">
              <x-inputs.text.Input label="الاسم الاول" name="first_name" placeholder="الاسم الاول" required />

            </div>
            <div class="col-8 mb-1">
              <x-inputs.text.Input label="الاسم الاخير" name="last_name" placeholder="الاسم الاخير" required />
            </div>
          </div>
            <div class="mb-1">
              <x-inputs.text.Input type="email" label="البريد الأليكتروني" name="email" placeholder="البريد الأليكتروني" required />

            </div>

            <div class="mb-1">
              <x-inputs.text.Input label="ادخل رقم الجوال" name="phone"  placeholder="رقم الجوال" required />
            </div>

            <div class="row">
              <div class="col-6 mb-1">
                <x-inputs.password required name="password" label="كلمة المرور" />
              </div>
              
              <div class="col-6 mb-1">
                <x-inputs.password required name="password_confirmation" label="تاكيد كلمة المرور" />
              </div>
            </div>

            <x-inputs.submit class="btn btn-primary w-100">تسجيل حساب جديد</x-inputs.submit>
        </form>

        @if (Route::has('login'))
        <p class="text-center mt-2">
          <span>هل لديك حساب بالفعل ؟</span>
          <a href="{{ route('login') }}">
            <span>تسجيل الدخول</span>
          </a>
        </p>
        @endif

        <!-- <div class="divider my-2">
            <div class="divider-text">or</div>
          </div>

          <div class="auth-footer-btn d-flex justify-content-center">
            <a href="#" class="btn btn-facebook">
              <i data-feather="facebook"></i>
            </a>
            <a href="#" class="btn btn-twitter white">
              <i data-feather="twitter"></i>
            </a>
            <a href="#" class="btn btn-google">
              <i data-feather="mail"></i>
            </a>
            <a href="#" class="btn btn-github">
              <i data-feather="github"></i>
            </a>
          </div> -->
      </div>
    </div>
    <!-- /Register basic -->
  </div>
</div>
@endsection