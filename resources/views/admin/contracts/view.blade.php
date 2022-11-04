@extends('layouts/contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('contracts.all'), 'name' => "التعاقدات"],['link'=> route('students.show',$student->id),'name'=> "الطالب : $student->student_name"],['name' => 'التعاقد']],['title'=> 'مشاهدة التعاقد']];
@endphp


@section('title', "التعاقد رقم # $contract->id - $student->student_name")

@section('vendor-style')
<link rel="stylesheet" href="{{asset('vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" href="{{asset('css/base/pages/app-invoice.css')}}">
@endsection

@section('content')
<section class="invoice-preview-wrapper">
    <div class="row invoice-preview">
        <!-- Invoice -->
        <div class="col-xl-9 col-md-8 col-12">
            <div class="card invoice-preview-card">
                <div class="card-body invoice-padding pb-0">
                    <!-- Header starts -->
                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                        <div>
                            <div class="logo-wrapper">
                                <x-ui.logo />
                            </div>
                        </div>
                        <div class="mt-md-0 mt-2">
                            <h4 class="invoice-title">
                                <span class="invoice-number">رقم التعاقد #{{ $contract->id }}</span>
                            </h4>
                            <div class="invoice-date-wrapper">
                                <p class="invoice-date-title">تاريخ التعاقد :</p>
                                <p class="invoice-date"> {{ $contract->created_at->format('Y-m-d') }}</p>
                            </div>
                            <div class="invoice-date-wrapper">
                                <p class="invoice-date-title">اخر تحديث :</p>
                                <p class="invoice-date"> {{ $contract->updated_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row invoice-spacing">
                        <x-ui.divider>بيانات التعقد</x-ui-divider>

                            <div class="col-xl-6 p-0">
                                <table>
                                    <tbody>

                                        <tr>
                                            <td class="pe-2 fw-bolder">رقم العقد :</td>
                                            <td><span class="fw-bold">{{ $contract->id }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">العام الدراسي :</td>
                                            <td>{{ $contract->year_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">الصف الدراسي :</td>
                                            <td>{{ sprintf('%s - %s - %s - %s',$contract->school_name,$contract->gender_name,$contract->grade_name,$contract->level_name) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">شروط التعاقد :</td>
                                            <td>{{ $contract->version }} <a href="{{ route('contract_terms.show',$contract->terms_id) }}"> معاينة </a></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">الفصول المسجلة :</td>
                                            <td>{{ count($contract->applied_semesters) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">خطة الدفع :</td>
                                            <td>{{ $contract->plan_name }}</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <div class="col-xl-6 p-0">
                                <table>
                                    <tbody>

                                        <tr>
                                            <td class="pe-2 fw-bolder">رسوم الدراسة :</td>
                                            <td> {{ $contract->tuition_fees }} ر.س </td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">رسوم النقل :</td>
                                            <td> {{ $contract->bus_fees ? $contract->bus_fees . ' ر.س' : 'غير مشترك' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">الضرائب :</td>
                                            <td>{{ $contract->vat_rate ? $contract->vat_amount . 'ر.س' : 'لا يوجد ' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">الخصومات :</td>
                                            <td>{{ $contract->period_discounts +  $contract->coupon_discounts }} ر.س</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">المدفوع :</td>
                                            <td>{{ $contract->total_paid }} ر.س</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">المتبقي :</td>
                                            <td>{{ $contract->total_fees - $contract->total_paid  . ' ر.س' }}</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                    </div>
                    <!-- Header ends -->
                </div>

                <!-- Address and Contact starts -->
                <div class="card-body invoice-padding pt-0">
                    <div class="row invoice-spacing">

                        <x-ui.divider> الــطــالــب</x-ui-divider>

                            <div class="col-xl-6 p-0">
                                <h4 class="text-primary fw-600"> الطالب :</h4>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-2 fw-bolder">اسم الطالب :</td>
                                            <td><span class="fw-bold">{{ $student->student_name }}</span> ({{ $student->gender_type ? 'ذكر' : 'انثي' }})</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">الجنسية :</td>
                                            <td>{{ $student->nationality_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">رقم الهوية :</td>
                                            <td>{{ $student->national_id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">تاريخ الميلاد :</td>
                                            <td>{{ $student->birth_date }} ({{ !empty($student->birth_place) ? $student->birth_place : 'مكان الولارد غير محدد' }})</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">الرعاية :</td>
                                            <td>{{ $student->student_care ? 'الطالب يحتاج الي رعاية' : 'لا يحتاج الي رعاية' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xl-6 p-0 ">
                                <h4 class="text-primary fw-600"> ولي الامر :</h4>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-2 fw-bolder">الاسم :</td>
                                            <td><span class="fw-bold">{{ sprintf('%s %s',$guardian->first_name,$guardian->last_name) }}</span> <span class="badge bg-{{ $guardian->color}}">{{ $guardian->category_name }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">رقم الهوية :</td>
                                            <td>{{ $guardian->national_id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">رقم الجوال :</td>
                                            <td>{{ $guardian->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">الجنسية :</td>
                                            <td>{{ $guardian->nationality_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-2 fw-bolder">العنوان :</td>
                                            <td>{{ $guardian->address }} {{ $guardian->city_name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            @if($transportation)
                            <x-ui.divider>خدمة النقل </x-ui-divider>
                                <div class="col-xl-6 p-0">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="pe-2 fw-bolder">الخدمة :</td>
                                                <td><span class="fw-bold">{{ $transportation->transportation_type }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="pe-2 fw-bolder">الاشتراك :</td>
                                                <td>{{ App\Helpers\Helpers::payment_plans($transportation->payment_type) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="pe-2 fw-bolder">العنوان :</td>
                                                <td>{{ $transportation->address }}</td>
                                            </tr>
                                            <tr>
                                                <td class="pe-2 fw-bolder">تاريخ الأنتهاء :</td>
                                                <td>{{ $transportation->expire_at }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                    </div>
                </div>
                <!-- Address and Contact ends -->

                <!-- Invoice Description starts -->
                <x-ui.divider>دفعات التعاقد </x-ui-divider>


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-info">
                                <tr>
                                    <th class="py-1">الدفعة</th>
                                    <th class="py-1">القيمة</th>
                                    <th class="py-1">المدفوع</th>
                                    <th class="py-1">المتبقي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contract->transactions as $transaction)
                                <tr>
                                    <td class="py-1">
                                        <span class="fw-bold">{{ $transaction->installment_name }} </span>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">{{ $transaction->amount_after_discount + $transaction->vat_amount }} ر.س</span>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">{{ $transaction->paid_amount }} ر.س</span>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">{{ $transaction->residual_amount }} ر.س</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body invoice-padding pb-0">
                        <div class="row invoice-sales-total-wrapper">
                            <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                <p class="card-text mb-0">
                                    <span class="fw-bold"> تنوية :</span> <span class="ms-75">الرسوم الموضحة اعلان هي الرسوم بعد الخصم</span>
                                </p>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                <div class="invoice-total-wrapper">
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">جمالي الرسوم:</p>
                                        <p class="invoice-total-amount">{{$contract->total_fees }} ر.س</p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">الخصومات :</p>
                                        <p class="invoice-total-amount">{{ $contract->period_discounts + $contract->coupon_discounts }} ر.س</p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">الضرائب :</p>
                                        <p class="invoice-total-amount">{{ $contract->vat_amount }} ر.س</p>
                                    </div>
                                    <hr class="my-50" />
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">الأجمالي :</p>
                                        <p class="invoice-total-amount">{{$contract->total_fees }} ر.س</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Description ends -->

                    <hr class="invoice-spacing" />

                    <!-- Invoice Note starts -->
                    <div class="card-body invoice-padding pt-0">
                        <div class="row">
                            <div class="col-12">

                            </div>
                        </div>
                    </div>
                    <!-- Invoice Note ends -->
            </div>
        </div>
        <!-- /Invoice -->

        <!-- Invoice Actions -->
        <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary w-100 mb-75" data-bs-toggle="modal" data-bs-target="#send-invoice-sidebar">
                        ارسال العقد
                    </button>
                    <button class="btn btn-outline-secondary w-100 btn-download-invoice mb-75">تحميل</button>
                    <a class="btn btn-outline-secondary w-100 mb-75" href="{{ route('students.contracts.show', ['student' => $contract->student_id ,'contract' => $contract->id ,'type' => 'view']) }}" target="_blank"> اطلاع علي العفد</a>
                    <a class="btn btn-outline-secondary w-100 mb-75" href="{{ route('students.contracts.show', ['student' => $contract->student_id ,'contract' => $contract->id ,'type' => 'pdf']) }}" target="_blank"> نسخة PDF </a>
                    <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#add-payment-sidebar">
                        دفعة جديدة
                    </button>
                </div>
            </div>
        </div>
        <!-- /Invoice Actions -->
    </div>
</section>

<!-- Send Invoice Sidebar -->
<div class="modal modal-slide-in fade" id="send-invoice-sidebar" aria-hidden="true">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">
                    <span class="align-middle">ارسال العقد</span>
                </h5>
            </div>
            <div class="modal-body flex-grow-1">
                <form>
                    <div class="mb-1">
                        <label for="invoice-from" class="form-label">من</label>
                        <input type="text" class="form-control" id="invoice-from" value="shelbyComapny@email.com" placeholder="company@email.com" />
                    </div>
                    <div class="mb-1">
                        <label for="invoice-to" class="form-label">الي</label>
                        <input type="text" class="form-control" id="invoice-to" value="qConsolidated@email.com" placeholder="company@email.com" />
                    </div>
                    <div class="mb-1">
                        <label for="invoice-subject" class="form-label">عنوان الرسالة</label>
                        <input type="text" class="form-control" id="invoice-subject" value="Invoice of purchased Admin Templates" placeholder="Invoice regarding goods" />
                    </div>
                    <div class="mb-1">
                        <label for="invoice-message" class="form-label">نص الرسالة</label>
                        <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="11" placeholder="الرسالة ...">

                        </textarea>
                    </div>
                    <div class="mb-1">
                        <span class="badge badge-light-primary">
                            <i data-feather="link" class="me-25"></i>
                            <span class="align-middle">العقد مرفق</span>
                        </span>
                    </div>
                    <div class="mb-1 d-flex flex-wrap mt-2">
                        <button type="button" class="btn btn-primary me-1" data-bs-dismiss="modal">ارسال</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">الغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Send Invoice Sidebar -->

<!-- Add Payment Sidebar -->
<div class="modal modal-slide-in fade" id="add-payment-sidebar" aria-hidden="true">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">
                    <span class="align-middle">Add Payment</span>
                </h5>
            </div>
            <div class="modal-body flex-grow-1">
                <form>
                    <div class="mb-1">
                        <input id="balance" class="form-control" type="text" value="Invoice Balance: 5000.00" disabled />
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="amount">Payment Amount</label>
                        <input id="amount" class="form-control" type="number" placeholder="$1000" />
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="payment-date">Payment Date</label>
                        <input id="payment-date" class="form-control date-picker" type="text" />
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="payment-method">Payment Method</label>
                        <select class="form-select" id="payment-method">
                            <option value="" selected disabled>Select payment method</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Debit">Debit</option>
                            <option value="Credit">Credit</option>
                            <option value="Paypal">Paypal</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="payment-note">Internal Payment Note</label>
                        <textarea class="form-control" id="payment-note" rows="5" placeholder="Internal Payment Note"></textarea>
                    </div>
                    <div class="d-flex flex-wrap mb-0">
                        <button type="button" class="btn btn-primary me-1" data-bs-dismiss="modal">Send</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Payment Sidebar -->
@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
@endsection