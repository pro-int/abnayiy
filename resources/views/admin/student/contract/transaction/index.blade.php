@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$contract->student_id), 'name' => $contract->student_name],['link' => route('students.contracts.index',$contract->student_id), 'name' => 'التعاقدات'],['link' => route('students.contracts.index',[$contract->student_id,$contract->id]), 'name' => 'تعاقد '.$contract->year_name]],['title'=> 'دفعات التعاقد رقم #'. $contract->id]];
@endphp

@section('title', 'دفعات التعاقد رقم #'. $contract->id)


@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">تفاصيل دفعات العقد رقم #{{ $contract->id }} - {!! $contract->getStatus() !!}</x-slot>
    <x-slot name="cardbody"> {{ 'اسم الطالب : ' . $contract->student_name  .' - السنة الدراسية ' . $contract->year_name}} </x-slot>

    @can('transportations-list')
    <x-slot name="button">
        <a class="btn btn-outline-danger mb-1" href="{{ route('students.contracts.transportations.index', [$contract->student_id,$contract->id]) }}">
            <em data-feather='home'></em> ادارة خدمة النقل </a>
        </x-slot>
        @endcan

    <x-slot name="thead">
        <tr>
            <th style="min-width: 180px;" scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">الدفعة</th>
            <th scope="col">الاساسي</th>
            <th scope="col">الضرائب</th>
            <th scope="col">خ.فترة</th>
            <th scope="col">خ.قسيمة</th>
            <th scope="col">الأجمالي</th>
            <th scope="col">المدفوع</th>
            <th scope="col">المتبقي</th>
            <th scope="col">تاريخ الدفع</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تحديث</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach($transactions as $key => $transaction)
        <td>
            @can('accuonts-list')
            <x-inputs.btn.view :route="route('students.contracts.transactions.attempts.index',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id])" />
            @endcan

            @if(!$transaction->payment_status)
            @can('accuonts-list')
            <x-inputs.btn.generic icon="plus" :route="route('students.contracts.transactions.attempts.create',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id])" title="اضافة دفعة جديدة" />
            @endcan
            @endif


        </td>

        <th scope="row">
            {{ $transaction->id }}
        </th>
        <td>{{ $transaction->installment_name }}</td>
        <td>{{ round($transaction->amount_before_discount, 2) }}</td>
        <td>{{ round($transaction->vat_amount,2) }}</td>
        <td>{{ round($transaction->period_discount,2) }}</td>
        <td>{{ round($transaction->coupon_discount,2) }}</td>
        <td>{{ round($transaction->amount_after_discount + $transaction->vat_amount, 2) }}</td>
        <td>{{ round($transaction->paid_amount, 2) }}</td>
        <td>{{ round($transaction->residual_amount, 2) }}</td>
        <td>{{ $transaction->payment_status && $transaction->payment_date ? 'تم الدفع' . $transaction->payment_date : 'يجب الدفع قبل' . $transaction->payment_due }}</td>
        <td>{{ $transaction->admin_name }}</td>

        <td><abbr title="تاريخ التسجيل : {{ $transaction->created_at->format('Y-m-d h:m:s') }}">{{ $transaction->updated_at->diffforhumans() }}</abbr></td>


        </tr>
        @endforeach
        </tbody>
    </x-slot>

</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection