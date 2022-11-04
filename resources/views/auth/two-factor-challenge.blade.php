@extends('layouts/fullLayoutMaster')

@section('title', '2 Factor Chanllenge')

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


          <div x-data="{ recovery: false }">
            <div class="mb-1" x-show="! recovery">
              للوصول الي حسابك رجاء ادخال الرقم السري المتغير من خلال برنامج كلمات المرور المستخدم في اعداد التحقق بخطوتين
            </div>

            <div class="mb-1" x-show="recovery">
              رجاء استخدام احد اكواد الطواري التي حصلت عليها اثناء اعداد التحقق بخطوتين لاستعادة حسابك

          </div>

            <x-jet-validation-errors class="mb-1" />

            <form method="POST" action="{{ route('two-factor.login') }}">
              @csrf

              <div class="mb-1" x-show="! recovery">
                <x-jet-label class="form-label" value="{{ __('Code') }}" />
                <x-jet-input class="{{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" inputmode="numeric"
                  name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                <x-jet-input-error for="code"></x-jet-input-error>
              </div>

              <div class="mb-1" x-show="recovery">
                <x-jet-label class="form-label" value="{{ __('Recovery Code') }}" />
                <x-jet-input class="{{ $errors->has('recovery_code') ? 'is-invalid' : '' }}" type="text"
                  name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                <x-jet-input-error for="recovery_code"></x-jet-input-error>
              </div>

              <div class="d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-outline-secondary me-1" x-show="! recovery"
                  x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus()})">{{ __('Use a recovery code') }}
                </button>

                <button type="button" class="btn btn-outline-secondary me-1" x-show="recovery"
                  x-on:click=" recovery = false; $nextTick(() => { $refs.code.focus() })">
                  {{ __('Use an authentication code') }}
                </button>

                <x-jet-button>
                 تسجيل الدخول
                </x-jet-button>
              </div>
            </form>
          </div>

          <div class="divider my-2">
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
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
