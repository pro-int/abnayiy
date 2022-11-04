@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
    <div class="pair_header">
        <h4> دفعات جديدة بأنتظار التأكيد</h4>
        <div class="btn-group pair_group_btn" role="group" aria-label="Basic outlined example">

        </div>
    </div>

    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">كود</th>
                <th scope="col">اسم الطالب</th>
                <th scope="col">خطة السداد</th>
                <th scope="col">مبلغ الدفعه</th>
                <th scope="col">اخر تحديث</th>
                <th style="min-width: 220px;" scope="col">الاجراءات المتاحة</th>
            </tr>
        </thead>

        <tbody>
            @foreach($PaymentAttempts as $key => $PaymentAttempt)
            <tr class="table-light">
                <th scope="row">
                    {{ $PaymentAttempt->id }}
                </th>
                <td>{{ $PaymentAttempt->student_name }}</td>
                <td>{{ $PaymentAttempt->plan_name }}</td>
                <td>{{ $PaymentAttempt->requested_ammount }}</td>

                <td><abbr title="تاريخ التسجيل : {{ $PaymentAttempt->created_at->format('Y-m-d h:m:s') }}">{{ $PaymentAttempt->updated_at->diffforhumans() }}</abbr></td>
                <td>

                    <a class="btn btn-sm btn-success" href="{{route('students.contracts.transactions.attempts.index',['student' => $PaymentAttempt->student_id,'contract' => $PaymentAttempt->contract_id,'transaction' => $PaymentAttempt->transaction_id]) }}">سجل محاولات الدفع</a>

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