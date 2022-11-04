@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('guardians.index'), 'name' => "اولياء الأمور"], ['link' => route('debts.index'), 'name' => "المديونيات"]],['title' => 'مديونيات اولياء الأمور']];
@endphp

@section('title', 'مديونيات اولياء الأمور')

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')

<x-forms.search route="debts.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input :required="false" icon="search" label="عنوان الاقامة" name="search" placeholder="يمكنك البحث عن اسم او رقم جوال او هوية ويمكن البحث بالكود عن طريق اضافة = قبل كلمة البحث" />
        </div>
    </div>

    <x-slot name="export">

        <div class="btn-group">
            <button class="btn btn-outline-secondary waves-effect" name="action" type="submit" value="export_xlsx"><em data-feather='save'></em> اكسل</button>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden"></span>
            </button>
        </div>
    </x-slot>
</x-forms.search>

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">مديونيات  اولياء الامور</x-slot>
    <x-slot name="cardbody">تحتوي القائمة التالية علي اجمالي مديونيات والياء الأمور الذين تم ترحيلهم من الاعوام السابقة ولديهم مديونيات علما بأن الارقام ادناة لا تشمل مصروفات العام الحالي</x-slot>

    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('debts.create') }}">
            <em data-feather='plus-circle'></em> استيراد المديونيات </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود ولي الأمر</th>
            <th scope="col">اسم ولي الأمر</th>
            <th scope="col">الجوال</th>
            <th scope="col">المديونية</th>
            <th scope="col">التفاصيل</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($debts->where('total_debt', '>' ,0) as $key => $debt)
        <tr>
            <td># <a href="{{ route('users.edit',$debt->guardian_id) }}">{{ $debt->guardian_id }}</a> </td>
            <td><a href="{{ route('debts.show',$debt->guardian_id) }}">{{ $debt->guardian_name }}</a></td>
            <td>{{ $debt->phone }}</td>
            <td> <span class="badge bg-danger">{{ $debt->total_debt }} ر.س</span></td>
            <td><x-inputs.btn.generic colorClass="warning" :route="route('debts.show',$debt->guardian_id)">تفاصيل المديونية</x-inputs.btn.generic></td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>

</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection