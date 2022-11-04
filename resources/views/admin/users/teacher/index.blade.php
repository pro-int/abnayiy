@extends('layouts.contentLayoutMaster')

@section('title', ' ادارة المعلمين')

@php
$breadcrumbs = [[['link' => route('teachers.index'), 'name' => "المعلمين"]],['title' => 'اداةر المعلمين']];
@endphp

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
<x-forms.search route="teachers.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input :required="false" icon="search" label="عنوان الاقامة" name="search" placeholder="يمكنك البحث عن اسم او رقم جوال او هوية ويمكن البحث بالكود عن طريق اضافة = قبل كلمة البحث" />
        </div>
        <div class="col-md">
            <x-inputs.select.generic label="فئة ولي الأمر" name="category_id" data-placeholder="اختر لبفئة" :options="['all' => 'جميع الفئات'] + App\Models\Category::categories()" />
        </div>
    </div>
</x-forms.search>

<x-ui.table>
    <x-slot name="title">المعلمين المسجلين بالنظام</x-slot>
    <x-slot name="cardbody">قائمة بجميع المعلمين المسجلين في النظام .</x-slot>

    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('users.create') }}">
            <em data-feather='plus-circle'></em> اضافة معلم </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الاسم الاول</th>
            <th scope="col">الاسم الاخير</th>
            <th scope="col">البريد</th>
            <th scope="col">رقم الجوال</th>
            <th scope="col">الدولة</th>
            <th scope="col">الاجراءات</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($users as $key => $user)
        <tr>
            <td># {{ $user->id }}</td>
            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
            <td>{{ $user->admin->job_title }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->country_name }}</td>
            <td>
                @foreach($user->roles as $role)
                <span class="badge bg-{{$role->color}}">{{ $role->display_name }}</span>
                @endforeach
            </td>
            <td>

                
                
                @if(Route::has('UserNotifications'))
                @can('notifications-list')
                <x-inputs.btn.generic icon="bell" title="الأشعارات" colorClass="info" :route="route('UserNotifications',$user->id)"  />
                @endcan
                @endif

                @can('users-list')
                <x-inputs.btn.view :route="route('users.show',$user->id)" />
                @endcan

                @can('users-edit')
                <x-inputs.btn.edit :route="route('users.edit',$user->id)" />
                @endcan

                @can('teachers-delete')
                <x-inputs.btn.delete :route="route('teachers.destroy',$user->id)" />
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