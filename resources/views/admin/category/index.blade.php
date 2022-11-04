@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('categories.index'), 'name' => "فئات العملاء"]],['title'=> 'فئات العملاء المسجلة']];
@endphp

@section('title', 'ادارة فئات العملاء')

@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">فئات العملاء </x-slot>
    <x-slot name="cardbody">قائمة فئات العملاء .. تحدد فئة العميل نسبة الخصم الذي يحصل علية </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('categories.create') }}">
            <em data-feather='plus-circle'></em> اضافة فئة جديدة </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الفئة</th>
            <th scope="col">اسم الترويج</th>
            <th scope="col">الحدي الأدني للنقاط</th>
            <th scope="col">الفئة الافتراضية ؟</th>
            <th scope="col">طابع خاص ؟</th>
            <th scope="col">الحالة</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($categories as $category)
            <th scope="row">{{ $category->id }}</th>
            <td><span class="badge bg-{{$category->color}}">{{ $category->category_name }}</span></td>
            <td>{{ $category->promotion_name }}</td>
            <td>{{ $category->required_points }}</td>
            <td>{{ $category->is_default == 1 ? 'نعم' : 'لا' }}</td>
            <td>{{ $category->is_fixed == 1 ? 'نعم' : 'لا' }}</td>
            <td>{{ $category->active == 1 ? 'فعال' : 'غير مفعل' }}</td>

            <td>
                @can('categories-list')
                <x-inputs.btn.view :route="route('categories.show',$category->id)" />
                @endcan

                @can('categories-edit')
                <x-inputs.btn.edit :route="route('categories.edit',$category->id)" />
                @endcan

                @can('categories-delete')
                <x-inputs.btn.delete :route="route('categories.destroy', $category->id)" />
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection