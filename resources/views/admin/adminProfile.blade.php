@extends('layouts.contentLayoutMaster')

@section('content')

<div class="contanier_form">
    <img style="
              position: absolute;
              top: -30px;
              left: 50%;
              transform: translateX(-50%);
              width: 60px;
              height: 60px;
            " src="{{ asset('/assets/profile.png') }}" alt="profile" width="40" height="40" class="profile-image" />
    <form class="row g-3">
        <div class="form-floating mb-3 col-md-6">
            <input type="text" class="form-control" id="floatingInput" value="{{ $admin->first_name }}" readonly/>
            <label for="floatingInput">الاسم الاول </label>
        </div>

        <div class="form-floating col-md-6">
            <input type="text" class="form-control" id="floatingInput" value="{{ $admin->last_name }}" readonly/>
            <label for="floatingInput">اسم العائلة</label>
        </div>

        <div class="form-floating mb-3 col-md-6">
            <input type="email" class="form-control" id="floatingInput" value="{{ $admin->email }}" readonly/>
            <label for="floatingInput1">البريد الالكتروني </label>
        </div>
        <div class="form-floating col-md-6">
            <input type="text" class="form-control" id="floatingInput2" value="{{ $admin->phone }}" readonly />
            <label for="floatingInput2">التليفون</label>
        </div>

    </form>
</div>

@endsection