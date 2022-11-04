@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('home'), 'name' => "الرئيسية"],['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year->id), 'name' => $year->year_name],['name'=> 'الفصول الدراسية', 'link' => route('years.semesters.index',$year->id)] ],['title' => 'الفصول الدراسية']];
@endphp

@section('title', 'فصول السنة الدراسية : ' . $year->year_name )

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">الفصول الدراسية ({{ $year->year_name }}) </x-slot>
    <x-slot name="cardbody">قائمة الفصول الدراسية المسجلة ضمن العام الدراسي - {{ $year->year_name }}</x-slot>

    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('years.semesters.create',['year'=> $year->id]) }}">
            <em data-feather='plus-circle'></em> اضافة فصل دراسي جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الفصل الدراسي</th>
            <th scope="col">العام الدراسي</th>
            <th scope="col">بداية الفصل</th>
            <th scope="col">نهاية الفصل</th>
            <th scope="col">نسبة الرسوم للألتحاق </th>
            <th scope="col">نسبة الرسوم للأنسحاب</th>
            <th scope="col">الاجراءات المتاحة</th>

        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($semesters as $semester)
        <tr>

            <th scope="row">
                {{ $semester->id }}
            </th>
            <td>{{ $semester->semester_name }}</td>
            <td>{{ $semester->year_name }}</td>
            <td>{{ $semester->semester_start }}</td>
            <td>{{ $semester->semester_end }}</td>
            <td>{{ $semester->semester_in_fees }} %</td>
            <td>{{ $semester->semester_out_fees }} %</td>

            <td>
                @can('semesters-list')
                <x-inputs.btn.view :route="route('years.semesters.show',[$year->id,$semester->id])" />
                @endcan

                @can('semesters-edit')
                <x-inputs.btn.edit :route="route('years.semesters.edit',[$year->id,$semester->id])" />
                @endcan
                
                @can('semesters-delete')
                <x-inputs.btn.delete :route="route('years.semesters.destroy', [$year->id,$semester->id])" />
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