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
                <th scope="col">الخصم</th>
                <th scope="col">بعد الخصم</th>
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
                <td>{{ round($transaction->amount_before_discount, 2) }}</td>
                <td>{{ $transaction->discount_amount }} ( {{$transaction->discount_rate}} %)</td>
                <td>{{ round($transaction->amount_after_discount,2) }}</td>
                <td>{{ round($transaction->paid_amount, 2) }}</td>
                <td>{{ round($transaction->amount_after_discount - $transaction->paid_amount, 2) }}</td>
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
                            <a class="dropdown-item" href="#">سجل محاولات الدفع</a>
                            @endcan
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