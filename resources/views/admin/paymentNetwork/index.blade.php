@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('payment_networks.index'), 'name' => "شبكات السداد"]],['title'=> 'شبكات السداد المسجلة']];
@endphp

@section('title', 'ادارة شبكات السداد')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">شبكات السداد </x-slot>
    <x-slot name="cardbody">قائمة شبكات السداد .. يمكن لأولياء الأمور اختيار احد شبكات السداد المفعلة اثناء دفع الرسوم الدراسية ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('payment_networks.create') }}">
            <em data-feather='plus-circle'></em> اضافة شبكة </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الشبكة</th>
            <th scope="col">رقم الحساب</th>
            <th scope="col">الحالة</th>
            <th scope="col">إنشاءه بواسطة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        
        @foreach ($networks as $network)
        <tr>
            <th scope="row">
                {{ $network->id }}
            </th>

            <td>{{ $network->network_name }}</td>
            <td>{{ $network->account_number }}</td>
            <td>{!! isActive($network->active) !!}</td>
            <td>{{ $network->admin_name }}</td>
            <td>
                @can('accuonts-list')
                <x-inputs.btn.view :route="route('payment_networks.show',$network->id)" />
                @endcan

                @can('accuonts-edit')
                <x-inputs.btn.edit :route="route('payment_networks.edit',$network->id)" />
                @endcan

                @can('accuonts-delete')
                <x-inputs.btn.delete :route="route('payment_networks.destroy', $network->id)" />
                @endcan

            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection