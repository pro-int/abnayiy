@extends('layouts/fullLayoutMaster')

@section('title', 'استعادة كلمة المرور')

@section('page-style')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
  <div class="auth-wrapper auth-basic px-2">
    <div class="auth-inner my-2">
      <!-- Forgot Password basic -->
      <div class="card mb-0">
        <div class="card-body">
          <a href="/" class="brand-logo">
         <x-ui.logo />
          </a>

          <h4 class="card-title mb-1">تسيت كلمة المرور ؟ 🔒</h4>
          <p class="card-text mb-2">ادخل رقم الجوال المسجل لدينا وسنقوم بأرسال كود استعادة كلمة المرور فورا !!</p>

            <div class="successMessage alert alert-success mb-1 rounded-0" role="alert" style="display: none">
                <div class="successMessageBody alert-body"></div>
            </div>

            <div class="errorMessage alert alert-danger mb-1 rounded-0" role="alert" style="display: none">
                <div class="errorMessageBody alert-body"></div>
                <div class="errorBody alert-body"></div>
            </div>

          <form class="auth-forgot-password-form mt-2" method="POST" action="{{ route('forgotPassword') }}">
            @csrf
            <div class="mb-1">
              <x-inputs.text.Input tpye="text" style="display: inline-block; width: 90%;" name="phone" label="رقم الجوال" />
                966+
            </div>

              <button type="button" id="submit" class="open btn btn-primary w-100">ارسال كود استعاده كلمة المرور</button>

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

                                    <input class="otp" id="opt1" type="number" inputmode="numeric" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1 >
                                    <input class="otp" id="opt2" type="number" inputmode="numeric" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1 >
                                    <input class="otp" id="opt3" type="number" inputmode="numeric" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1 >
                                    <input class="otp" id="opt4" type="number" inputmode="numeric" oninput='digitValidate(this)' onkeyup='tabChange(4)' maxlength=1 >
                                </form>
                            </div>
                            <p class="heading">هذا الكود صالح لحد أقصي 2 دقيقه</p>
                            <span id="timer" class="js-timeout">2:00</span>
                            <hr class="mt-2">
                            <p class="OTPStatus alert"></p>
                            <hr class="mt-2">
                            <div class="mb-1">
                                <x-inputs.password required name="password" label="إعاده ادخال كلمه مرور جديده" />
                            </div>
                            <hr class="mt-2">
                            <p class="passwordValidation alert"></p>
                            <hr class="mt-2">
                            <button class='btn btn-primary btn-block w-50 customBtn'>تأكيد</button>
                            <button id="resend" class='btn btn-primary btn-block w-50 resend' style="display: none;">إعاده إرسال الكود</button>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop1"></div>
            </div>

          <p class="text-center mt-2">
            @if (Route::has('showLoginPage'))
              <a href="{{ route('showLoginPage') }}"> تسجيل الدخول <em data-feather="chevron-right"></em> </a>
            @endif
          </p>
        </div>
      </div>
      <!-- /Forgot Password basic -->
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
            $.ajax({
                url: "{{route("forgotPassword")}}",
                method: 'post',
                data: {
                    "phone": $("#phone").val(),
                },
                success: function (response){
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
            var code = $("#opt1").val() + $("#opt2").val() + $("#opt3").val() + $("#opt4").val();
            var validCode = code == ''?"null":code;

            if($("#password").val().length >= 8){
                $.ajax({
                    url: "{{route("forgotPassword")}}",
                    method: 'post',
                    data: {
                        "phone": $("#phone").val(),
                        "code": validCode,
                        "password": $("#password").val()
                    },
                    success: function (response){
                        if(response.code == 402){
                            $('.OTPStatus').html(response.error + "</br>" + response.message);
                            $('.OTPStatus').removeClass("alert-success");
                            $('.OTPStatus').addClass("alert-danger");
                        }else if(response.code == 200){
                            $(".modalDialog1").css("display","none");
                            $(".successMessage").css("display","block");
                            $('.successMessageBody').text(response.message);
                            $(".errorMessage").css("display","none");
                            window.setTimeout(function(){
                                window.location.href = "/parent/login";
                            }, 3000);
                        }else if (response.code == 403){
                            $(".errorMessage").css("display","block");
                            $('.errorMessageBody').text(response.message);
                            $('.errorBody').text(response.error);
                            $(".modalDialog1").css("display","none");
                        }
                    }
                });

            }else{
                $('.passwordValidation').html("كلمة المرور يجب ان تكون 8 احرف علي الاقل");
                $('.passwordValidation').removeClass("alert-success");
                $('.passwordValidation').addClass("alert-danger");
            }
        });

    </script>
@endsection
