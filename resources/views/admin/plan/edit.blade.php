@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('plans.index'), 'name' => "خطط السداد"], ['link' => route('plans.edit',$plan), 'name' => "تعديل خطة السداد"]],['title'=> 'تعديل']];
@endphp

@section('title', 'ادارة خطط السداد')

@section('content')

@component('components.forms.formCard',['title' => sprintf('تعديل معلومات خطة السداد : <span class="text-danger"> %s </span>', $plan->plan_name)])

{!! Form::model($plan,['route' => ['plans.update',$plan],'method'=>'PUT' , 'onsubmit' => 'showLoader()']) !!}

<x-ui.divider>معلومات خطة السداد</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="tag" label="اسم خطة السداد" name="plan_name" placeholder="ادخل اسم خطة السداد" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic label="سياسة دفعة التعاقد" name="plan_based_on" :options="App\Models\Plan::PLAN_BASE" onchange="handelInputs(this)" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input type="number" icon="percent" label="قيمة دفعة التعاقد" name="down_payment" placeholder="رجاء ادخال قيمة دفعة التعاقد" />
        </div>

    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input type="text" label="Odoo ID" icon="anchor" name="odoo_id" placeholder="ادخل Odoo ID" data-msg="ادخل Odoo ID بشكل صحيح" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input type="text" label="Odoo Key" icon="anchor" name="odoo_key" placeholder="ادخل Odoo Key" data-msg="ادخل Odoo Key بشكل صحيح" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <span id="payment_due_determination_span" style="display: none;" data-bs-toggle="tooltip" class="text-danger" data-bs-placement="top" title="">
                <em data-feather="info"></em></span>
            <x-inputs.text.Input type="number" min="1" max="28" icon="calendar" label="موعد استحقاق الدفعات المتكررة" name="payment_due_determination" placeholder="اختر سياسة الدفعة المقدمة اولا .. " />
        </div>

        <div class="col-md">
            <span id="beginning_installment_calculation_span" style="display: none;" data-bs-toggle="tooltip" class="text-danger" data-bs-placement="top" title="
            إذا كان التعاقد قبل بداية السنة وتاريخ استخقاق القسط يوم 27 سيكون اول تاريخ لأستحقاق الأقساط
                27 في شهر ميلادي قبل أو بعد بداية السنة
                الدراسية أيهما أقرب.
                إذا كان التعاقد بعد بداية السنة: أول تاريخ
                27 ميلادي بشرط إتمام التعاقد قبل اليوم المحدد
                من نفس الشهر. وإلا يكون 27 الشهر التال">
                <em data-feather="info"></em></span>
            <x-inputs.text.Input type="number" icon="calendar" label="اصدار القسط في نفس الشهر في حالة التعاقد قبل يوم" name="beginning_installment_calculation" placeholder="في حالة التعاقد قبل يوم ؟ - سيتم مطالبة ولي الأمر بالقسط في نفس الشهر طبقا للتهيئة " />
        </div>

    </div>

    <div class="row mb-1">
        <div class="col-md">
            <label class="form-label mb-1" for="req_confirmation"> تتطلب سند امر </label>
            <x-inputs.checkbox name="req_confirmation"> تتطلب خطة الدفع سند امر</x-inpurs.checkbox>
        </div>

        <div class="col-md">
            <label class="form-label mb-1" for="fixed_discount"> خصومات الفترة ثابتة </label>
            <x-inputs.checkbox name="fixed_discount">خصومات نهائية اثناء التعاقد</x-inpurs.checkbox>
        </div>

        <div class="col-md">
            <label class="form-label mb-1" for="active"> الحالة </label>
            <x-inputs.checkbox name="active"> مفعل </x-inpurs.checkbox>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md-6">
            <x-ui.divider color="warning">وسائل الدفع المتاحة اثناء تجديد التعاقد</x-ui-divider>
                @foreach($methods as $method)
                <div class="col-md">
                    <x-inputs.checkbox id="contract_methods_{{$method->id}}" name="contract_methods[]" value="{{$method->id}}"> {{ $method->method_name }} </x-inpurs.checkbox>
                </div>
                @endforeach
        </div>

        <div class="col-md-6">
            <x-ui.divider color="warning">وسائل الدفع المتاحة بعد التعلقد</x-ui-divider>
                @foreach($methods as $method)
                <div class="col-md">
                    <x-inputs.checkbox id="transaction_methods_{{$method->id}}" name="transaction_methods[]" value="{{$method->id}}"> {{ $method->method_name }} </x-inpurs.checkbox>
                </div>
                @endforeach
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>تعديل خطة السداد</x-inputs.submit>
        <x-inputs.link route="plans.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection

    @section('page-script')
    <!-- Page js files -->
    <script>
        handelInputs(document.getElementById('plan_based_on'))

        function handelInputs(e) {
            if (e.value) {
                const down_payment = document.getElementById('down_payment')
                const payment_due_determination = document.getElementById('payment_due_determination')
                const beginning_installment_calculation = document.getElementById('beginning_installment_calculation')
                let payment_due_determination_span = document.getElementById('payment_due_determination_span')
                let beginning_installment_calculation_span = document.getElementById('beginning_installment_calculation_span')

                switch (e.value) {
                    case 'total':
                        down_payment.style = 'pointer-events: none;opacity: 0.4;';
                        payment_due_determination.style = 'pointer-events: none;opacity: 0.4;';
                        beginning_installment_calculation.style = 'pointer-events: none;opacity: 0.4;';
                        payment_due_determination_span.style = 'display:none;'

                        beginning_installment_calculation_span.style = 'display:none;'

                        down_payment.required = false
                        down_payment.value = 0;
                        payment_due_determination.required = false
                        payment_due_determination.value = ''
                        beginning_installment_calculation.value = ''
                        beginning_installment_calculation.required = false
                        break;
                    case 'semester':
                        down_payment.style = 'pointer-events: none;opacity: 0.4;';
                        payment_due_determination.style = '';
                        payment_due_determination.placeholder = 'قبل بداية الفصل الدراسي بـ ؟ يوم'

                        payment_due_determination_span.style = '';
                        payment_due_determination_span.setAttribute('title', "في حالة ادخال 10 - سيتم اعتبار تاريخ استحقاق الدفعة قبل الفصل الدراسي بـ 10 ايام ")

                        beginning_installment_calculation.style = 'pointer-events: none;opacity: 0.4;';
                        beginning_installment_calculation_span.style = 'display:none;'

                        down_payment.required = false
                        down_payment.value = 0;
                        payment_due_determination.required = true
                        beginning_installment_calculation.required = false
                        beginning_installment_calculation.value = ''

                        break;

                    default:
                        down_payment.style = '';
                        payment_due_determination.style = '';
                        payment_due_determination.placeholder = 'يوم ؟ من كل شهر ميلادي'

                        payment_due_determination_span.style = '';
                        payment_due_determination_span.setAttribute('title', "في حالة ادخال يوم 27 - سيكون تاريخ استحقاق القسط في27  من كل شهر ميلادي - الحد الأقصي هو يوم 28 في الشهر")

                        beginning_installment_calculation_span.style = '';

                        beginning_installment_calculation.style = ''

                        down_payment.required = true
                        payment_due_determination.required = true
                        beginning_installment_calculation.required = true

                        break;
                }
            }
        }
    </script>
    @endsection
