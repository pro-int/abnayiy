@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('schools.index',request('corporate')), 'name' => "المدارس"]],['title'=> 'المدارس المسجلة']];
@endphp

@section('title', 'ادارة المدارس')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">المدارس </x-slot>
    <x-slot name="cardbody">قائمة المدارس   ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('schools.create') }}">
            <em data-feather='plus-circle'></em> اضافة مدرسة </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم المدارس</th>
            <th scope="col">المجمع</th>
            <th scope="col">قام بالأضافة</th>
            <th scope="col">قام بالتحديث </th>
            <th scope="col">الحالة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        
        @foreach ($schools as $school)
        <tr>
            <th scope="row">
                {{ $school->id }}
            </th>

            <td>{{ $school->school_name }}</td>
            <td>{{ $school->corporate_name }}</td>
            <td>{{ $school->createdAdminName }}</td>
            <td>{{ $school->UpdatedAdmimName }}</td>
            <td>{!! isActive($school->active) !!}</td>
            <td>
                @can('accuonts-list')
                <x-inputs.btn.view :route="route('schools.show',$school->id)" />
                @endcan

                @can('accuonts-edit')
                <x-inputs.btn.edit :route="route('schools.edit',$school->id)" />
                @endcan

                @can('accuonts-delete')
                <x-inputs.btn.delete :route="route('schools.destroy', $school->id)" />
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection