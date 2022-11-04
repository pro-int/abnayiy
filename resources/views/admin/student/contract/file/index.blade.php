@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$contract->student_id), 'name' => $contract->student_name],['link' => route('students.contracts.index',$contract->student_id), 'name' => "تعاقدات الطالب"],['link' => route('students.contracts.files.index',[$contract->student_id,$contract->id]), 'name' => "مرفقات التعاقد"]],['title'=> 'ادارة مرفقات التعاقد']];
@endphp

@section('title', 'ادارة مرفقات تعاقدات الطالب')


@section('content')

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">{!! sprintf('مرفقات العقد رقم : <span class="text-danger">(%s)</span> - الطالب <span class="text-danger">(%s)</span> - العام الدراسي <span class="text-danger">(%s)</span>', $contract->id,$contract->student_name, $contract->year_name) !!}</x-slot>
    <x-slot name="cardbody"> قائمة بجميع مرفقات التعاقد  </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('students.contracts.files.create',[$contract->student_id,$contract->id]) }}">
            <em data-feather='plus-circle'></em> اضافة  ملف جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            
            <th scope="col">#</th>
            <th scope="col">نوع المرفق</th>
            <th scope="col">رابط الملف</th>
            <th scope="col">بواسطة</th>
            <th scope="col">تاريخ التحميل</th>
            <th scope="col">اخر تحديث</th>
            <th scope="col">الاجراءات</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($contract->files as $file)
        <th scope="row">
            {{ $file->id }}
        </th>
        <td>{!! $file->fileType() !!}</td>
        <td><x-inputs.btn.generic colorClass="success" icon="download" :route="Storage::disk('public')->url($file->file_path)"/></td>
        <td>{{ $file->admin_name }}</td>
        <td><abbr title="{{ $file->updated_at->format('Y-m-d h:m:s') }}">{{ $file->updated_at->diffforhumans() }}</abbr></td>
        <td><abbr title="{{ $file->created_at->format('Y-m-d h:m:s') }}">{{ $file->created_at->diffforhumans() }}</abbr></td>

        <td>
            
            @can('accuonts-list')
            <x-inputs.btn.delete :route="route('students.contracts.files.destroy', [$contract->student_id,$contract->id,$file->id])"/>
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
