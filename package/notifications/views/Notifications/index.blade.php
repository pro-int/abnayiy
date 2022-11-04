@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('notifications.index'), 'name' => "الأشعارات"]],['title'=> ' ادارة الاشعارات']];
@endphp

@section('title', 'ادارة الاشعارات')

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('notifications.create') }}">
            <em data-feather='plus-circle'></em> اضافة اشعار </a>
    </x-slot>

    <x-slot name="title">{{ request()->target ? request()->target == 'user' ? 'اشعارات المستخدم' : 'اشعارات المدير' : 'الاشعارات' }} </x-slot>
    <x-slot name="cardbody">ادارة الأسعارات الداخلية و الخارجية</x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الوصف</th>
            <th scope="col">القسم</th>
            <th scope="col">المناسبة</th>
            <th scope="col">الحالة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
    <tr>
        @foreach($notifications as $notification)
        <th scope="row">
            {{ $notification->id }}
        </th>
        <td>{{ $notification->notification_name }}</td>
        <td>{{ $notification->section_name }}</td>
        <td>{{ $notification->event_name }}</td>
        <td>{{ $notification->active ? 'مفعل' : 'غير مفعل' }}</td>

        <td>
            @can('notifications-edit')
            <x-inputs.btn.edit :route="route('notifications.edit',$notification->id)" />
            @endcan

            @can('notifications-list')

            @if($notification->internal_allowed)
            <x-inputs.btn.generic colorClass="warning" :route="route('notifications.types.index',['notification' => $notification->id,'selected_type' => 'internal'])"> اشعارات داخلية</x-inputs.btn.edit>
            @endif

            @if($notification->external_allowed)
            <x-inputs.btn.generic colorClass="primary" :route="route('notifications.types.index',['notification' => $notification->id,'selected_type' => 'external'])"> اشعارات خارجية</x-inputs.btn.edit>
            @endif

            @endcan

            @can('notifications-delete')
            <x-inputs.btn.delete :route="route('notifications.destroy',$notification->id)" />
            @endcan

        </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

@endsection