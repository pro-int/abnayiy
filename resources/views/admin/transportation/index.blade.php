@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('transportations.index'), 'name' => "خطط النقل"]],['title'=> 'خطط النقل']];
@endphp

@section('title', 'ادارة خطط النقل')

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">خطط النقل </x-slot>
    <x-slot name="cardbody">يمكن لأولياء الأمور اختيار خطة السداد اثناء تقديم طلب الألتحاق او الترفيع</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('transportations.create') }}">
            <em data-feather='plus-circle'></em> اضافة خطة نقل </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">خطة النقل</th>
            <th scope="col">الاشتراك السنوي</th>
            <th scope="col">اشتراك الفصل</th>
            <th scope="col">الاشتراك الشهري</th>
            <th scope="col">Odoo Product ID</th>
            <th scope="col">Odoo Account Code</th>
            <th scope="col">الحالة</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تحديث</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach ($transportations as $transportation)
        <tr>
            <th>{{ $transportation->id }}</th>
            <td>{{ $transportation->transportation_type }}</td>
            <td>{{ $transportation->annual_fees }}</td>
            <td>{{ $transportation->semester_fees }}</td>
            <td>{{ $transportation->monthly_fees }}</td>
            <td>{{ $transportation->odoo_product_id }}</td>
            <td>{{ $transportation->odoo_account_code }}</td>

            <td>{{ $transportation->active ? 'مفعل' : 'غير مفعل' }}</td>
            <td>{{ $transportation->admin_name }}</td>
            <td><abbr title="تاريخ التسجيل : {{ $transportation->created_at->format('Y-m-d h:m:s') }}">{{ $transportation->updated_at->diffforhumans() }}</abbr></td>

            <td>
                @can('accuonts-list')
                <x-inputs.btn.view :route="route('transportations.show',$transportation->id)" />
                @endcan

                @can('accuonts-edit')
                <x-inputs.btn.edit :route="route('transportations.edit',$transportation->id)" />
                @endcan

                @can('accuonts-delete')
                <x-inputs.btn.delete :route="route('transportations.destroy', $transportation->id)" />
                @endcan

            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
