@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('home'), 'name' => "الرئيسية"],['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year), 'name' => "$year->year_name"],['link' => route('years.classrooms.index',$year), 'name' => "الفصول الدراسية"]],['title'=> "الفصول الدراسية $year->year_name"]];
@endphp

@section('title', 'ادارة الفصول الدراسية')

@section('content')

<x-forms.search route="years.classrooms.index" :params="[$year]">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المدرسة" onLoad="{{ request('school_id') ? null : 'change'}}" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="القسم" name="gender_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="request('school_id') ? ['' => 'اختر القسم'] + App\Models\Gender::genders(true,request('school_id')) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المسار" name="grade_id" data-placeholder="اختر المسار" data-msg="رجاء اختيار المسار" :options="request('gender_id') ? ['' => 'اختر المسار'] + App\Models\Grade::grades(true,request('gender_id')) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="request('grade_id') ?  ['' => 'اختر الصف'] + App\Models\Level::levels(true,request('grade_id')) : []" />
        </div>
    </div>

</x-forms.search>


<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">الفصول الدراسية للعام {{ $year->year_name }}</x-slot>
    <x-slot name="cardbody">قائمة الفصول المسجلة بالمدرسة خلال العام الدراسي .. يمكن لكل طالب الألتحاق بفصل دراسي واحد فقط خلال العام الدراسي </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('years.classrooms.create',$year) }}">
            <em data-feather='plus-circle'></em> اضافة فصل جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الفصل</th>
            <th scope="col">ألاسم في نور</th>
            <th scope="col">الصف</th>
            <th scope="col">المسار</th>
            <th scope="col">القسم</th>
            <th scope="col">المدرسة</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($classrooms as $class)
            <th scope="row">{{ $class->id }}</th>
            <td>{{ $class->class_name }}</td>
            <td>{{ $class->class_name_noor }}</td>
            <td>{{ $class->level_name }}</td>
            <td>{{ $class->grade_name }}</td>
            <td>{{ $class->gender_name }}</td>
            <td>{{ $class->school_name }}</td>

            <td>
                @can('classes-list')
                <x-inputs.btn.view :route="route('years.classrooms.show',[$year, $class->id])" />
                @endcan

                @can('classes-edit')
                <x-inputs.btn.edit :route="route('years.classrooms.edit',[$year, $class->id])" />
                @endcan

                @can('classes-delete')
                <x-inputs.btn.delete :route="route('years.classrooms.destroy', [$year, $class->id])" />
                @endcan

                @can('students-list')
                <x-inputs.btn.generic :route="route('years.classrooms.students.view',[$year, $class->id])">ادارة الطلاب</x-inputs.btn.generic>
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
