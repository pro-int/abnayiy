@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('sections.index'), 'name' => "اقسام الأشعارات"]],['title'=> ' ادارة اقسام الأشعارات']];
@endphp

@section('title', 'اقسام الأشعارات')

@section('content')

<!-- Striped rows start -->
<x-ui.table>

    <x-slot name="title">اقسام الأشعارات </x-slot>
    <x-slot name="cardbody">ادارة اقسام الأشعارات </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم القسم</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach($sections as $section)
            <th scope="row">
                {{ $section->id }}
            </th>
            <td>{{ $section->section_name }}</td>
            <td>
                @can('notifications-edit')
                <x-inputs.btn.edit :route="route('sections.edit',$section->id)" />
                @endcan

                @can('notifications-list')
                <x-inputs.btn.generic colorClass="warning" :route="route('sections.events.index',$section->id)">المناسبات المتاحة</x-inputs.btn.view>
                    @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>

<x-ui.SideDeletePopUp />

@endsection