@extends('layouts.contentLayoutMaster')

@php
    $breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$contract->student_id), 'name' => $contract->student_name],['link' => route('students.contracts.index',$contract->student_id), 'name' => 'التعاقدات'],['link' => route('students.contracts.index',[$contract->student_id,$contract->id]), 'name' => 'تعاقد '.$contract->year_name]],['title'=> 'دفعات التعاقد رقم #'. $contract->id]];
@endphp

@section('title', 'دفعات التعاقد رقم #'. $contract->id)


@section('content')

    <!-- Striped rows start -->
    <div class="row match-height">
        @foreach($transactions as $key => $transaction)
        <div class="col-lg-6 col-md-6 col-12">
                <div class="card card-profile">
                    <div class="card-body">
                        <x-ui.table>
                            <x-slot name="tbody">
                                    <tr>
                                        <th>كود</th>
                                        <th>{{ $transaction->id }}</th>
                                    </tr>
                                    <tr>
                                        <th>الدفعة</th>
                                        <th>{{ $transaction->installment_name }}</th>
                                    </tr>
                                    <tr>
                                        <th>الاساسي</th>
                                        <th>{{ round($transaction->amount_before_discount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>الضرائب</th>
                                        <th>{{ round($transaction->vat_amount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>خ.فترة</th>
                                        <th>{{ round($transaction->period_discount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>خ.قسيمة</th>
                                        <th>{{ round($transaction->coupon_discount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>الأجمالي</th>
                                        <th>{{ round($transaction->amount_after_discount + $transaction->vat_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>المدفوع</th>
                                        <th>{{ round($transaction->paid_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>المتبقي</th>
                                        <th>{{ round($transaction->residual_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>تاريخ الدفع</th>
                                        <th>{{ $transaction->payment_status && $transaction->payment_date ? 'تم الدفع' . $transaction->payment_date : 'يجب الدفع قبل' . $transaction->payment_due }}</th>
                                    </tr>
                                    <tr>
                                        <th>اخر تحديث</th>
                                        <th><abbr title="تاريخ التسجيل : {{ $transaction->created_at->format('Y-m-d h:m:s') }}">{{ $transaction->updated_at->diffforhumans() }}</abbr></th>
                                    </tr>
                                    </tbody>
                            </x-slot>
                        </x-ui.table>
                        <hr class="mb-2" />
                        @if(!$transaction->payment_status)
                        <div class="d-flex justify-content-center align-items-center">
                            <a href=" {{ route('parent.transactionPaymentAttempt', ['student' => $contract->student_id, 'contract' => $contract, 'transaction' => $transaction]) }}">
                                <button type="button" class="btn btn-primary mb-1">الدفع</button>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <x-ui.SideDeletePopUp />

    <!-- Striped rows end -->
@endsection
