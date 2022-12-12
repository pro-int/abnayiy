@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('grades.index'), 'name' => "المسارات الدراسية"]],['title'=> 'المسارات الدراسية المسجلة']];
@endphp

@section('title', 'ادارة المسارات الدراسية')

@section('content')

<x-forms.search route="grades.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المدرسة" onLoad="{{ request('school_id') ? null : 'change'}}" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="القسم" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار القسم" :options="request('school_id') ? ['' => 'اختر القسم'] + App\Models\Gender::genders(true,request('school_id')) : []" />
        </div>
    </div>

</x-forms.search>

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">المسارات الدراسية </x-slot>
    <x-slot name="cardbody">قائمة المسارات الدراسية المسجلة بالمدرسة .. {{ isset($type) ?  'االمسارات الدراسية  الخاصة بالنظام : ' . $type->school_name  : 'المسارات الدراسية (بنين - بنات - مشترك)' }} </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('grades.create') }}">
            <em data-feather='plus-circle'></em> اضافة مسار جديدة </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">المسار</th>
            <th scope="col">القسم</th>
            <th scope="col">المدرسة</th>
            <th scope="col">الحالة</th>
            <th scope="col" style="min-width:280px;">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($grades as $grade)
            <th scope="row">{{ $grade->id }}</th>
            <td>{{ $grade->grade_name }}</td>
            <td>{{ $grade?->gender?->gender_name }}</td>
            <td>{{ $grade?->gender?->school?->school_name }}</td>

            <td>{!! isActive($grade->active) !!}</td>
            <td>
                @can('grades-list')
                <x-inputs.btn.view :route="route('grades.show',$grade->id)" />
                @endcan

                @can('grades-edit')
                <x-inputs.btn.edit :route="route('grades.edit',$grade->id)" />
                @endcan

                @can('grades-delete')
                <x-inputs.btn.delete :route="route('grades.destroy', $grade->id)" />
                @endcan

                @can('semesters-list')
            <x-inputs.btn.generic :route="route('levels.index', ['grade_id' => $grade->id])">الصفوف</x-inputs.btn.generic>
            @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
