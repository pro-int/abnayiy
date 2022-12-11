@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('genders.index'), 'name' => "الأقسام"]],['title'=> 'الأقسام المسجلة']];
@endphp

@section('title', 'ادارة الأقسام')

@section('content')

<x-forms.search route="genders.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المدرسة" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>
    </div>

</x-forms.search>

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">الأقسام </x-slot>
    <x-slot name="cardbody">قائمة الأقسام المسجلة بالمدرسة .. {{ isset($type) ?  'الأقسام  الخاصة بالنظام : ' . $type->school_name  : 'الأقسام ( بنين - بنات - مشترك)' }} </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('genders.create') }}">
            <em data-feather='plus-circle'></em> اضافة قسم جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم القسم</th>
            <th scope="col">النوع</th>
            <th scope="col">المدرسة</th>
            <th scope="col">الاسم في نور</th>
            <th scope="col">قسم المقابلات</th>
            <th scope="col">حساب نور</th>
            <th scope="col">Odoo Product ID</th>
            <th scope="col">الحالة</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($genders as $gender)
            <th scope="row">{{ $gender->id }}</th>
            <td>{{ $gender->gender_name }}</td>
            <td>{{ $gender->getGenderTypeName() }}</td>
            <td>{{ $gender->school_name }}</td>
                <td>{{ $gender->grade_name_noor }}</td>
                <td>{{ $gender->section_name }}</td>
                <td>{{ $gender->account_name }}</td>
                <td>{{ $gender->odoo_product_id }}</td>
            <td>{{ $gender->active == 1 ? 'فعال' : 'غير مفعل' }}</td>
            <td>
                @can('genders-list')
                <x-inputs.btn.view :route="route('genders.show',$gender->id)" />
                @endcan

                @can('genders-edit')
                <x-inputs.btn.edit :route="route('genders.edit',$gender->id)" />
                @endcan

                @can('genders-delete')
                <x-inputs.btn.delete :route="route('genders.destroy', $gender->id)" />
                @endcan

                @can('semesters-list')
                <x-inputs.btn.generic :route="route('grades.index', ['gender_id' => $gender->id])">المسارات</x-inputs.btn.generic>
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
