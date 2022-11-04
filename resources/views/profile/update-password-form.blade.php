<x-jet-form-section submit="updatePassword">
  <x-slot name="title">
    كلمة المرور
  </x-slot>

  <x-slot name="description">
    تأكد من استخدام كلمة مرور قوية .. لتبقي حسابك بعيد عند المتطفلين
  </x-slot>


  <x-slot name="form">
    <div class="mb-1">
      <x-inputs.password required label="كلمة المرور الحالية" name="current_password" wire:model.defer="state.current_password" />
    </div>

    <div class="row">

      <div class="col-sm mb-1">
        <x-inputs.password required label="كلمة المرور الجديدة" name="password" autocomplete="new-password" wire:model.defer="state.password" />
      </div>

      <div class="col-sm mb-1">
        <x-inputs.password required label="نأكبد كلمة المرور الجديدة" name="password_confirmation" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
      </div>
    </div>
  </x-slot>

  <x-slot name="actions">
    <x-jet-button>
      تغيير كلمة المرور
    </x-jet-button>
  </x-slot>
</x-jet-form-section>