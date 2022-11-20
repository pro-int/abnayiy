@extends('layouts.contentLayoutMaster')

@php
    $breadcrumbs = [[['link' => route('parent.showChildrens'), 'name' => "الأبناء"],['name'=> $contracts[0]->student_name]],['title'=> 'معلومات الطالب']];
@endphp

@section('title', 'ادارة تعاقدات الطالب')


@section('content')

    <!-- Striped rows start -->
    <div class="row match-height">
        @foreach ($contracts as $contract)
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card card-profile">
                    <div class="card-body">
                        <h1 name="title" class="text-primary">{{ \Carbon\Carbon::parse($contract->created_at)->year >= \Carbon\Carbon::now()->year? "العقد الساري" : "العقد المنتهي"  }}</h1>
                        <x-ui.table>
                            <x-slot name="tbody">
                                <tr>
                                    <th>كود</th>
                                    <th>{{ $contract->id }}</th>
                                </tr>
                                <tr>
                                    <th>السنة الدراسية</th>
                                    <th>{{ $contract->year_name }}</th>
                                </tr>
                                <tr>
                                    <th>الفصول المسجلة</th>
                                    <th>{{ count($contract->applied_semesters) }}</th>
                                </tr>
                                <tr>
                                    <th>الصف الدراسي</th>
                                    <th>{{ $contract->level_name }}</th>
                                </tr>
                                <tr>
                                    <th>النتيجة</th>
                                    <th>{!! $contract->getExamResult() !!}</th>
                                </tr>
                                <tr>
                                    <th>خطة الدفع</th>
                                    <th>{{ $contract->plan_name }} ({{ $contract->transactions->count() }} دفعة)</th>
                                </tr>
                                <tr>
                                    <th>الرسوم الداراسية</th>
                                    <th>{{ $contract->tuition_fees }}</th>
                                </tr>
                                <tr>
                                    <th>خصم فترة</th>
                                    <th>{{ $contract->period_discounts }}</th>
                                </tr>
                                <tr>
                                    <th>كوبون</th>
                                    <th>{{ $contract->coupon_discounts }}</th>
                                </tr>
                                <tr>
                                    <th>النقل</th>
                                    <th>{{ $contract->bus_fees }}</th>
                                </tr>
                                <tr>
                                    <th>الضرائب</th>
                                    <th>{{ $contract->vat_amount }} ({{ $contract->vat_rate }}%)</th>
                                </tr>
                                <tr>
                                    <th>مديونيات</th>
                                    <th>{{ $contract->debt }}</th>
                                </tr>
                                <tr>
                                    <th>الأجمالي</th>
                                    <th>{{ $contract->total_fees }}</th>
                                </tr>
                                <tr>
                                    <th>مسدد</th>
                                    <th>{{ $contract->total_paid }}</th>
                                </tr>
                                <tr>
                                    <th>متبقي</th>
                                    <th>{{ round($contract->total_fees - $contract->total_paid,2) }}</th>
                                </tr>
                                <tr>
                                    <th>خدمة النقل</th>
                                    <th>@if(count($contract->transportation)) مشترك @else غير مشترك @endif</th>
                                </tr>
                                <tr>
                                    <th>الدفع</th>
                                    <th>{!! ($contract->GetContractSpan()) !!}</th>
                                </tr>
                                <tr>
                                    <th>حالة التعاقد</th>
                                    <th>{!! $contract->getStatus() !!}</th>
                                </tr>
                                <tr>
                                    <th>بواسطة</th>
                                    <th>{{ $contract->admin_name }}</th>
                                </tr>
                                <tr>
                                    <th>اخر تحديث</th>
                                    <th><abbr title="تاريخ التسجيل : {{ $contract->created_at->format('Y-m-d h:m:s') }}">{{ $contract->updated_at->diffforhumans() }}</abbr></th>
                                </tr>
                                </tbody>
                            </x-slot>
                        </x-ui.table>

                        <hr class="mb-2" />
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('parent.contractTransaction', ["student_id" => $contract->student_id, "contract_id" => $contract->id]) }}">
                                <button type="button" class="btn btn-primary mb-1">انتقال لدفعات العقد</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>


    <x-ui.SideDeletePopUp />

    <!-- Striped rows end -->
@endsection
