@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => '#', 'name' => "نظام الأشعارات"],['link' => route('UserNotifications',$user), 'name' => "اشعارات المستخدم $user->first_name"]],['title'=> 'اشعارات المستخدم']];
@endphp

@section('title', 'ادارة قنوات الأرسال')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">الأشعارات المرسلة الي المستخدم <span class="text-danger"> {{ $user->first_name . ' ' . $user->last_name }} </span> </x-slot>
    <x-slot name="cardbody">الاشعارات المرسلة الي مستخدمين النظام  من خلال نظام الأشعارات </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الاشعار</th>
            <th scope="col">نص الأشعار</th>
            <th scope="col">قناة الأرسال</th>
            <th scope="col">حالة الأرسال</th>
            <th scope="col">التوقيت</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach($notifications as $notification)
        <tr>
            <th scope="row">{{ $notification->id }}</th>
            <td>{{ $notification->notification_name }}</td>
            <td><abbr title="{{ $notification->notification_text }}">المحتوي</abbr></td>
            <td>{{ $notification->channel_name ?? 'اشعار داخلي'}}</td>
            <td>@if($notification->sent) تم الأرسال @else <abbr style="color: red;" title="{{ $notification->response }}">التقربر</abbr>@endif</td>
            <td><abbr title="{{ $notification->created_at}}">{{ $notification->created_at->diffforhumans()}}</abbr></td>
        </tr>
        @endforeach
    </x-slot>
    <x-slot name="pagination">
        {{ $notifications->appends(request()->except('page'))->links() }}
    </x-slot>

</x-ui.table>

@endsection
