@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('appointments.sections.index'), 'name' => "اقسام المقابلات"],['link' => route('appointments.offices.index'), 'name' => "مكاتب المقابلات"]],['title'=> 'مكاتب المقابلات']];
@endphp

@section('title', 'ادارة مكاتب المقابلات')

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">المكاتب المرتبطة بـ : <span class="text-danger">{{ $section ?  sprintf('قسم %s',$section->section_name) : 'جميع الاقسام'}}</span> </x-slot>
    <x-slot name="cardbody">قائمة مكاتب المقابلات .. يمكن لأولياء الأمور اختيار احد مكاتب المقابلات المفعلة اثناء دفع الرسوم الدراسية ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('appointments.offices.create') }}">
            <em data-feather='plus-circle'></em> اضافة مكتب </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم المكتب</th>
            <th scope="col">اسم الموظف</th>
            <th scope="col">التليفون</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach ($offices as $key => $office)
        <tr>
            <th scope="row">
                {{ $office->id }}
            </th>
            <td>{{ $office->office_name }}</td>
            <td>{{ $office->employee_name }}</td>
            <td>{{ $office->phone }}</td>
            <td>
                @can('appointments-list')
                <x-inputs.btn.view :route="route('appointments.offices.show',$office->id)" />
                @endcan

                @can('appointments-edit')
                <x-inputs.btn.edit :route="route('appointments.offices.edit',$office->id)" />
                @endcan

                @can('appointments-delete')
                <x-inputs.btn.delete :route="route('appointments.offices.destroy', $office->id)" />
                @endcan

                @can('appointments-edit')
                <x-inputs.btn.generic :route="route('appointments.offices.days.index',$office->id)">إعدادات المواعيد</x-inputs.btn.generic>
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection