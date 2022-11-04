@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('coupons.index'), 'name' => 'قسائم الخصم'], ['link' => route('coupons.discount_report'), 'name' => 'تقرير القسائم']],['title'=> 'تقرير استخدام قسائم الخصم']];
@endphp

@section('title', 'تقرير استخدام قسائم الخصم')


@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection


@section('content')
<!-- Striped rows start -->

<x-forms.search route="coupons.discount_report">

    <div class="row mb-1">
        <div class="col-md-6">
            <x-inputs.text.Input :required="false" icon="search" label="اليحث" name="search" placeholder="يمكنك البحث بأستخدام كل او جزء من قسيمة الخصم" />
        </div>
        <div class="col-md-3">
            <x-inputs.select.generic :required="false" label="السنة الدراسية" name="academic_year_id" data-placeholder="السنة الدراسية" :options="['' => 'جميع السنوات'] + App\Models\AcademicYear::years()" />
        </div>
        <div class="col-md-3">
            <span id="special_span" style="display:none;" data-bs-toggle="tooltip" class="text-danger" data-bs-placement="top" title="لن يتم خصم قيمة القسيمة من الحد الأقصي للخصومات طبقا لأعدادات النظام">
                <em data-feather="info"></em></span>
            <x-inputs.select.generic :required="false" select2="" label="نوع القسيمة" name="classification_id" data-placeholder="اختر نوع القسيمة" data-msg="رجاء اختيار نوع القسيمة" :options="['' => 'جميع القسائم','all' => 'قسائم عامة']+ getCouponClassification()" />
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ الأستخدام (من):" name="date_from" placeholder="yyyy-mm-dd" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ الأستخدام (الي) :" name="date_to" placeholder="yyyy-mm-dd" />
        </div>
    </div>

    <x-slot name="export">
        <div class="btn-group">
            <button class="btn btn-outline-secondary waves-effect" name="action" type="submit" value="export_xlsx"><em data-feather='save'></em> اكسل</button>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button class="dropdown-item" name="action" type="submit" value="export_pdf"><em data-feather='save'></em> PDF</button>
            </div>
        </div>
    </x-slot>

</x-forms.search>

<x-ui.table>
    <x-slot name="title">{!! sprintf('تقرير استخدام قسائم الخصم عن الفترة من <span class="text-danger">(%s)</span> الي <span class="text-danger">(%s)</span> للعام الدراسي <span class="text-danger">(%s)</span>', request('date_from') ?? 'البداية', request('date_to') ?? 'النهاية', $year_name ?? 'جميع السنوات') !!} </x-slot>
    <x-slot name="cardbody"> استخدم البحث بالأعلي للبحث علي قسيمة محددة او قسيمة تبدا, تنتهي , تحتوي علي حروف محددة ..</x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">#</th>
            <th scope="col">اسم الدفعة</th>
            <th scope="col">قيمة الدفعة</th>
            <th scope="col">رمز القسيمة</th>
            <th scope="col">تصنيف القسيمة</th>
            <th scope="col">قيمة الخصم</th>
            <th scope="col">العام الدراسي</th>
            <th scope="col">ولي الأمر</th>
            <th scope="col">رقم الجوال</th>
            <th scope="col">بواسطة</th>
            <th scope="col">المرجع</th>
            <th scope="col">تاريخ الانشاء</th>
            <th scope="col">تاريخ الدفع</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach($payments as $payment)
        <tr>
            <th scope="row">
                {{ $payment->id }}
            </th>
            <td><a href="{{ route('students.contracts.transactions.attempts.index',[$payment->student_id, $payment->contract_id, $payment->transaction_id, $payment->id]) }}">{{ $payment->installment_name }}</a></td>
            <td>{{ $payment->received_ammount . ' ر.س' }}</td>
            <td>{{ $payment->coupon }}</td>
            <td>{!! getBadge([$payment->color_class ?? 'success',$payment->classification_name ?? 'خصومات عامة']) !!}</td>
            <td>{{ $payment->coupon_discount }}</td>
            <td>{{ $payment->year_name }}</td>
            <td>{{ $payment->guardian_name }}</td>
            <td>{{ $payment->phone }}</td>
            <td>{{ $payment->admin_name }}</td>
            <td>@if(in_array($payment->payment_method_id,[1,2]) && null !== $payment->attach_pathh)
                <a class="btn btn-sm btn-info" href="{{ asset('storage/'. $payment->attach_pathh) }}" target="_blank"><em data-feather="share"></em></a>
                @else {{ $payment->reference }} @endif
            </td>
            <td>{{ $payment->created_at }}</td>
            <td>{{ $payment->updated_at }}</td>
        </tr>
        @endforeach
    </x-slot>
    <x-slot name="pagination">
        {{ $payments->appends(request()->except('page'))->links() }}
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection