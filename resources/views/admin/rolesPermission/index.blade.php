@extends('layouts.contentLayoutMaster')

@section('title', 'الأدوار')

@section('vendor-style')
<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
@endsection

@php
$breadcrumbs = [[['link' => route('roles.index'), 'name' => "الأدوار"]],['title'=>'ادارة الأدوار']];

@endphp

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')

<h3>ادارة المستويات الأدارية</h3>
<p class="mb-2">
  الأدوار تلعب دور هام في النظام .. كل دور في النظام لدية مجموعة من الصلاحيات اللازمة لاتمام جميع العمليات الخاصة بالدور .
</p>

<!-- Role cards -->
<div class="row">
  @foreach ($roles as $key => $role)

  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <span>{{ $role->users->count() }} مستخدم</span>
          <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 fix-afatar">
            @foreach($role->users as $user)
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="{{ $user->id . ' : ' . $user->first_name}}" class="avatar avatar-sm pull-up">
              <img class="rounded-circle" src="{{asset($user->profile_photo_path ?? 'images/avatars/'.rand(1,12).'-small.png')}}" alt="{{$user->first_name}}" />
            </li>
            @endforeach
          </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
          <div class="role-heading">
            <h4 class="fw-bolder">{{ $role->display_name }} ({{$role->name}})</h4>
            <a href="{{ route('roles.edit',$role->id) }}" class="role-edit-modal">
              <small class="fw-bolder">تعديل</small>
            </a>
          </div>

          <a class="text-danger" data-bs-toggle="offcanvas" data-bs-target="#deleteModal" aria-controls="deleteRecord" data-bs-toggle="tooltip" data-bs-placement="right" title="حدف" data-href="{{ route('roles.destroy',$role->id) }}">
            <me data-feather="trash"></me>
          </a>

        </div>
      </div>
    </div>
  </div>
  @endforeach
  <x-ui.SideDeletePopUp />

  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="row">
        <div class="col-sm-7">
          <div class="card-body text-sm-start text-center">
            <a href="{{ route('roles.create') }}">
              <span class="btn btn-primary mb-1">اضافة دور جديد</span>
            </a>
            <p class="mb-0">دور غير مسجل ؟ سجلة الان</p>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="d-flex align-items-end justify-content-center h-100">
            <img src="{{asset('images/illustration/faq-illustrations.svg')}}" class="img-fluid mt-2" alt="Image" width="85" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Role cards -->

<!-- Striped rows start -->
<x-ui.table>
  <x-slot name="title">المديرين المسجلين بالنظام</x-slot>
  <x-slot name="cardbody">قائمة بجميع المديرين المسجلين في النظام و الأدوار الممنوحة لهم.</x-slot>

  <x-slot name="thead">
    <tr>
      <th>كود</th>
      <th>الاسم الاول</th>
      <th>الاسم الاخير</th>
      <th>البريد</th>
      <th>رقم الجوال</th>
      <th>الدولة</th>
      <th>الاجراءات المتاحة</th>
    </tr>
  </x-slot>

  <x-slot name="tbody">
    @foreach ($users as $key => $user)
    <tr>
      <td>#{{ $user->id }}</td>
      <td>{{ $user->first_name }}</td>
      <td>{{ $user->last_name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->phone }}</td>
      <td>{{ $user->country_name }}</td>

      <td>
        <x-inputs.btn.view :route="route('users.show',$user->id)" />

        @can('admin-edit')
        <x-inputs.btn.edit :route="route('users.edit',$user->id)" />
        @endcan

        @can('admin-delete')
        <x-inputs.btn.delete :route="route('admins.destroy',$user->id)" />
        @endcan
      </td>
    </tr>
    @endforeach
    </tbody>
  </x-slot>

  <x-slot name="pagination">
    {{ $users->appends(request()->except('page'))->links() }}
  </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<x-ui.SideDeletePopUp modelId="deleteRec" :route="route('admins.destroy',$user->id)">
  <x-slot name="title">
    تأكيد حذف الدور ؟
  </x-slot>
  سيتم حذف الدور المحدد وجميع الصلاحيات المرتبطة بة
</x-ui.SidePopUp>
<!-- Striped rows end -->
@endsection

@section('vendor-script')
<!-- Vendor js files -->
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection

@section('page-script')
<!-- Page js files -->
<!-- <script src="{{ asset(mix('js/scripts/pages/modal-add-role.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/pages/app-access-roles.js')) }}"></script> -->
@endsection