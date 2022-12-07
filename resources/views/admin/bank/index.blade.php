@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('banks.index'), 'name' => "البنوك"]],['title'=> 'البنوك المسجلة']];
@endphp

@section('title', 'ادارة البنوك')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">البنوك </x-slot>
    <x-slot name="cardbody">قائمة البنوك .. يمكن لأولياء الأمور اختيار احد البنوك المفعلة اثناء دفع الرسوم الدراسية ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('banks.create') }}">
            <em data-feather='plus-circle'></em> اضافة بنك </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم البنك</th>
            <th scope="col">اسم الحساب</th>
            <th scope="col">رقم الحساب</th>
            <th scope="col">رقم IBAN</th>
            <th scope="col">Odoo ِAccount Code</th>
            <th scope="col">Odoo Journal ID</th>
            <th scope="col">الحالة</th>
            <th scope="col">إنشاءه بواسطة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach ($banks as $bank)
        <tr>
            <th scope="row">
                {{ $bank->id }}
            </th>

            <td>{{ $bank->bank_name }}</td>
            <td>{{ $bank->account_name }}</td>
            <td>{{ $bank->account_number }}</td>
            <td>{{ $bank->account_iban }}</td>
            <td>{{ $bank->journal_id }}</td>
            <td>{{ $bank->odoo_account_number }}</td>
            <td>{{ $bank->active == 1 ? 'فعال' : 'غير مفعل' }}</td>
            <td>{{ $bank->admin_name }}</td>
            <td>
                @can('accuonts-list')
                <x-inputs.btn.view :route="route('banks.show',$bank->id)" />
                @endcan

                @can('accuonts-edit')
                <x-inputs.btn.edit :route="route('banks.edit',$bank->id)" />
                @endcan

                @can('accuonts-delete')
                <x-inputs.btn.delete :route="route('banks.destroy', $bank->id)" />
                @endcan

            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
