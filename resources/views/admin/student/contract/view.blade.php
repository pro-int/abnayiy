@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
    <div class="pair_header">
        <h4>تفاصيل دفعات العقد رقم #{{ $contract->id . ' - اسم الطالب : ' . $contract->student_name  .' - السنة الدراسية ' . $contract->year_name}}</h4>

    </div>

    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">كود</th>
                <th scope="col">الدفعة</th>
                <th scope="col">الفئة</th>
                <th scope="col">الفترة</th>
                <th scope="col">الاساسي</th>
                <th scope="col">خ.فترة</th>
                <th scope="col">خ.قسيمة</th>
                <th scope="col">الضرائب</th>
                <th scope="col">الأجمالي</th>
                <th scope="col">المدفوع</th>
                <th scope="col">المتبقي</th>
                <th scope="col">تاريخ الدفع</th>
                <th scope="col">طريقة الدفع</th>
                <th scope="col">اخر تحديث</th>
                <th scope="col">الاجراءات المتاحة</th>
            </tr>
        </thead>

        <tbody>
            @foreach($transactions as $key => $transaction)
            <tr class="table-light">
                <th scope="row">
                    {{ $transaction->id }}
                </th>
                <td>{{ $transaction->installment_name }}</td>
                <td><span class="badge badge-{{ $transaction->color }}">{{ $transaction->category_name }}</span></td>
                <td>{{ $transaction->period_name }}</td>
                <td>{{ $transaction->amount_before_discount }}</td>
                <td>{{ $transaction->period_discount }} <br> ( {{$transaction->discount_rate}} %)</td>
                <td>{{ $transaction->coupon_discount }} ({{ $transaction->coupon }})</td>
                <td>{{ $transaction->vat_amount }}</td>
                <td>{{ $transaction->amount_after_discount }}</td>
                <td>{{ $transaction->paid_amount }}</td>
                <td>{{ $transaction->residual_amount }}</td>
                <td>{{ $transaction->payment_date ? 'تم الدفع' . $transaction->payment_date : 'يجب الدفع قبل' . $transaction->payment_due }}</td>
                <td>{{ $transaction->payment_getaway }}</td>

                <td><abbr title="تاريخ التسجيل : {{ $transaction->created_at->format('Y-m-d h:m:s') }}">{{ $transaction->updated_at->diffforhumans() }}</abbr></td>
                <td>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            اجراء
                        </button>
                        <div class="dropdown-menu text-end" aria-labelledby="btnGroupDrop1">
                            @can('accuonts-list')
                            <a class="dropdown-item" href="{{route('students.contracts.transactions.attempts.index',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id]) }}">سجل محاولات الدفع</a>
                            @endcan
                            @if(!$transaction->payment_status)
                            @can('accuonts-list')

                            <a class="dropdown-item" href="{{ route('students.contracts.transactions.create',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id]) }}">اضافة دفعة جديدة</a>
                            @endcan
                            @endif

                        </div>
                    </div>
                </td>

            </tr>
            @endforeach

            <!-- <th scope="row">
                    <img src="./assets/profile.png" alt="profile" width="40" height="40" class="profile-image" />
                </th> -->
        </tbody>
    </table>
</div>

@endsection