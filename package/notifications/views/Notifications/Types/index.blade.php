@extends('layouts.contentLayoutMaster')

@php
$type = request('selected_type') && request('selected_type') == 'external' ? 'الخارجي' : 'الداخلي';

$breadcrumbs = [[['link' => route('notifications.index'), 'name' => " الأشعارات"], ['link' => route('notifications.types.index',[$notification,'selected_type' => request('selected_type')]), 'name' => "اعدادات الأشعار $type : $notification->notification_name"]],['title'=> ' ادارة الأشعارات']];
@endphp

@section('title', sprintf('اعدادات الاشعار %s #(%s) - %s - %s - %s',$type, $notification->id, $notification->notification_name , $notification->section_name ,$notification->event_name))

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="button">
        @can('notifications-create')
        <a class="btn btn-primary mb-1" href="{{route('notifications.types.create',['notification' => $notification->id,'selected_type' => request()->selected_type]) }}">
            <em data-feather='plus-circle'></em> اضافة اشعار </a>
        @endcan
    </x-slot>

    <x-slot name="title">اشعارات الأدارة </x-slot>
    <x-slot name="cardbody">{{ sprintf('اعدادات الاشعار %s #(%s) - %s - %s - %s - الخاصة بمدير النظام',$type, $notification->id, $notification->notification_name , $notification->section_name ,$notification->event_name) }} </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">النوع</th>
            <th scope="col">المحتوي</th>
            @if(request()->selected_type == 'external')<th scope="col">قنوات الارسال</th>@endif
            <th scope="col">الحالة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach($notifications_types->where('target_user','admin') as $type)
            <th scope="row">
                {{ $type->id }}
            </th>
            <td>{{ $type->frequent }}</td>
            <td>@if($type->getRawOriginal('frequent') == 'single')<a href="{{ route('contents.edit',$type->content_id) }}">{{ $type->content_name }}</a> @else متغير @endif</td>
            @if($type->type == 'external')<td>{{ count($type->channels) }}</td>@endif
            <td>{{ $type->active ? 'مفعل' : 'غير مفعل' }}</td>
            <td>
                
                @can('notifications-edit')
                <x-inputs.btn.edit :route=" route('notifications.types.edit', ['notification' => $type->notification_id, 'type' => $type->id])" />
                @endcan

                @if($type->getRawOriginal('frequent') == 'frequent')
                @can('notifications-list')
                <x-inputs.btn.generic colorClass="warning" :route="route('notifications.types.frequent.index',['notification' => $type->notification_id, 'type' => $type->id])" >ادارة التكرار</x-inputs.btn.view>
                @endcan
                @endif

                @can('notifications-delete')
                <x-inputs.btn.delete :route=" route('notifications.types.destroy',['notification'=>$type->notification_id,'type'=>$type->id])" />
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>

<x-ui.table>
    <x-slot name="button">
        @can('notifications-create')
        <a class="btn btn-primary mb-1" href="{{route('notifications.types.create',['notification' => $notification->id,'selected_type' => request()->selected_type]) }}">
            <em data-feather='plus-circle'></em> اضافة اشعار </a>
        @endcan
    </x-slot>

    <x-slot name="title">اشعارات المستخدم </x-slot>
    <x-slot name="cardbody"> {{sprintf('اعدادات الاشعار %s #(%s) - %s - %s - %s - الخاصة بأولياء الأمور',(request()->selected_type && request()->selected_type == 'external' ? 'الخارجي' : 'الداخلي'), $notification->id, $notification->notification_name , $notification->section_name ,$notification->event_name)}}</x-slot>

    <x-slot name="thead">
        <tr>
        <th scope="col">كود</th>
                <th scope="col">التكرار</th>
                <th scope="col">المحتوي</th>
                @if(request()->selected_type == 'external')<th scope="col">قنوات الارسال</th>@endif
                <th scope="col">الحالة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
        @foreach($notifications_types->where('target_user','user') as $type)
                <th scope="row">
                    {{ $type->id }}
                </th>
                <td>{{ $type->frequent }}</td>
                <td>@if($type->getRawOriginal('frequent') == 'single')<a href="{{ route('contents.edit',$type->content_id) }}">{{ $type->content_name }}</a> @else متغير @endif</td>
                @if($type->type == 'external')<td>{{ count($type->channels) }}</td>@endif
                <td>{{ $type->active ? 'مفعل' : 'غير مفعل' }}</td>
            <td>
                @can('notifications-edit')
                <x-inputs.btn.edit :route=" route('notifications.types.edit', ['notification' => $type->notification_id, 'type' => $type->id])" />
                @endcan

                @if($type->getRawOriginal('frequent') == 'frequent')
                @can('notifications-list')
                <x-inputs.btn.generic colorClass="warning" :route="route('notifications.types.frequent.index',['notification' => $type->notification_id, 'type' => $type->id])" >ادارة التكرار</x-inputs.btn.view>
                @endcan
                @endif

                @can('notifications-delete')
                <x-inputs.btn.delete  :route=" route('notifications.types.destroy',['notification'=>$type->notification_id,'type'=>$type->id])" />
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>

<x-ui.SideDeletePopUp />

@endsection
