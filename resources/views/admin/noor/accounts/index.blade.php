@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('noorAccounts.index'), 'name' => "حسابات نور"]],['title'=> 'حسابات نور']];
@endphp

@section('title', 'ادارة حسابات نور')

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">حسابات نور </x-slot>
    <x-slot name="cardbody">قائمة حسابات نور المسجلة بالمدرسة .. {{ isset($gender_id) ?  'احسابات نور الخاصة بالمرحلة  : ' . $type->gender_name  : 'حسابات نور' }} </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('noorAccounts.create') }}">
            <em data-feather='plus-circle'></em> اضافة حساب جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الحساب</th>
            <th scope="col">اسم المستخدم</th>
            <th scope="col">اسم المدرسة</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($accounts as $noorAccount)
            <th scope="row">{{ $noorAccount->id }}</th>
            <td>{{ $noorAccount->account_name }}</td>
            <td>{{ $noorAccount->username }}</td>
            <td>{{ $noorAccount->school_name }}</td>
            <td>
                @can('noorAccounts-list')
                <x-inputs.btn.view :route="route('noorAccounts.show',$noorAccount->id)" />
                @endcan

                @can('noorAccounts-edit')
                <x-inputs.btn.edit :route="route('noorAccounts.edit',$noorAccount->id)" />
                @endcan

                @can('noorAccounts-delete')
                <x-inputs.btn.delete :route="route('noorAccounts.destroy', $noorAccount->id)" />
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