@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('home'), 'name' => "الرئيسية"],['link' => route('accounts.index'), 'name' => 'الحسابات'],['link' => route('accounts.index'), 'name' => 'حركة الصندوق']],['title'=> 'حركة الصندوق']];
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


@section('title', 'سجل حركة الصندوق')

@section('content')

<x-forms.search route="accounts.index">

    <div class="row mb-1">

        <div class="col-md">
            <x-inputs.select.generic :required="false" name="method_id" label="طريقة الدفع" :options="['' => 'جميع طرق السداد'] + App\Models\PaymentMethod::paymentMethods()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :selected="$year->id" :required="false" label="السنة الدراسية" name="academic_year_id" data-placeholder="اختر السنة الدراسية" :options="App\Models\AcademicYear::years()" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ من :" name="date_from" placeholder="yyyy-mm-dd" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ الي :" name="date_to" placeholder="yyyy-mm-dd" />
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
    <x-slot name="title"> {!! sprintf('حركة الصندوق خلال العام الدراسي <span class="text-danger">(%s)</span> - الفترة من <span class="text-danger">(%s)</span> الي <span class="text-danger">(%s)</span>',$year->year_name ,$date_from, $date_to) !!} </x-slot>

    <x-slot name="cardbody">{!! sprintf('معروض <span class="text-danger">(%s)</span> من <span class="text-danger">(%s)</span> عملية دفع مؤكدة - صفحة رقم <span class="text-danger">(%s)</span> من <span class="text-danger">(%s)</span> صفحة',$PaymentAttempts->count(),$PaymentAttempts->total() , $PaymentAttempts->currentPage(),$PaymentAttempts->lastPage()) !!} </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">م</th>
            <th scope="col">الطالب</th>
            <th scope="col">ولي الامر</th>
            <th scope="col">الصف</th>
            <th scope="col">خ.السداد</th>
            <th scope="col">الدفعة</th>
            <th scope="col">المبلغ</th>
            <th scope="col">عن طريق</th>
            <th scope="col">المرجع</th>
            <th scope="col">بواسطة</th>
            <th scope="col">التاريخ</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach($PaymentAttempts as $key => $PaymentAttempt)

        <th scope="row">
            {{ $PaymentAttempt->id }}
        </th>
        <td>{{ $PaymentAttempt->student_name }}</td>
        <td>{{ sprintf('%s (%s)',$PaymentAttempt->guardian_name,$PaymentAttempt->national_id) }}</td>
        <td>{{ sprintf('%s - %s - %s - %s',$PaymentAttempt->school_name , $PaymentAttempt->gender_name, $PaymentAttempt->grade_name, $PaymentAttempt->level_name) }}</td>
        <td>{{ $PaymentAttempt->plan_name }}</td>
        <td>{{ sprintf('%s (%s)',$PaymentAttempt->installment_name,$PaymentAttempt->year_name) }} </td>

        <td>{{ $PaymentAttempt->received_ammount }}</td>
        <td>{{ $PaymentAttempt->method_name }} {!! $PaymentAttempt->bank_name ? sprintf('<abbr title="رقم الحساب : %s">(%s)</abbr>',$PaymentAttempt->account_number,$PaymentAttempt->bank_name) : '' !!} {!! $PaymentAttempt->network_name ? sprintf('<abbr title="رقم الحساب : %s">(%s)</abbr>',$PaymentAttempt->network_account_number,$PaymentAttempt->network_name) : '' !!}</td>
        <td>@if(! empty($PaymentAttempt->attach_pathh) && Storage::disk('s3')->exists($PaymentAttempt->attach_pathh))
            <a class="btn btn-sm round btn-icon btn-warning" href="{{ Storage::disk('s3')->url($PaymentAttempt->attach_pathh) }}" target="_blank"><em data-feather='eye'></em></a>
            @else {{ $PaymentAttempt->reference }} @endif
        </td>
        <td>{{ $PaymentAttempt->admin_name }}</td>
        <td><abbr title="تاريخ التسجيل : {{ $PaymentAttempt->created_at->format('Y-m-d h:m:s') }}">{{ $PaymentAttempt->updated_at->format('m-d-Y') }}</abbr></td>

        </tr>
        @endforeach
        </tbody>
    </x-slot>

    <x-slot name="pagination">
        {{ $PaymentAttempts->appends(request()->except('page'))->links() }}
    </x-slot>

</x-ui.table>

<div class="col-lg-12 col-12">
    <div class="card card-statistics">
        <div class="card-header">
            <h4 class="card-title">الاحصائيات</h4>
            <div class="d-flex align-items-center">
                <p class="card-text me-25 mb-0">تم التحديث في {{ Carbon\Carbon::now()->format('d-m-Y') }} عن الساعة {{ Carbon\Carbon::now()->format('H:m:s')  }}</p>
            </div>
        </div>
        <div class="card-body statistics-body">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                    <div class="d-flex flex-row">
                        <div class="avatar bg-light-primary me-2">
                            <div class="avatar-content">
                                <em data-feather="trending-up" class="avatar-icon"></em>
                            </div>
                        </div>
                        <div class="my-auto">
                            <h4 class="fw-bolder mb-0">{{ $PaymentAttempts->sum('received_ammount') }} ر.س</h4>
                            <p class="card-text font-small-3 mb-0">التحصيلات بالصفحة</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                    <div class="d-flex flex-row">
                        <div class="avatar bg-light-info me-2">
                            <div class="avatar-content">
                                <em data-feather="user" class="avatar-icon"></em>
                            </div>
                        </div>
                        <div class="my-auto">
                            <h4 class="fw-bolder mb-0">{{ $PaymentAttempts->count() }} حركة</h4>
                            <p class="card-text font-small-3 mb-0">عدد الحركات بالصفحة</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12 mb-2 mb-sm-0">
                    <div class="d-flex flex-row">
                        <div class="avatar bg-light-danger me-2">
                            <div class="avatar-content">
                                <em data-feather="box" class="avatar-icon"></em>
                            </div>
                        </div>
                        <div class="my-auto">
                            <h4 class="fw-bolder mb-0">{{ $PaymentAttempts->total() }} حركة</h4>
                            <p class="card-text font-small-3 mb-0">عدد الحركات</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="d-flex flex-row">
                        <div class="avatar bg-light-success me-2">
                            <div class="avatar-content">
                                <em data-feather="dollar-sign" class="avatar-icon"></em>
                            </div>
                        </div>
                        <div class="my-auto">
                            <h4 class="fw-bolder mb-0">{{ $sum_payments }} ر.س</h4>
                            <p class="card-text font-small-3 mb-0">اجمالي التحصيلات</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
