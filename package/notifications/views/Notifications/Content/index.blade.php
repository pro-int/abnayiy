@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('contents.index'), 'name' => "محتوي الأشعارات"]],['title'=> ' ادارة محتوي الأشعارات']];
@endphp

@section('title', 'ادارة محتوي الأشعارات')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('contents.create') }}">
            <em data-feather='plus-circle'></em> اضافة محتوي </a>
    </x-slot>

    <x-slot name="title">محتوي الأشعارات </x-slot>
    <x-slot name="cardbody">محتوي الأشعارات </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الوصف</th>
            <th scope="col">القسم</th>
            <th scope="col">المناسبة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach($contents as $content)
        <th scope="row">
            {{ $content->id }}
        </th>
        <td>{{ $content->content_name }}</td>
        <td>{{ $content->section_name }}</td>
        <td>{{ $content->event_name }}</td>

        <td>
            @can('contents-list')
            <x-inputs.btn.view :route="route('contents.show',$content->id)" />
            @endcan

            @can('notifications-edit')
            <x-inputs.btn.edit :route="route('contents.edit',$content->id)" />
            @endcan

            @can('contents-edit')
            <x-inputs.btn.delete :route="route('contents.destroy',$content->id)" />
            @endcan
        </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

@endsection