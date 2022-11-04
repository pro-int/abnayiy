@extends('layouts.contentLayoutMaster')

@section('title', 'مشرفين الطلبات')

@php
$breadcrumbs = [[['link' => route('admins.index'), 'name' => "مديرين النظام"], ['link' => route('ApplicationManagers.index'), 'name' => "مشرفين الطلبات"]],['title' => 'مشرفين الطلبات']];

@endphp

@section('content')

<x-ui.table :autoWith="false">
    <x-slot name="title">مشرفين الطلبات المسجلين بالنظام</x-slot>
    <x-slot name="cardbody">قائمة بجميع مشرفين الطلبات المسجلين في النظام</x-slot>

    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('ApplicationManagers.create') }}">
            <em data-feather='plus-circle'></em> اضافة مشرف </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
        <th scope="col">كود</th>
                <th scope="col">الاسم</th>
                <th scope="col">المسمي الوظيفي</th>
                <th scope="col">مراحل الأشراف</th>
                <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($users as $user)
        <tr>
        <th scope="row">
                    {{ $user->admin_id }}
                </th>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ $user->job_title }}</td>
                <td>{{ $user->application_manager->count() }} قسم</td>
               


            <td>
            @can('ApplicationManagers-list')
                <x-inputs.btn.view :route="route('ApplicationManagers.show',$user->admin_id)" />
                @endcan

                @can('ApplicationManagers-edit')
                <x-inputs.btn.edit :route="route('ApplicationManagers.edit',$user->admin_id)" />
                @endcan

                @can('ApplicationManagers-delete')
                <x-inputs.btn.delete :route="route('ApplicationManagers.destroy',$user->admin_id)" />
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
