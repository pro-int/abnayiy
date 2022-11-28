@extends('layouts.fullLayoutMaster')

@section('title', 'تسجيل الدخول')

@section('page-style')
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        @if (session()->has('userRegistrationSuccessMessage'))
        <div class="sessionMessage alert alert-success mb-1 rounded-0" role="alert">
          <div class="alert-body">
            {{ session()->get('userRegistrationSuccessMessage') }}
          </div>
        </div>
        @endif

          <div class="errorMessage alert alert-danger mb-1 rounded-0" role="alert" style="display: none">
              <div class="errorMessageBody alert-body"></div>
              <div class="errorBody alert-body"></div>
          </div>

        <form class="auth-login-form mt-2" method="POST" action="{{ route('userLogin') }}">
          @csrf
          <div class="mb-1">
            <x-inputs.text.Input style="display: inline-block; width: 90%;" label="الجوال/ البريد الأليكتروني" name="phone" placeholder="رقم الجوال او البريد الألكيتروني" required />
            966+
          </div>
            <div style="direction: ltr; float: left;">
                <a href="{{ route("showForgotPasswordPage") }}">
                    <small>نسيت كلمة المرور ؟</small>
                </a>
            </div>

          <div class="mb-1">
            <x-inputs.password required name="password" label="كلمة المرور" />

          </div>
          <div class="mb-1">
            <x-inputs.checkbox name="remember">
              تذكرني
            </x-inputs.checkbox>
          </div>

            <button type="button" id="submit" class="open btn btn-primary w-100">تسجيل الدخول</button>
        </form>
          <div id="openModal1" class="modalDialog1">
              <div  class="overlay">
                  <a href="" title="Close" class="close1">X</a>
                  <div class="modal-head1">
                      <div class="modal-header1">
                          <h2 class="modal-title1" id="purchaseLabel">ادخل رمز التاكيد</h2>
                      </div>
                      <div class="modal-body1">
                          <p>برجاء ادخال الرقم من اليسار الي اليمين</p>
                          <div class="middle-section1">
                              <form id="otpVerification" method="POST" class="mt-5">

                                  <input class="otp" id="opt1" type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1 >
                                  <input class="otp" id="opt2" type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1 >
                                  <input class="otp" id="opt3" type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1 >
                                  <input class="otp" id="opt4" type="text" oninput='digitValidate(this)' onkeyup='tabChange(4)' maxlength=1 >
                              </form>
                          </div>
                          <p class="heading">هذا الكود صالح لحد أقصي 2 دقيقه</p>
                          <span id="timer" class="js-timeout">2:00</span>
                          <hr class="mt-2">
                          <p class="OTPStatus alert"></p>
                          <hr class="mt-2">
                          <button class='btn btn-primary btn-block w-50 customBtn'>تأكيد</button>
                          <button id="resend" class='btn btn-primary btn-block w-50 resend' style="display: none;">إعاده إرسال الكود</button>
                      </div>
                  </div>
              </div>
              <div class="modal-backdrop1"></div>
          </div>

        <p class="text-center mt-2">
          <span>ليس لديك حساب ؟</span>
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

@section('page-script')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var interval;
    function countdown() {
        clearInterval(interval);
        interval = setInterval( function() {
            var timer = $('.js-timeout').html();
            timer = timer.split(':');
            var minutes = timer[0];
            var seconds = timer[1];
            seconds -= 1;
            if (minutes < 0) return;
            else if (seconds < 0 && minutes != 0) {
                minutes -= 1;
                seconds = 59;
            }
            else if (seconds < 10 && length.seconds != 2) seconds = '0' + seconds;

            $('.js-timeout').html(minutes + ':' + seconds);

            if (minutes == 0 && seconds == 0){
                clearInterval(interval);
                $('.customBtn').css("display","none");
                $('.resend').css("display","inline-block");
                $("#opt1").val('');
                $("#opt2").val('');
                $("#opt3").val('');
                $("#opt4").val('');
            };
        }, 1000);
    }

    $(".open, .resend").click(function (event) {
        $(".sessionMessage").css("display","none");
        $.ajax({
            url: "/parent/userLogin",
            method: 'post',
            data: {
                "phone": $("#phone").val(),
                "password": $("#password").val(),
            },
            success: function (response){
                console.log(response);
                if(response.code == 401){
                    $(".errorMessage").css("display","block");
                    $('.errorMessageBody').text(response.message);
                    $('.errorBody').text(response.error);
                    $(".modalDialog1").css("display","none");
                }else if(response.code == 200){
                    $(".modalDialog1").css("display","block");
                    $('.js-timeout').html("2:00");
                    countdown();
                    $('.OTPStatus').text(response.message);
                    $('.OTPStatus').removeClass("alert-success");
                    $('.OTPStatus').removeClass("alert-danger");
                    $('.OTPStatus').addClass("alert-success");
                    if(event.target.id == "resend"){
                        $('.resend').css("display","none");
                        $('.customBtn').css("display","inline-block");
                    }
                }
            }
        });
    });
    $(".close1").on('click',function(){
        $(".modalDialog1").css("display","none");
    });
    $(".modal-backdrop1").click(function () {
        $(".modalDialog1").css("display","none");
    });


    let digitValidate = function digitValidate(ele){
        ele.value = ele.value.replace(/[^0-9]/g,'');
    }

    var tabChange = function(val){
        let ele = document.querySelectorAll('input.otp');
        if(ele[val-1].value != ''){
            if (val == 4){
                return;
            }
            ele[val].focus()
        }else if(ele[val-1].value == ''){
            ele[val-2].focus()
        }
    }

    $(".customBtn").on('click',function(){
        $.ajax({
            url: "/parent/userLogin",
            method: 'post',
            data: {
                "phone": $("#phone").val(),
                "password": $("#password").val(),
                "code": $("#opt1").val() + $("#opt2").val() + $("#opt3").val() + $("#opt4").val()
            },
            success: function (response){
                if(response.code == 402){
                    $('.OTPStatus').html(response.error + "</br>" + response.message);
                    $('.OTPStatus').removeClass("alert-success");
                    $('.OTPStatus').addClass("alert-danger");
                }else if(response.code == 200){
                    window.location.href = '/';
                }else if (response.code == 403){
                    $(".errorMessage").css("display","block");
                    $('.errorMessageBody').text(response.message);
                    $('.errorBody').text(response.error);
                    $(".modalDialog1").css("display","none");
                }
            }
        });
    });

</script>
@endsection
