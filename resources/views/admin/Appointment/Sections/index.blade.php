@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('appointments.sections.index'), 'name' => "اقسام المقابلات"]],['title'=> 'اقسام المقابلات']];
@endphp

@section('title', 'ادارة اقسام المقابلات')

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">اقسام المقابلات </x-slot>
    <x-slot name="cardbody">قائمة اقسام المقابلات .. يمكن لأولياء الأمور اختيار احد اقسام المقابلات المفعلة اثناء دفع الرسوم الدراسية ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('appointments.sections.create') }}">
            <em data-feather='plus-circle'></em> اضافة قسم </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم القسم</th>
            <th scope="col">اقصي موعد خلال</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach ($sections as $key => $section)
        <tr>
            <th scope="row">
                {{ $section->id }}
            </th>
            <td>{{ $section->section_name }}</td>
            <td>{{ $section->max_day_to_reservation }} يوم</td>

            <td>
                @can('appointments-list')
                <x-inputs.btn.view :route="route('appointments.sections.show',$section->id)" />
                @endcan

                @can('appointments-edit')
                <x-inputs.btn.edit :route="route('appointments.sections.edit',$section->id)" />
                @endcan

                @can('appointments-delete')
                <x-inputs.btn.delete :route="route('appointments.sections.destroy', $section->id)" />
                @endcan

                @can('appointments-list')
                <x-inputs.btn.generic :route="route('appointments.offices.index',['section' => $section->id])">مكاتب القسم</x-inputs.btn.generic>
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection