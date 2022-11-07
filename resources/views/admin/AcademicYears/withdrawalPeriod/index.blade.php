@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year), 'name' => "$year->year_name"],['link' => route('years.periods.index',$year), 'name' => "قترات السداد"]],['title'=> "فترات السداد $year->year_name"]];
@endphp

@section('title', 'ادارة قترات طلبات الانسحاب')

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">قترات طلبات الانسحاب  للعام الدراسي {{ $year->year_name }}</x-slot>
    <x-slot name="cardbody">تحتوي كل سنة دراسية علي مجموعة من فترات طلبات الانسحاب تحدد قيمة الخصم الذي سيحصل علية الطالب في حالة الانسحاب في هذة الفترة ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('years.withdrawalPeriods.create',$year) }}">
            <em data-feather='plus-circle'></em> اضافة فترة طلب انسحاب </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الفترة</th>
            <th scope="col">تاريخ البدء</th>
            <th scope="col">تاريخ الانتهاء</th>
            <th scope="col">الرسوم المستخدمة</th>
            <th scope="col">المبلغ المستحق</th>
            <th scope="col">الحالة</th>
            <th scope="col"> الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($withdrawalPeriods as $key => $withdrawalPeriod)
            <th scope="row">{{ $withdrawalPeriod->id }}</th>
            <td>{{ $withdrawalPeriod->period_name }}</td>
            <td>{{ $withdrawalPeriod->apply_start->isoFormat('LL') }}</td>
            <td>{{ $withdrawalPeriod->apply_end->isoFormat('LL') }}</td>
            <td>{{ $withdrawalPeriod->fees_type == "money" ? "مبلغ" : "نسبة"}}</td>
            <td>{{ $withdrawalPeriod->fees }}</td>
            <td>{{ $withdrawalPeriod->active ? 'مفعل' : 'غير مفعل' }}</td>

            <td>

                @can('periods-list')
                <x-inputs.btn.view :route="route('years.withdrawalPeriods.show',['year' => $year,'withdrawalPeriod'=> $withdrawalPeriod->id])" />
                @endcan

                @can('periods-edit')
                <x-inputs.btn.edit :route="route('years.withdrawalPeriods.edit',['year' => $year,'withdrawalPeriod'=> $withdrawalPeriod->id])" />
                @endcan

                @can('periods-delete')
                <x-inputs.btn.delete :route="route('years.withdrawalPeriods.destroy', ['year' => $year,'withdrawalPeriod'=> $withdrawalPeriod->id])" />
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
