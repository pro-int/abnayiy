@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year), 'name' => "$year->year_name"],['link' => route('years.periods.index',$year), 'name' => "قترات السداد"]],['title'=> "فترات السداد $year->year_name"]];
@endphp

@section('title', 'ادارة قترات السداد')

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">قترات السداد  للعام الدراسي {{ $year->year_name }}</x-slot>
    <x-slot name="cardbody">تحتوي كل سنة دراسية علي مجموعة من فترات السداد تحدد قيمة الخصم الذي سيحصل علية الطالب في حالة السداد في هذة الفترة ..</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('years.periods.create',$year) }}">
            <em data-feather='plus-circle'></em> اضافة فترة سداد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الفترة</th>
            <th scope="col">تاريخ البدء</th>
            <th scope="col">تاريخ الانتهاء</th>
            <th scope="col">النقاط المكتسبة</th>
            <th scope="col">الحالة</th>
            <th scope="col"> الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($periods as $key => $period)
            <th scope="row">{{ $period->id }}</th>
            <td>{{ $period->period_name }}</td>
            <td>{{ $period->apply_start->isoFormat('LL') }}</td>
            <td>{{ $period->apply_end->isoFormat('LL') }}</td>
            <td>{{ $period->points_effect }}</td>
            <td>{{ $period->active ? 'مفعل' : 'غير مفعل' }}</td>

            <td>
                
                @can('periods-list')
                <x-inputs.btn.view :route="route('years.periods.show',['year' => $year,'period'=> $period->id])" />
                @endcan

                @can('periods-edit')
                <x-inputs.btn.edit :route="route('years.periods.edit',['year' => $year,'period'=> $period->id])" />
                @endcan
                
                @can('periods-delete')
                <x-inputs.btn.delete :route="route('years.periods.destroy', ['year' => $year,'period'=> $period->id])" />
                @endcan
                
                @can('discounts-list')
                <x-inputs.btn.generic icon="dollar-sign" :route="route('years.periods.discounts.index',['year' => $year,'period'=> $period->id])">الخصومات</x-inputs.btn.generic>
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