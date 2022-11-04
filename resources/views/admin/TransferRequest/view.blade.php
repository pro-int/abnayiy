@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('transfers.index'), 'name' => "طلبات النقل"], ['link' => route('transfers.edit', $transfer->id), 'name' => " طلب رقم #$transfer->id"],['name'=> 'مشاهدة']],['title'=> 'ادارة طلب النقل']];
@endphp

@section('title', sprintf('مشاهدة الطلب رقم : %s | %s',$transfer->id , $transfer->student_name))

@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/katex.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/monokai-sublime.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/quill.snow.css'))}}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<!-- Page css files -->
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')

@component('components.forms.formCard',['title' => sprintf('طلب نقل الطالب (<span class="text-danger">%s</span>) الي الصف الدراسي (<span class="text-danger">%s</span>) - %s',$transfer->student_name, $transfer->new_level_name,$transfer->getStatus())])


{{ Form::model($transfer ,['route' => ['transfers.update',$transfer],'method'=> 'PUT' , 'class' => 'row','id' => 'adminform' , 'onsubmit' => 'showLoader()','enctype'=>"multipart/form-data"]) }}

<x-ui.divider>معلومات ولي الأمر</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input label="اسم ولي الأمر" name="guardian_name" :disabled="true" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="رقم الجوال" name="phone" :disabled="true" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="رقم الهوية" name="guardian_national_id" :disabled="true" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input label="الفئة" name="category_name" :disabled="true" />
        </div>
    </div>

    <x-ui.divider>معلومات الطالب</x-ui-divider>
        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.text.Input :disabled="true" icon="user" label="اسم الطالب" name="student_name" />
            </div>

            <div class="col-md">
                <x-inputs.text.Input :disabled="true" label="رقم الهوية" icon="file-text" name="national_id" />
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-md">
                <x-inputs.select.generic :disabled="true" label="جنسية الطالب" name="nationality_id" :options="App\Models\nationality::nationalities()" />
            </div>

            <div class="col-md">
                <x-inputs.text.Input :disabled="true" icon="cast" label="اخر مزامنة مع نور" name="last_noor_sync" :value="$transfer->last_noor_sync ?? 'لم يتم المزامنة'" />
            </div>
        </div>

        @if($transfer->total_debt)
        <x-ui.divider>مديونيات الطالب</x-ui-divider>

            <div class="row mb-1">
                <div class="col-md">
                    <x-inputs.text.Input label="المديونية الحالية" name="total_debt" :disabled="true" />
                </div>

                <div class="col-md">
                    <x-inputs.text.Input label="الحد الادني" name="minimum_debt" :disabled="true" />
                </div>

                <div class="col-md">
                    <x-inputs.text.Input label="المطلوب دفعة" name="dept_paid" :disabled="true" />
                </div>

                <div class="col-md">
                    <x-inputs.text.Input label="متبقي يرحل للعام القادم" name="dept_remain" :value="$transfer->total_debt - $transfer->dept_paid" :disabled="true" />
                </div>
            </div>
            @endif

            <x-ui.divider>خطة دفع الرسوم الدراسية</x-ui-divider>

                <div class="row mb-1">
                    <div class="col-md">
                        <x-inputs.select.generic :disabled="true" select2="" label="خطة الدفع" name="plan_id" data-placeholder="اختر خطة الدفع" data-msg="رجاء اختيار خطة الدفع" :options="App\Models\Plan::plans()" />
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md">
                        <x-inputs.text.Input label="الرسوم الدراسية" name="tuition_fee" :disabled="true" />
                    </div>

                    <div class="col-md">
                        <x-inputs.text.Input label="الضرائب" name="tuition_fee_vat" :disabled="true" />
                    </div>

                    <div class="col-md">
                        <x-inputs.text.Input label="خصم الفترة" name="period_discount" :disabled="true" />
                    </div>

                    <div class="col-md">
                        <x-inputs.text.Input label="الرسوم بعد الخصم و الضرائب" name="final_tuition_fee" :value="$transfer->tuition_fee + $transfer->tuition_fee_vat -  $transfer->period_discount" :disabled="true" />
                    </div>

                    <div class="col-md">
                        <x-inputs.text.Input label="الحد الأدني (بعد الخصم شامل الضرائب)" name="minimum_tuition_fee" :disabled="true" />
                    </div>
                </div>

                <x-ui.divider>خطة النقل</x-ui-divider>
                    <div class="row mb-1">
                        <div class="col-md">
                            <x-inputs.select.generic :disabled="true" select2="" :required="false" label="'خطة النقل" name="transportation_id" data-placeholder="اختر النقل" data-msg="رجاء اختيار النقل" :options="['' => 'لا يرغب'] + App\Models\Transportation::transportations()" />
                        </div>

                        <div class="col-md">
                            <x-inputs.select.generic :disabled="true" select2="" :required="false" label="خطة دفع النقل" name="transportation_payment" data-placeholder="اختر خطة دفع النقل" data-msg="رجاء اختيار خطة دفع النقل" :options="['' => 'لا يرغب'] + App\Models\Transportation::payment_plans()" />
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md">
                            <x-inputs.text.Input label="رسوم النقل" name="bus_fees" :disabled="true" />
                        </div>

                        <div class="col-md">
                            <x-inputs.text.Input label="الضرائب علي خدمة النقل" name="bus_fees_vat" :disabled="true" />
                        </div>

                        <div class="col-md">
                            <x-inputs.text.Input label="اجمالي رسوم النقل" name="total_bas_fees" :value="$transfer->bus_fees + $transfer->bus_fees_vat" :disabled="true" />
                        </div>

                        @if($transfer->req_confirmation && in_array($transfer->status,['complete']))
                        <x-ui.divider color="warning">خطة السداد {{ $transfer->plan_name }} تتطلب سند امر</x-ui-divider>
                            <x-inputs.btn.generic colorClass="danger" icon="file" :route="route('students.contracts.files.index',[$transfer->student_id,$transfer->contract_id])">عرض الملفات المرفقة</x-inputs.btn.generic>
                            @endif
                            <x-ui.divider color="warning">تفاصيل السداد</x-ui-divider>

                                @php $hasFile = $transfer->payment_ref && Storage::disk('public')->exists($transfer->payment_ref) @endphp

                                @php $status = $transfer->getStatus(1); @endphp
                                <div>
                                    <div class="alert alert-{{ $status['class'] }}" role="alert">
                                        <h4 class="alert-heading">طلب {{ $status['status'] }}</h4>
                                    </div>
                                </div>

                                <div class="col-3">
                                    @if ($hasFile)
                                    <label class="form-label mb-1" for="confirmed"> ايصال السداد : </label>
                                    <a href="{{ Storage::disk('public')->url($transfer->payment_ref) }}" class="btn btn-outline-warning btn-sm round">
                                        <em data-feather="download" class="me-25"></em>
                                        <span>ايصال السداد</span>
                                    </a>
                                    @endif
                                </div>

                                <div class="col-12 text-center mt-2">
                                    <x-inputs.link route="transfers.index">عودة</x-inputs.link>
                                </div>



                                {!! Form::close() !!}

                                @endcomponent

                                @endsection

                                @section('vendor-script')
                                <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
                                <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
                                <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
                                <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
                                <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
                                <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
                                <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
                                @endsection

                                @section('page-script')
                                <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
                                <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

                                <script>
                                    function checkPaymentMethod() {
                                        let method_id = document.getElementById('method_id')
                                        let bank_id = document.getElementById('bank_id')
                                        bank_id.value = ''
                                        method_id.value == 1 ? bank_id.removeAttribute('disabled') : bank_id.setAttribute('disabled', 1)
                                    }

                                    checkPaymentMethod()
                                </script>
                                @endsection