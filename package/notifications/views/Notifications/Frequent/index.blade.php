@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('home'), 'name' => "الرئيسية"],['link' => route('notifications.index'), 'name' => "الاشعارات"], ['link' => route('notifications.types.index',[$notification, 'selected_type' => $notification->type]), 'name' => "$notification->notification_name"], ['link' => route('notifications.types.frequent.index',[$notification,request('type')]), 'name' => "ادارة التكرار"]],['title'=> ' ادارة التكرار']];
@endphp

@section('title', 'ادارة التكرار')

@section('content')

<!-- Striped rows start -->
<x-ui.table>

    <x-slot name="button">
        @can('notifications-create')
        <a class="btn btn-primary mb-1" href="{{route('notifications.types.frequent.create',['notification' => $notification->id,'type' => request('type')]) }}">
            <em data-feather='plus-circle'></em> اضافة </a>
        @endcan
    </x-slot>

    <x-slot name="title">{{ sprintf('اعدادات التكرار للأشعار %s  #(%s) - قبل %s - %s - %s',($notification->type == 'external' ? 'الخارجي' : 'الداخلي'), $notification->id, $notification->notification_name , $notification->section_name ,$notification->event_name) }} </x-slot>
    <x-slot name="cardbody">قبل <span class="text-danger"> {{ $notification->notification_name }}</span> </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الشرط</th>
            <th scope="col">المحتوي</th>
            <th scope="col">التوقيت</th>
            <th scope="col">الحالة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach($frequent_notifications->where('condition_type','before') as $frequent)
            <th scope="row">
                {{ $frequent->id }}
            </th>
            <td>{{ $frequent->condition_type == 'after' ? 'بعد الحدث' : 'قبل الحدث' }}</td>
            <td><a href="{{ route('contents.edit',$frequent->content_id) }}">{{ $frequent->content_name }}</a></td>
            <td>{{ $frequent->interval }} ساعة</td>
            <td>{{ $frequent->active ? 'مفعل' : 'غير مفعل' }}</td>
            <td>
                @can('notifications-edit')
                <x-inputs.btn.edit :route="route('notifications.types.frequent.edit', ['notification' => $notification->id, 'type' => request()->type,'frequent' =>$frequent->id])" />
                @endcan

                @can('notifications-delete')
                <x-inputs.btn.delete colorClass="warning" :route="route('notifications.types.frequent.destroy',['notification' => $notification->id, 'type' => $frequent->notification_type_id, 'frequent' => $frequent->id])" />
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>


</x-ui.table>

<x-ui.table>

    <x-slot name="button">
        @can('notifications-create')
        <a class="btn btn-primary mb-1" href="{{route('notifications.types.frequent.create',['notification' => $notification->id,'type' => request('type')]) }}">
            <em data-feather='plus-circle'></em> اضافة </a>
        @endcan
    </x-slot>

    <x-slot name="title">{{ sprintf('اعدادات التكرار للأشعار %s  #(%s) - بعد %s - %s - %s',($notification->type == 'external' ? 'الخارجي' : 'الداخلي'), $notification->id, $notification->notification_name , $notification->section_name ,$notification->event_name) }} </x-slot>
    <x-slot name="cardbody">بعد <span class="text-danger"> {{ $notification->notification_name }}</span> </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الشرط</th>
            <th scope="col">المحتوي</th>
            <th scope="col">التوقيت</th>
            <th scope="col">الحالة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach($frequent_notifications->where('condition_type','after') as $frequent)
            <th scope="row">
                {{ $frequent->id }}
            </th>
            <td>{{ $frequent->condition_type == 'after' ? 'بعد الحدث' : 'قبل الحدث' }}</td>
            <td><a href="{{ route('contents.edit',$frequent->content_id) }}">{{ $frequent->content_name }}</a></td>
            <td>{{ $frequent->interval }} ساعة</td>
            <td>{{ $frequent->active ? 'مفعل' : 'غير مفعل' }}</td>
            <td>
                @can('notifications-edit')
                <x-inputs.btn.edit :route="route('notifications.types.frequent.edit', ['notification' => $notification->id, 'type' => request()->type,'frequent' =>$frequent->id])" />
                @endcan

                @can('notifications-delete')
                <x-inputs.btn.delete colorClass="warning" :route="route('notifications.types.frequent.destroy',['notification' => $notification->id, 'type' => $frequent->notification_type_id, 'frequent' => $frequent->id])" />
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>


</x-ui.table>
<x-ui.SideDeletePopUp />

@endsection