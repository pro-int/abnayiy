@extends('layouts.contentLayoutMaster')

@section('title', 'مستخدمين النظام')

@php
$breadcrumbs = [[['link' => route('users.index'), 'name' => "المستخدمين"]],['title' => 'مستخدمين النظام']];

@endphp
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
<x-forms.search route="users.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input :required="false" icon="search" label="كلمات البحث" name="search" placeholder="يمكنك البحث عن اسم او رقم الهاتف او هوية ويمكن البحث بالكود عن طريق اضافة = قبل كلمة البحث" />
        </div>
    </div>
</x-forms.search>
<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">المستخدمين المسجلين بالنظام</x-slot>
    <x-slot name="cardbody">قائمة بجميع المستخمين المسجلين في النظام  ({!! sprintf('معروض المستخدمين من <span class="text-danger">%s</span> الي <span class="text-danger">%s</span> - من اجمالي <span class="text-danger">%s</span> مستخدم', $users->firstItem() ,$users->lastItem(), $users->total()) !!})</x-slot>

    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('users.create') }}">
            <em data-feather='plus-circle'></em> اضافة حساب جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الاسم الأول</th>
            <th scope="col">الاسم الاخير</th>
            <th scope="col">البريد</th>
            <th scope="col">حساب مدير</th>
            <th scope="col">حساب ولي امر</th>
            <th scope="col">حساب معلم</th>
            <th scope="col">الاجراءات</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{!! isActive((bool) $user->admin && $user->admin->active) !!}</td>
            <td>{!! isActive((bool) $user->guardian && $user->guardian->active) !!}</td>
            <td>{!! isActive((bool) $user->teacher && $user->teacher->active) !!}</td>

            <td>

                @if(Route::has('UserNotifications'))
                @can('notifications-list')
                <x-inputs.btn.generic icon="bell" title="الأشعارات" colorClass="info btn-icon" :route="route('UserNotifications',$user->id)" />
                @endcan
                @endif

                @can('users-list')
                <x-inputs.btn.view :route="route('users.show',$user->id)" />
                @endcan
                
                @can('users-edit')
                <x-inputs.btn.edit :route="route('users.edit',$user->id)" />
                @endcan
                
                @can('users-delete')
                <x-inputs.btn.delete :route="route('users.destroy',$user->id)" />
                @endcan
             
                @if(!$user->admin)
                @can('users-create')
                <button type="button" class="btn btn-icon round btn-sm btn-outline-warning" data-bs-toggle="offcanvas" data-bs-target="#AssignAdminModal" aria-controls="deleteRole" data-bs-user_id="{{ $user->id }}" data-bs-user_name="{{ $user->first_name }}" data-bs-toggle="tooltip" data-bs-placement="right" title="اضافة مدير">
                    <me data-feather="user-plus"></me>
                </button>
                @endcan
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