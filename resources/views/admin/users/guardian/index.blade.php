@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('guardians.index'), 'name' => "اولياء الأمور"]],['title' => 'ادارة اولياء الامور']];
@endphp

@section('title', 'اولياء الأمور')

@section('vendor-style')
<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')

<x-forms.search route="guardians.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input :required="false" icon="search" label="عنوان الاقامة" name="search" placeholder="يمكنك البحث عن اسم او رقم جوال او هوية ويمكن البحث بالكود عن طريق اضافة = قبل كلمة البحث" />
        </div>
        <div class="col-md">
            <x-inputs.select.generic label="فئة ولي الأمر" name="category_id" data-placeholder="اختر لبفئة" :options="['all' => 'جميع الفئات'] + App\Models\Category::categories()" />
        </div>
    </div>
</x-forms.search>

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">اوليا الأمور المسجلين بالنظام</x-slot>
    <x-slot name="cardbody">قائمة بجميع اوليا الأمور المسجلين في النظام.</x-slot>

    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('users.create') }}">
            <em data-feather='plus-circle'></em> اضافة ولي امر </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الاسم</th>
            <th scope="col">البريد</th>
            <th scope="col">رقم الجوال</th>
            <th scope="col">الفئة</th>
            <th scope="col">الدولة</th>
            <th scope="col">الأبناء</th>
            <th scope="col">تاريخ النقاط</th>
            <th scope="col">الرصيد</th>
            <th scope="col">مزامنة odoo</th>
            <th scope="col">اخطاء مزامنة odoo</th>
            <th scope="col">الاجراءات</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->guardian_id }}</td>
            <td>{{ $user->guardian_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td><span class="badge bg-{{$user->color}}">{{ $user->category_name }}</span></td>
            <td>{{ $user->country_name }}</td>
            <td>
                @if($user->students->count())
                <x-inputs.btn.generic icon="users" colorClass="warning" :route="route('students.index',['search' => $user->phone])">{{ $user->students->count() . ' طالب'}}</x-inputs.btn.generic>
                @endif
            </td>
            <td>
                <x-inputs.btn.generic icon="clock" colorClass="secondary" :route="route('guardians.points.index',$user->guardian_id)" />
            </td>
            <td>{!! $user->getbalance() !!}</td>
            <td>@if($user->odoo_sync_status) <abbr title="{{ $user->odoo_sync_status }}"><em data-feather='check-circle' class="text-success"></em></abbr>@else <em class="text-danger" data-feather='x-circle'></em> @endif</td>
            <td>{{ !$user->odoo_sync_status? $user->odoo_message : 'لا يوجد'}}</td>
            <td>

                @can('accuonts-list')
                <x-inputs.btn.generic icon="credit-card" title="المحفظة" colorClass="primary btn-icon" :route="route('guardians.wallets.index',$user->guardian_id)" />
                @endcan

                @if(Route::has('UserNotifications'))
                @can('notifications-list')
                <x-inputs.btn.generic icon="bell" title="الأشعارات" colorClass="info btn-icon" :route="route('UserNotifications',$user->guardian_id)" />
                @endcan
                @endif

                @can('users-list')
                <x-inputs.btn.view :route="route('users.show',$user->guardian_id)" />
                @endcan

                @can('users-edit')
                <x-inputs.btn.edit :route="route('users.edit',$user->guardian_id)" />
                @endcan

                @can('admin-delete')
                <x-inputs.btn.delete :route="route('guardians.destroy',$user->guardian_id)" />
                @endcan


                @if(!$user->admin)
                @can('users-create')

                <button type="button" class="btn btn-icon round btn-sm btn-outline-warning" data-bs-toggle="offcanvas" data-bs-target="#AssignAdminModal" aria-controls="deleteRole" data-bs-user_id="{{ $user->guardian_id }}" data-bs-user_name="{{ $user->first_name }}" data-bs-toggle="tooltip" data-bs-placement="right" title="اضافة مدير">
                    <me data-feather="user-plus"></me>
                </button>

                @endcan
                @endif

                @if($user->odoo_sync_status == 0)
                    <x-inputs.btn.generic colorClass="primary btn-icon round" icon="repeat" :route="route('users.resendToOdoo', ['id' => $user->guardian_id])" title="مزامنة مع odoo" />
                @endif
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
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-modal')
<div class="offcanvas offcanvas-width-30 offcanvas-start" tabindex="-1" id="AssignAdminModal" aria-labelledby="AssignAdminModalLabel">
    <div class="offcanvas-header">
        <h5 id="AssignAdminModalLabel" class="offcanvas-title">اضافة ولي امر كمدير</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <div class="text-center mb-2 text-danger">
            <me data-feather="user-plus" class="font-large-3"></me>
        </div>
        <h3 class="text-center text-dark" id="slot">
            جاري تحميل المعلومات
        </h3>
        {!! Form::open(['route' => 'admins.assignAdminRole','method'=>'POST' , 'onsubmit' => 'showLoader()']) !!}

        <input type="hidden" name="user_id" id="user_id">

        <div class="col-lg mb-1">
            <x-inputs.text.Input label="المسمي الوظيفي" icon="user" name="job_title" placeholder="ادخل المسمي الوظيفي" data-msg="ادخل المسمي الوظيفي بشكل صحيح" />
        </div>

        <div class="col-lg mb-1">
            <x-inputs.select.generic label="الدور الأداري" name="roles[]" data-placeholder="اختر الدور الأداري" data-msg="رجاء اختيار الدور الأجاري" :options="Spatie\Permission\Models\Role::pluck('display_name', 'name')->toArray()" multiple />
        </div>


        <button type="submit" class="btn btn-danger mb-1 d-grid w-100">تأكيد</button>
        {!! Form::close() !!}
        <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
            تراجع
        </button>
    </div>
</div>

<x-ui.SideDeletePopUp />

@endsection


@section('page-script')
<script>
    var AssignAdminModal = document.getElementById('AssignAdminModal')
    AssignAdminModal.addEventListener('show.bs.offcanvas', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget

        // Extract info from data-bs-* attributes
        var user_id = button.getAttribute('data-bs-user_id')
        var user_name = button.getAttribute('data-bs-user_name')

        // Update the modal's content.
        var modalTitle = AssignAdminModal.querySelector('#slot')
        var user_id_input = AssignAdminModal.querySelector('#AssignAdminModal #user_id')

        modalTitle.textContent = 'تعيين ولي الامر : ' + user_name + ' #(' + user_id + ') - كمدير'
        user_id_input.value = user_id
    })
</script>
@endsection
