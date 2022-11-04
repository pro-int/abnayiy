@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('students.contracts.index',$student), 'name' => "الطالب : $student->student_name"], ['link' => route('students.contracts.transactions.index' ,[$student->id, $contract]), 'name' => "تعاقد #". $contract->year_name], ['link' => route('students.contracts.transportations.index' ,[$student->id, $contract]), 'name' => "ادارة خدمة النقل"]],['title' => 'تعديل خدمة النقل ']];
@endphp

@section('title', sprintf('ادارة خدمة النقل الطالب : %s', $student->student_name))

@section('content')

<!-- Striped rows start -->
<x-ui.table >
    <x-slot name="title">{!! sprintf('ادارة خدمة النقل الطالب : <span class="text-danger">%s - تعاقد رقم %s </span> <span> - للعام الدراسي %s</span> ', $student->student_name ,$contract->id,$contract->year_name) !!} </x-slot>
    <x-slot name="cardbody">يمكنك من خلال هذة الصفحة ادارة خدمة النقل للطلاب خلال العام الدراسي</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('students.contracts.transportations.create',[$student->id,$contract]) }}">
            <em data-feather='plus-circle'></em> اضافة حدمة نقل </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الخطة</th>
            <th scope="col">الرسوم</th>
            <th scope="col">الضرائب</th>
            <th scope="col">الأجمالي</th>
            <th scope="col">طريقة الدفع</th>
            <th scope="col">تاريخ الانتهاء</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تحديث</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach ($transportations as $transportation)
        <tr>
            <th>{{ $transportation->id }}</th>
            <td>{{ $transportation->transportation_type }}</td>
            <td>{{ $transportation->base_fees }}</td>
            <td>{{ $transportation->vat_amount }}</td>
            <td>{{ $transportation->total_fees }}</td>
            <td>{{ App\Models\Transportation::payment_plans($transportation->payment_type) }}</td>
            <td>{{ ! is_null($transportation->expire_at) ? $transportation->expire_at->format('Y-n-d') : 'غير محدد' }}</td>
            <td>{{ $transportation->admin_name }}</td>
            <td><abbr title="تاريخ التسجيل : {{ $transportation->created_at->format('Y-m-d h:m:s') }}">{{ $transportation->updated_at->diffforhumans() }}</abbr></td>

            <td>
            @can('transportations-list')
                <x-inputs.btn.view :route="route('students.contracts.transportations.show',[$student->id,$contract,$transportation->id])" />
                @endcan

                @can('transportations-edit')
                <x-inputs.btn.edit :route="route('students.contracts.transportations.edit',[$student->id,$contract,$transportation->id])" />
                @endcan

                @can('transportations-delete')
                <x-inputs.btn.delete :route="route('students.contracts.transportations.destroy',[$student->id,$contract,$transportation->id])" />
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
