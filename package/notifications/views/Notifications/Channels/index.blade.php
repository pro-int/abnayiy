@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('channels.index'), 'name' => "قنوات الأرسال"]],['title'=> ' ادارة قنوات الأرسال']];
@endphp

@section('title', 'ادارة قنوات الأرسال')

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">قنوات الأرسال </x-slot>
    <x-slot name="cardbody">قنوات الأرسال هي القنوات التي يمكن لنظام ارسال الأشعارات من خلالها </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الاسم</th>
            <th scope="col">الحالة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach($Channels as $Channel)
        <tr>
            <th scope="row">
                {{ $Channel->id }}
            </th>
            <td>{{ $Channel->channel_name }}</td>
            <td>{{ $Channel->active ? 'مفعل' : 'غير مفعل'}}</td>

            <td>
                @can('notifications-edit')
                <x-inputs.btn.edit :route="route('channels.edit',$Channel->id)" />
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

@endsection