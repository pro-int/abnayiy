@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('plans.index'), 'name' => "خطط السداد"]],['title'=> 'خطط السداد']];
@endphp

@section('title', 'ادارة خطط السداد')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">خطط السداد </x-slot>
    <x-slot name="cardbody">قائمة خطط السداد .. يمكن لأولياء الأمور اختيار احد خطط السداد المفعلة اثناء تقديم طلبات الألتحاق او الترفيع ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('plans.create') }}">
            <em data-feather='plus-circle'></em> اضافة خطة جديدة </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الخطة</th>
            <th scope="col">تتطلب سند امر</th>
            <th scope="col">خصم الفترة</th>
            <th scope="col">Odoo ID</th>
            <th scope="col">الحالة</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach ($plans as $plan)
        <tr>
            <th>{{ $plan->id }}</th>
            <td>{{ $plan->plan_name }}</td>
            <td>{{ $plan->req_confirmation == 1 ? 'نعم' : 'لا' }}</td>
            <td>{{ $plan->fixed_discount == 1 ? 'اثناء التعاقد' : 'تطبق اثناء الدفع' }}</td>
            <td>{{ $plan->odoo_id}}</td>
            <td>{{ $plan->active == 1 ? 'مفعل' : 'غير مفعل' }}</td>

            <td>
                @can('accuonts-list')
                <x-inputs.btn.view :route="route('plans.show',$plan->id)" />
                @endcan

                @can('accuonts-edit')
                <x-inputs.btn.edit :route="route('plans.edit',$plan->id)" />
                @endcan

                @can('accuonts-delete')
                <x-inputs.btn.delete :route="route('plans.destroy', $plan->id)" />
                @endcan

            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
