@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('levels.index'), 'name' => "الصفوف الدراسية"],['link' => route('levels.subjects.index',$level->id), 'name' => "المواد الدراسية للصف $level->level_name"]],['title'=> 'المواد الدراسية المسجلة']];
@endphp

@section('title', 'ادارة المواد الدراسية للصف الدراسي : ' , $level->level_name)

@section('content')
    <!-- Striped rows start -->
    <x-ui.table>
        <x-slot name="title">المواد الدراسية </x-slot>
        <x-slot name="cardbody">المواد الدراسية المسجلة للصف الدراسي {{ $level->level_name }} </x-slot>
        <x-slot name="button">
            <a class="btn btn-primary mb-1" href="{{ route('levels.subjects.create',$level->id) }}">
                <em data-feather='plus-circle'></em> اضافة مادة </a>
        </x-slot>

        <x-slot name="thead">
            <tr>
                <th scope="col">كود</th>
                <th scope="col">اسم المادة</th>
                <th scope="col">اسم المرحلة</th>
                <th scope="col">درجة النجاح</th>
                <th scope="col">الدرجة النهائية</th>
                <th scope="col">الاجراءات المتاحة</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach($subjects as $subject)
            <tr>
                <th scope="row">{{ $subject->id }}</th>
                <td>{{ $subject->subject_name }}</td>
                <td>{{ $subject->level_name }}</td>
                <td>{{ $subject->min_grade }}</td>
                <td>{{ $subject->max_grade }}</td>

                <td>
                    @can('levels-list')
                    <x-inputs.btn.view :route="route('levels.subjects.show',[$level->id,$subject->id])" />
                    @endcan

                    @can('levels-edit')
                    <x-inputs.btn.edit :route="route('levels.subjects.edit',[$level->id,$subject->id])" />
                    @endcan

                    @can('levels-delete')
                    <x-inputs.btn.delete :route="route('levels.subjects.destroy', [$level->id,$subject->id])" />
                    @endcan

                </td>
            </tr>
            @endforeach
            </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection