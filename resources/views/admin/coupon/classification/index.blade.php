@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('coupons.index'), 'name' => 'قسائم الخصم'], ['link' => route('classifications.index'), 'name' => 'تصنيفات القسائم']],['title'=> 'تصنيفات القسائم']];
@endphp

@section('title', 'تصنيفات القسائم')


@section('content')
<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">تصنيفات القسائم </x-slot>
    <x-slot name="cardbody">تصنيفات القسائم تسمح لمديرين النظام بوضع حدود مختلفة لكل تصنيف مما يسمح في التحكم في قيمة الخصومات الممنوحة لكل تصنيف ..</x-slot>

    @can('discounts-create')
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('classifications.create') }}">
            <em data-feather='plus-circle'></em> اضافة تصنيف جديد </a>
    </x-slot>
    @endcan

    <x-slot name="thead">
        <tr>
            <th scope="col">#</th>
            <th scope="col">اسم التصنيف</th>
            <th scope="col">العام الدراسي</th>
            <th scope="col">الحد الاقصي</th>
            <th scope="col">القسائم المستخدمة</th>
            <th scope="col">القسائم الصالحة</th>
            <th scope="col">بادئة القسائم</th>
            <th scope="col">الحالة</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تعديل</th>
            <th scope="col" style="min-width:180px;">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach($classifications as $Classification)
        <tr>

            <th scope="row">
                {{ $Classification->id }}
            </th>
            <td>{{ $Classification->classification_name }}</td>
            <td>{{ $Classification->year_name }}</td>
            <td>{{ $Classification->limit }} ر.س</td>
            <td>{{ $Classification->used_limit }} ر.س</td>
            <td>{{ $Classification->unused_limit }} ر.س</td>
            <td><span class="badge bg-{{$Classification->color_class}}">{{ $Classification->classification_prefix }}</span></td>

            <td>{!! isActive($Classification->active) !!}</td>
            <td>{{ $Classification->admin_name }}</td>

            <td><abbr title="تاريخ التسجيل : {{ $Classification->created_at->format('Y-m-d h:m:s') }}">{{ $Classification->updated_at->diffforhumans() }}</abbr></td>
     
            <td>
                @if(!$Classification->trashed())
                @can('discounts-list')
                <x-inputs.btn.view :route="route('classifications.show', $Classification->id)" />
                @endcan

                @can('discounts-edit')
                <x-inputs.btn.edit :route="route('classifications.edit', $Classification->id)" />
                @endcan

                @can('discounts-delete')
                <x-inputs.btn.delete :route="route('classifications.destroy', $Classification->id)" />
                @endcan
                @else
                    <abbr title="تم الحذف في : {{ $Classification->deleted_at }}"><span class="badge bg-danger">تم الحذف</span></abbr>
                @endif
                
            </td>
        </tr>
        @endforeach
    </x-slot>
    <x-slot name="pagination">
        {{ $classifications->appends(request()->except('page'))->links() }}
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection