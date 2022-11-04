@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('corporates.index'), 'name' => "المجمعات"]],['title'=> 'المجمعات المسجلة']];
@endphp

@section('title', 'ادارة المجمعات')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">المجمعات الدراسية</x-slot>
    <x-slot name="cardbody">قائمة المجمعات الدراسية  ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('corporates.create') }}">
            <em data-feather='plus-circle'></em> اضافة مجمع </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم المجمع</th>
            <th scope="col">قام بالأضافة</th>
            <th scope="col">قام بالتحديث </th>
            <th scope="col">الحالة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        
        @foreach ($corporates as $corporate)
        <tr>
            <th scope="row">
                {{ $corporate->id }}
            </th>

            <td>{{ $corporate->corporate_name }}</td>
            <td>{{ $corporate->createdAdminName }}</td>
            <td>{{ $corporate->UpdatedAdmimName }}</td>
            <td>{!! isActive($corporate->active) !!}</td>
            <td>
                
                @can('accuonts-list')
                <x-inputs.btn.view :route="route('corporates.show',$corporate->id)" />
                @endcan

                @can('accuonts-edit')
                <x-inputs.btn.edit :route="route('corporates.edit',$corporate->id)" />
                @endcan
                
                @can('accuonts-delete')
                <x-inputs.btn.delete :route="route('corporates.destroy', $corporate->id)" />
                @endcan
                
                @can('accuonts-list')
                    <x-inputs.btn.generic :route="route('schools.index',['corporate' => $corporate->id])">
                        المادرس
                    </x-inputs.btn.generic>
                    @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection