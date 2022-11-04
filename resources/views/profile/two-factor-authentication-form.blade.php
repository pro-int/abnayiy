<x-jet-action-section>
  <x-slot name="title">
    خاصية التحقق بخطوتين
  </x-slot>

  <x-slot name="description">
    اضف ميزة امان لحسابك بأضافة ميزة التحقق بخطوتين واجعل حسابك اكثر امانا
  </x-slot>

  <x-slot name="content">
    <h6 class="fw-bolder">
      @if ($this->enabled)
        @if ($showingConfirmation)
          <span class="text-warning fw-bolder">انت حاليا تقوم بتفعيل خاصية التحقق بخطوتين</span>
        @else
          <span class="text-success fw-bolder">تم تفعيل خاصية التحقق بخطوتين .. عمل رائع</span>
        @endif
      @else
      <span class="text-danger fw-bolder"> خاصية التحقق بخطوتين غير مفعلة علي حسابك</span>
      @endif
    </h6>

    <p class="card-text">
      بعد تفعيل خاصية التحقق بخطوتين , ستكون عملية تسجيل الدخول اكثر امان ,حيث سيتطلب منك ادخال كلمة مرور عشواية في كل مرة تقوم فيها بتسجيل الدخول الي النظام .. يمكنك استخدام برنامج Google Authenticator
    </p>

    @if ($this->enabled)
      @if ($showingQrCode)
        <p class="card-text mt-2">
          @if ($showingConfirmation)
          قم بمسح الرمز التالي من خلال هاتفك الجوال .. مستخدما برنامج كلمات المرور العشوائية المستخدم ليدك او استخدم برنامج Google Authenticator
           
          @else
          خاصية التحقق بخطوتين مفعلة علي حسابك , رجاء مسح الكود التالي بأستخدام هاتفك الجوال
          @endif
        </p>

        <div class="mt-2">
          {!! $this->user->twoFactorQrCodeSvg() !!}
        </div>

        <div class="mt-4">
            <p class="font-semibold">
              رموز الأسترداد : {{ decrypt($this->user->two_factor_secret) }}
            </p>
        </div>

        @if ($showingConfirmation)
          <div class="mt-2">
            <x-jet-label for="code" value="كود التحقق" />
            <x-jet-input id="code" class="d-block mt-3 w-100" type="text" inputmode="numeric" name="code" autofocus autocomplete="one-time-code"
                wire:model.defer="code"
                wire:keydown.enter="confirmTwoFactorAuthentication" />
            <x-jet-input-error for="code" class="mt-3" />
          </div>
        @endif
      @endif

      @if ($showingRecoveryCodes)
        <p class="card-text mt-2">
          احتفظ بالرموز التالية في مكان امن .. حيث في حالة فقدان الجوال و مسح برنامج التحقق من هاتفك .. ستتمكن من الوصول الي حسابك بأستخام الرموز التالية
        </p>

        <div class="bg-light rounded p-2">
          @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
            <div>{{ $code }}</div>
          @endforeach
        </div>
      @endif
    @endif

    <div class="mt-2">
      @if (!$this->enabled)
        <x-jet-confirms-password wire:then="enableTwoFactorAuthentication">
          <x-jet-button type="button" wire:loading.attr="disabled">
            تفعيل التحقق بخطوتين
          </x-jet-button>
        </x-jet-confirms-password>
      @else
        @if ($showingRecoveryCodes)
          <x-jet-confirms-password wire:then="regenerateRecoveryCodes">
            <x-jet-secondary-button class="me-1">
             اعادة توليد الرمز
            </x-jet-secondary-button>
          </x-jet-confirms-password>
        @elseif ($showingConfirmation)
          <x-jet-confirms-password wire:then="confirmTwoFactorAuthentication">
            <x-jet-button type="button" wire:loading.attr="disabled">
              تأكيد
          </x-jet-button>
          </x-jet-confirms-password>
        @else
          <x-jet-confirms-password wire:then="showRecoveryCodes">
            <x-jet-secondary-button class="me-1">
              اظهر رموز الأسترادا
            </x-jet-secondary-button>
          </x-jet-confirms-password>
        @endif

        <x-jet-confirms-password wire:then="disableTwoFactorAuthentication">
          <x-jet-danger-button wire:loading.attr="disabled">
            الغاء تفعيل
          </x-jet-danger-button>
        </x-jet-confirms-password>
      @endif
    </div>
  </x-slot>
</x-jet-action-section>
