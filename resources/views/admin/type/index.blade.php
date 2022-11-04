@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('types.index'), 'name' => "الأقسام التعليمية "]],['title'=> 'الأقسام التعليمية المسجلة']];
@endphp

@section('title', 'ادارة الأقسام التعليمية ')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">الأقسام التعليمية</x-slot>
    <x-slot name="cardbody">قائمة الأقسام التعليمية المسجلة بالمدرسة .. كل مسار دراسي مسجل بداخلة انوع الطلب المسموح لهم الالتحاق بة </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('types.create') }}">
            <em data-feather='plus-circle'></em> اضافة مسار جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم المسار</th>
            <th scope="col">اسم المدرسة</th>
            <th scope="col">الاسم في نور</th>
            <th scope="col">الحالة</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($types as $type)
            <th scope="row">{{ $type->id }}</th>
            <td>{{ $type->school_name }}</td>
            <td>{{ $type->school_name }}</td>
            <td>{{ $type->school_name_noor }}</td>
            <td>{{ $type->active == 1 ? 'فعال' : 'غير مفعل' }}</td>

            <td>
                @can('types-list')
                <x-inputs.btn.view :route="route('types.show',$type->id)" />
                @endcan

                @can('types-edit')
                <x-inputs.btn.edit :route="route('types.edit',$type->id)" />
                @endcan

                @can('types-delete')
                <x-inputs.btn.delete :route="route('types.destroy', $type->id)" />
                @endcan

                @can('semesters-list')
                <x-inputs.btn.generic :route="route('genders.index', ['school_id' => $type->id])">الانواع</x-inputs.btn.generic>
                @endcan

            </td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection