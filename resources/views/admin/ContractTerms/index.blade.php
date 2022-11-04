@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('contract_terms.index'), 'name' => 'شروط التعاقد']],['title'=> 'الشروط']];
@endphp

@section('title', 'شروط التعاقد')



@section('content')
<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">شروط التعاقد </x-slot>
    <x-slot name="cardbody">شروط التعاقد المسجلة بالمدرسة ..</x-slot>

    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('contract_terms.create') }}">
            <em data-feather='plus-circle'></em> اضافة تصميم جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">النسخة</th>
            <th scope="col">الحالة</th>
            <th scope="col">تم إنشاءه بواسطة</th>
            <th scope="col">تم تعديلة بواسطة</th>
            <th scope="col">تاريخ اﻹنشاء</th>
            <th scope="col">تاريخ التعديل</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($contract_terms as $term)
        <tr>
            <th scope="row">
                {{ $term->id }}
            </th>
            <td>{{ $term->version }}</td>
            <td>{{ $term->is_default == 1 ? 'افتراضى' : 'غير افتراضى' }}</td>
            <td>{{ $term->createdByUserName }} </td>
            <td>{{ $term->updatedByUserName }} </td>
            <td><abbr title="{{ $term->created_at}}">{{ $term->created_at->diffforhumans()}}</abbr></td>
            <td><abbr title="{{ $term->updated_at }}">{{ $term->updated_at ->diffforhumans()}}</abbr></td>

            <td>
                <x-inputs.btn.view :route="route('contract_terms.show', $term->id)" />
                <x-inputs.btn.edit :route="route('contract_terms.edit', $term->id)" />
                <x-inputs.btn.delete :route="route('contract_terms.destroy', $term->id)" />

            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection