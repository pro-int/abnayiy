<x-jet-form-section submit="updateProfileInformation">
  <x-slot name="title">
    المعلومات الشخصية
  </x-slot>

  <x-slot name="description">
    تحديث معلومات الحساب
  </x-slot>

  <x-slot name="form">

    <x-jet-action-message on="saved">
      تم تحديث معلومات الحساب بنجاح
    </x-jet-action-message>

    <!-- Profile Photo -->
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
    <div class="mb-1" x-data="{photoName: null, photoPreview: null}">
      <!-- Profile Photo File Input -->
      <input type="file" hidden wire:model="photo" x-ref="photo" x-on:change=" photoName = $refs.photo.files[0].name; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result;}; reader.readAsDataURL($refs.photo.files[0]);" />

      <!-- Current Profile Photo -->
      <div class="mt-2" x-show="! photoPreview">
        <img src="{{ $this->user->profile_photo_url }}" class="rounded-circle" height="80px" width="80px">
      </div>

      <!-- New Profile Photo Preview -->
      <div class="mt-2" x-show="photoPreview">
        <img x-bind:src="photoPreview" class="rounded-circle" width="80px" height="80px">
      </div>

      <x-jet-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
        @if ($this->user->profile_photo_path)
        تغيير الصور
        @else
        اختر صورة شخصية
        @endif
      </x-jet-secondary-button>

      @if ($this->user->profile_photo_path)
      <button type="button" class="btn btn-danger text-uppercase mt-2" wire:click="deleteProfilePhoto">
        ازالة الصورة
      </button>
      @endif

      <x-jet-input-error for="photo" class="mt-2" />
    </div>
    @endif

    <!-- row -->
    <div class="row">
      <div class="col-sm mb-1">
        <x-inputs.text.Input label="الاسم الاول" name="first_name" placeholder="الاسم الاول" wire:model.defer="state.first_name" required />

      </div>
      <div class="col-sm mb-1">
        <x-inputs.text.Input label="الاسم الاخير" name="last_name" placeholder="الاسم الاخير" wire:model.defer="state.last_name" required />
      </div>
    </div>

    <!-- row -->
    <div class="row">
      <div class="col-sm mb-1">
        <!-- Email -->
        <x-inputs.text.Input type="email" label="البريد الأليكتروني" name="email" placeholder="البريد الأليكتروني" wire:model.defer="state.email" required />

      </div>
      <div class="col-sm mb-1">
        <!-- phone -->
        <x-inputs.text.Input label="رقم الجوال" name="phone" placeholder="رقم الجوال" wire:model.defer="state.phone" required />
      </div>
    </div>
  </x-slot>

  <x-slot name="actions">
    <div class="d-flex align-items-baseline">
      <x-jet-button>
        تحديث
      </x-jet-button>
    </div>
  </x-slot>
</x-jet-form-section>