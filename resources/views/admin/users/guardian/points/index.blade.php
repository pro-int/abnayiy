@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('guardians.index'), 'name' => "اولياء الأمور"], ['link' => route('users.edit',$user->id), 'name' => "$user->guardian_name"], ['link' => route('guardians.points.index',$user->id), 'name' => "تاريخ النقاط"]],['title' => 'تاريخ النقاط']];
@endphp

@section('title', 'تاريخ نقاط ولي الأمر | ' . $user->guardian_name)

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">نقاط ولي الأمر  <span class="text-danger">{{ $user->guardian_name }}</span> </x-slot>
    <x-slot name="cardbody">يحصل كل ولي امر علي رصيد نقاط بناء علي اخر عملية دفع تمت علي النظام.</x-slot>
    <x-slot name="button">
    <x-inputs.link route="guardians.index">عودة</x-inputs.link>

    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">رقم الحركة</th>
            <th scope="col">العام الدراسي</th>
            <th scope="col">فترة السداد</th>
            <th scope="col">النقاط المكتسبة</th>
            <th scope="col">ملاحظات</th>
            <th scope="col">تاريخ الحركة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($guardianPoints as $guardianPoint)
        <tr>
            <td>{{ $guardianPoint->id }}</td>
            <td>{{ $guardianPoint->year_name }}</td>
            <td>{{ $guardianPoint->period_name }}</td>
            <td><span class="badge bg-{{ $guardianPoint->points >= 0 ? 'success' : 'danger' }}">{{ $guardianPoint->points }}</span></td>
            <td>{{ $guardianPoint->reason }}</td>
            <td>{{ $guardianPoint->created_at }}</td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>

</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
