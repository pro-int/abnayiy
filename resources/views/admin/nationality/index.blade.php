@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('nationalities.index'), 'name' => "قائمة الجنسيات"]],['title'=> 'قائمة الجنسيات']];
@endphp

@section('title', 'ادارة قائمة الجنسيات')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">قائمة الجنسيات </x-slot>
    <x-slot name="cardbody">قائمة قائمة الجنسيات .. يمكن لأولياء الأمور اختيار احد قائمة الجنسيات المفعلة اثناء تقديم طلبات الألتحاق او الترفيع ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('nationalities.create') }}">
            <em data-feather='plus-circle'></em> اضافة جنسية جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الجنسية</th>
            <th scope="col">قيمة الضرائب</th>
            <th scope="col">الحالة</th>
            <th scope="col">الاجراءات المتاحة</th>

        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach ($nationalities as $nationality)
        <tr>
            <th scope="row">
                {{ $nationality->id }}
            </th>
            <td>{{ $nationality->nationality_name }}</td>
            <td>{{ $nationality->vat_rate }} %</td>
            <td>{{ $nationality->active == 1 ? 'فعال' : 'غير مفعل' }}</td>
            <td>
                @can('accuonts-list')
                <x-inputs.btn.view :route="route('nationalities.show',$nationality->id)" />
                @endcan

                @can('accuonts-edit')
                <x-inputs.btn.edit :route="route('nationalities.edit',$nationality->id)" />
                @endcan

                @can('accuonts-delete')
                <x-inputs.btn.delete :route="route('nationalities.destroy', $nationality->id)" />
                @endcan

            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
