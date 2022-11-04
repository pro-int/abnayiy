@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$student->id), 'name' => $student->student_name],['link' => route('students.contracts.index',[$student->id,$contract]), 'name' => 'تعاقد #'.$contract],['link' => route('students.contracts.transactions.index',[$student->id,$contract,$transaction->id]), 'name' => $transaction->installment_name]],['title'=> 'سجل الدفع #'. $transaction->id]];
@endphp

@section('title', 'سجل محاولات الدفع #'. $transaction->id)

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">سجل محاولات الدفع - للدفعة رقم #{{ $transaction->id }} - ({{$transaction->installment_name}})</x-slot>
    <x-slot name="cardbody"> محاولات الدفع للعقد رقم #{{ $contract . ' - اسم الطالب : ' . $student->student_name  .' - الدفعة : #' . $transaction->id . ' - '. $transaction->installment_name }} </x-slot>

    @can('accuonts-create')
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('students.contracts.transactions.attempts.create',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id]) }}">
            <em data-feather='plus-circle'></em> اضافة دفعة جديدة </a>
    </x-slot>
    @endcan

    <x-slot name="thead">
        <tr>
            <th style="min-width: 180px;" scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">الفترة</th>
            <th scope="col">وسيلة الدفع</th>
            <th scope="col">مبلغ الدفعه</th>
            <th scope="col">خ.قسيمة</th>
            <th scope="col">خ.فترة</th>
            <th scope="col">المحصل</th>
            <th scope="col">حالة الدفع</th>
            <th scope="col">المرجع</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تحديث</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach($PaymentAttempts as $key => $PaymentAttempt)
        <td>

            
            @can('accuonts-list')
            @if($PaymentAttempt->getRawOriginal('approved') == 0)
            <a class="btn btn-icon round btn-sm btn-outline-success" href="#" data-id="{{ $PaymentAttempt->id }}" id="confirmTransaction-btn" onclick="handelModelIdConfirmTrans(this)" data-bs-toggle="tooltip" data-bs-placement="right" title="تأكيد الدفعة">
                <me data-feather="check-square"></me>
            </a>

            <a class="btn btn-icon round btn-sm btn-outline-warning" href="#" data-id="{{ $PaymentAttempt->id }}" id="refuseTransaction-btn" onclick="handelModelId(this)" data-bs-toggle="tooltip" data-bs-placement="right" title="رفض الدفعة">
                <me data-feather="x-octagon"></me>
            </a>
            @elseif($PaymentAttempt->getRawOriginal('approved') == 1)
            <a class="btn btn-icon round btn-sm btn-outline-warning" href="{{ route('students.contracts.transactions.attempts.show',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id,'attempt' => $PaymentAttempt->id]) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="ايصال السداد">
                <me data-feather="image"></me>
            </a>
            
            @endif
            @endcan
            @can('accuonts-delete')
            <x-inputs.btn.delete :route="route('students.contracts.transactions.attempts.destroy', [$student->id,$contract,$PaymentAttempt->transaction_id,$PaymentAttempt->id])" />
            @endcan


        </td>

        <th scope="row">
            {{ $PaymentAttempt->id }}
        </th>
        <td>{{ $PaymentAttempt->period_name }}</td>
        <td>{{ $PaymentAttempt->method_name }} {!! $PaymentAttempt->bank_name ? sprintf('<abbr title="رقم الحساب : %s">(%s)</abbr>',$PaymentAttempt->account_number,$PaymentAttempt->bank_name) : '' !!} {!! $PaymentAttempt->network_name ? sprintf('<abbr title="رقم الحساب : %s">(%s)</abbr>',$PaymentAttempt->network_account_number,$PaymentAttempt->network_name) : '' !!}</td>
        <td>{{ $PaymentAttempt->requested_ammount }}</td>
        <td>{{ null !== $PaymentAttempt->coupon ? sprintf('خصم %s - (%s)',$PaymentAttempt->coupon_discount,$PaymentAttempt->coupon) : ''}}</td>
        <td>{{ $PaymentAttempt->period_discount }}</td>
        <td>{{ $PaymentAttempt->received_ammount }}</td>
        <td>{{ $PaymentAttempt->approved()}}</td> 
        <td>@if(in_array($PaymentAttempt->payment_method_id,[1,2,4]) && ! empty($PaymentAttempt->attach_pathh) && Storage::disk('public')->exists($PaymentAttempt->attach_pathh))
            <a class="btn btn-sm btn-info" href="{{ Storage::url($PaymentAttempt->attach_pathh) }}" target="_blank"><em  data-feather="share"></em></a>
            @else {{ $PaymentAttempt->reference }} @endif
        </td>
        <td>{{ $PaymentAttempt->admin_name }}</td>
        <td><abbr title="تاريخ التسجيل : {{ $PaymentAttempt->created_at->format('Y-m-d h:m:s') }}">{{ $PaymentAttempt->updated_at->diffforhumans() }}</abbr></td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>

</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->

<div class="modal fade add_back" id="confirmTransactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="res">

            <div class="modal-header">
                <h5 class="modal-title" id="confirmTransactionModal">تأكيد الدفعه</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" role="form" method="POST" name="transactionsconfirm" action="{{ route('paymentattempt.confirm') }}">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <input type="hidden" name="paymentAttempt_id" id="id">


                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <x-inputs.text.Input type="number" step=".01" label="المبلغ المدفوع" icon="dollar-sign" name="received_ammount" />
                        </div>
                    </div>

                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <label for="attach_pathh" class="form-label mb-1" for="attach_pathh">صوره الايصال </label>
                            <input type="file" class="form-control" id="attach_pathh" name="receipt" accept="image/png, image/jpeg ,application/pdf">
                        </div>
                    </div>


                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <label class="form-label mb-1" for="notifyuser"> ارسال اشعار </label>
                            <x-inputs.checkbox name="notifyuser">اعلام ولي الامر بأستلام الدفعة</x-inputs.checkbox>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        عوده
                    </button>
                    <button type="submit" class="btn btn-success">تأكيد قبول الدفعة</button>

                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade add_back" id="refuseTransactionModal" tabindex="-1" aria-labelledby="refusetransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="res">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmTransactionModal">تأكيد الدفعه</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form role="form" method="POST" name="transactionsrefuse" action="{{ route('paymentattempt.refuse') }}">
                <div class="modal-body">
                    @csrf
                    @method('put')

                    <input type="hidden" name="paymentAttempt_id" id="id">


                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <x-inputs.text.Input label="سبب الرفض" icon="type" name="reason" />
                        </div>
                    </div>

                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <label class="form-label mb-1" for="notifyuser2"> ارسال اشعار </label>
                            <x-inputs.checkbox name="notifyuser" id="notifyuser2">اعلام ولي الامر برفض الدفعة</x-inputs.checkbox>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        عوده
                    </button>
                    <button type="submit" class="btn btn-danger">تأكيد رفض الدفعة</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection