@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('coupons.index'), 'name' => 'قسائم الخصم']],['title'=> 'القسائم']];
@endphp

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection


@section('title', 'قسائم الخصم')


@section('content')
<!-- Striped rows start -->
<x-forms.search route="coupons.index">
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
            <x-inputs.select.generic  :required="false" select2="" label="نوع القسيمة" name="classification_id" data-placeholder="اختر نوع القسيمة" data-msg="رجاء اختيار نوع القسيمة" :options="['' => 'جميع القسائم','all' => 'قسائم عامة']+ getCouponClassification()" />
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المدرسة" onLoad="{{ request('school_id') ? null : 'change'}}" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="القسم" name="gender_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="request('school_id') ? ['' => 'اختر القسم'] + App\Models\Gender::genders(true,request('school_id')) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المسار" name="grade_id" data-placeholder="اختر المسار" data-msg="رجاء اختيار المسار" :options="request('gender_id') ? ['' => 'اختر المسار'] + App\Models\Grade::grades(true,request('gender_id')) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="request('grade_id') ?  ['' => 'اختر الصف'] + App\Models\Level::levels(true,request('grade_id')) : []" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ من :" name="date_from" placeholder="yyyy-mm-dd" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ الي :" name="date_to" placeholder="yyyy-mm-dd" />
        </div>
    </div>

</x-forms.search>

<x-ui.table>
    <x-slot name="title">قسائم الخصم </x-slot>
    <x-slot name="cardbody">قسائم الخصم تسمح لأولياء الأمور بالحصول علي مزيد من الخصومات اثناء الدفع ..</x-slot>

    @can('discounts-create')
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('coupons.create') }}">
            <em data-feather='plus-circle'></em> اضافة قسيمة جديدة </a>
    </x-slot>
    @endcan

    <x-slot name="thead">
        <tr>
            <th scope="col">#</th>
            <th scope="col">نوع القسيمة</th>
            <th scope="col">الرمز</th>
            <th scope="col">التصنيف </th>
            <th scope="col">الصف الدراسي</th>
            <th scope="col">الرصيد</th>
            <th scope="col">المستخدم</th>
            <th scope="col">تاريخ الانتهاء</th>
            <th scope="col">تاريخ الاستخدام</th>
            <th scope="col">الحالة</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تعديل</th>
            <th scope="col" style="min-width:180px;">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach($coupons as $coupon)
        <tr>
            <th scope="row">
                {{ $coupon->id }}
            </th>
            <td>{!! $coupon->getType() !!}</td>
            <td>{{ $coupon->code }}</td>
            <td>{!! getBadge([$coupon->color_class, $coupon->classification_name]) !!}</td>
            <td>{{ $coupon->level_name }} ({{ $coupon->year_name }})</td>
            <td>{{ $coupon->coupon_value }} ر.س</td>
            <td>{{ $coupon->used_value }} ر.س</td>
            <td>{{ $coupon->expire_at->format('Y-m-d') }}</td>
            <td>{{ $coupon->used_coupon ? $coupon->updated_at : 'لم يستخدم' }}</td>

            <td>{{ $coupon->active ? 'مفعل' : 'غير مفعل' }}</td>
            <td>{{ $coupon->admin_name }}</td>

            <td><abbr title="تاريخ التسجيل : {{ $coupon->created_at->format('Y-m-d h:m:s') }}">{{ $coupon->updated_at->diffforhumans() }}</abbr></td>

            <td>
                @can('discounts-list')
                <x-inputs.btn.view :route="route('coupons.show', $coupon->id)" />
                @endcan


                @if($coupon->used_value == 0)
                @can('discounts-edit')
                <x-inputs.btn.edit :route="route('coupons.edit', $coupon->id)" />
                @endcan

                @can('discounts-delete')
                <x-inputs.btn.delete :route="route('coupons.destroy', $coupon->id)" />
                @endcan

                @endif

            </td>
        </tr>
        @endforeach
    </x-slot>
    <x-slot name="pagination">
        {{ $coupons->appends(request()->except('page'))->links() }}
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
