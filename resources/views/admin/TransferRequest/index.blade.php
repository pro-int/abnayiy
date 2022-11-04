@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('transfers.index'), 'name' => "طلبات تجديد التعاقد"],['name'=> 'طلبات تجديد التعاقد']],['title'=> 'ادارة طلبات تجديد التعاقد']];
@endphp

@section('title', 'طلبات تجديد التعاقد')

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

<x-forms.search route="transfers.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input :required="false" icon="search" label="اليحث" name="search" placeholder="يمكنك البحث عن اسم او رقم جوال او هوية ويمكن البحث بالكود عن طريق اضافة = قبل لكمة البحث" />
        </div>
        <div class="col-md">
            <x-inputs.select.generic :required="false" label="السنة الدراسية" name="academic_year_id" data-placeholder="السنة الدراسية" :options="['' => 'جميع السنوات'] + App\Models\AcademicYear::years()" />
        </div>
        <div class="col-md">
            <x-inputs.select.generic :required="false" label="طريقة السداد" name="payment_method_id" data-placeholder="اختر طريقة السداد" :options="['' => 'جميع طرق الدفع'] + paymentMethods(1)" />
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic :required="false" label="حالة الطلب" name="status_id" data-placeholder="اختر حالة الطلب" :options="['' => 'جميع الطبات' ,'new' => 'طلب جديد' ,'pending' => 'بأنتظار التأكيد' ,'complete' => 'مدفوع' ,'NoPayment' => 'فشل الدفع' ,'expired' =>  'منتهي الصلاحية']" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ من :" name="date_from" placeholder="yyyy-mm-dd" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ الي :" name="date_to" placeholder="yyyy-mm-dd" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <label class="form-label">خدمة النقل </label>
            <x-inputs.checkbox :required="false" name="transportation">يرغب في خدمة النقل</x-inputs.checkbox>
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

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">طلبات تجديد التعاقد واعادة القيد للعام الدراسي <span class="text-danger">({{ request()->filled('academic_year_id') ? 'المحدد ' : 'المتاح للتقديم ' }} {{ $year->year_name }})</span></x-slot>
    <x-slot name="cardbody">{!! sprintf('قائمة طلبات تجديد التعاقد و اعادة القيد المفدمة من اولياء الأمور .. معروض الطلبات من <span class="text-danger">%s</span> الي <span class="text-danger">%s</span> طلب من اجمالي <span class="text-danger">%s</span> طلب تجديد', $transfers->firstItem() ,$transfers->lastItem(), $transfers->total()) !!}</x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">اسم الطالب</th>
            <th scope="col">العام</th>
            <th scope="col">الصف</th>
            <th scope="col">ينتقل الي</th>
            <th scope="col">خطة السداد</th>
            <th scope="col">النقل</th>
            <th scope="col">طريقة الدفع</th>
            <th scope="col">الخصم ينتهي في</th>
            <th scope="col">حالة الطلب</th>
            <th scope="col">تاريخ الطلب</th>
            <th scope="col">اخر تعديل</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($transfers as $transfer)
        <tr>
            <td>
                @can('transfers-list')
                <x-inputs.btn.view :route="route('transfers.show',$transfer->id)" />
                @endcan

                @can('transfers-edit')
                <x-inputs.btn.edit :route="route('transfers.edit',$transfer->id)" />
                @endcan

                @can('transfers-delete')
                <x-inputs.btn.delete :route="route('transfers.destroy', $transfer->id)" />
                @endcan

            </td>
            <th>{{ $transfer->id }}</th>
            <td><a href="{{ route('students.contracts.index',$transfer->student_id) }}">{{ $transfer->student_name }}</a></td>
            <td>{{ $transfer->year_name }}</td>
            <td>{{ $transfer->level_name }}</td>
            <td>{{ $transfer->new_level_name }}</td>
            <td>{{ $transfer->plan_name }}</td>
            <td>{{ $transfer->transportation_id ? 'مشترك' : 'لا يرغب' }}</td>
            <td>{{ $transfer->method_name }} @if ($transfer->bank_name)({{ $transfer->bank_name }}) @endif</td>
            <td>{{ $transfer->due_date }}</td>
            <td>{!! $transfer->getStatus() !!}</td>
            <td><abbr title="{{ $transfer->created_at }}">{{ $transfer->created_at->format('d-m-Y') }}</abbr></td>
            <td><abbr title="{{ $transfer->updated_at }}">{{ $transfer->updated_at->format('d-m-Y') }}</abbr></td>
        </tr>
        @endforeach
    </x-slot>

    <x-slot name="pagination">
        {{ $transfers->appends(request()->except('page'))->links() }}
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