@extends('layouts.contentLayoutMaster')

@section('title', 'مديرين النظام')

@php
$breadcrumbs = [[['link' => route('admins.index'), 'name' => "المديرين"]],['title' => 'مديرين النظام']];

@endphp
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
<x-forms.search route="admins.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input :required="false" icon="search" label="عنوان الاقامة" name="search" placeholder="يمكنك البحث عن اسم او رقم الهاتف او هوية ويمكن البحث بالكود عن طريق اضافة = قبل كلمة البحث" />
        </div>
    </div>
</x-forms.search>
<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">المديرين المسجلين بالنظام</x-slot>
    <x-slot name="cardbody">قائمة بجميع المديرين المسجلين في النظام و الأدوار الممنوحة لهم.</x-slot>

    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('users.create',['isAdmin'=>1]) }}">
            <em data-feather='plus-circle'></em> اضافة مدير </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الاسم</th>
            <th scope="col">الوظيفة</th>
            <th scope="col">البريد</th>
            <th scope="col">الدولة</th>
            <th scope="col">حالة الحساب</th>
            <th scope="col">الأدوار</th>
            <th scope="col">الاجراءات</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($users as $key => $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
            <td>{{ $user->admin->job_title }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->country_name }}</td>
            <td>{!! isActive((bool) $user->active) !!}</td>
            <td>
                @foreach($user->roles as $role)
                <span class="badge bg-{{$role->color}}">{{ $role->display_name }}</span>
                @endforeach
            </td>
            <td>

                @can('users-edit')
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

    @endsection
