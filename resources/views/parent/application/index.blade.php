@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('applications.index'), 'name' => "الطلبات"],['name'=> 'طلبات الألتحاق']],['title'=> 'ادارة الطلبات']];
@endphp

@section('title', 'طلبات الألتحاق')
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

<x-forms.search route="parent.applications.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input :required="false" icon="search" label="اليحث" name="search" placeholder="يمكنك البحث عن اسم او رقم جوال او هوية ويمكن البحث بالكود عن طريق اضافة = قبل لكمة البحث" />
        </div>
        <div class="col-md">
            <x-inputs.select.generic :required="false" label="السنة الدراسية" name="academic_year_id" data-placeholder="السنة الدراسية" :options="['' => 'جميع السنوات'] + App\Models\AcademicYear::years()" />
        </div>
        <div class="col-md">
            <x-inputs.select.generic label="حالة الطلب" name="status_id" data-placeholder="اختر حالة الطلب" :options="['all' => 'جميع الطلبات'] + App\Models\ApplicationStatus::Statuses()" />
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
    <x-slot name="title">طلبات الألتحاق بالمدرسة @if(request('myapplications')) <span class="text-danger">(المقدمة من حسابي)</span> @endif</x-slot>
    <x-slot name="cardbody">قائمة الطلبات المقدمة  .. {{$applications->count()}} طلب</x-slot>

    <x-slot name="thead">
        <tr>
{{--            <th scope="col">الاجراءات</th>--}}
            <th scope="col">كود</th>
            <th scope="col">الاسم</th>
            <th scope="col">رقم الجوال
            <th scope="col">رقم الهوية</th>
            <th scope="col">الصف</th>
            <th scope="col">العام</th>
            <th scope="col">النقل</th>
            <th scope="col">حالة الطلب</th>
{{--            @can('accuonts-list')--}}
            <th scope="col">السداد</th>
{{--            @endcan--}}
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تعديل</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($applications as $key => $application)

        <th>{{ $application->id }}</th>
        <td>@if(!$application->contract) {{ $application->student_name }} @else <a href="#">{{ $application->student_name }}</a> @endif</td>
        <td>{{ $application->phone }}</td>
        <td>{{ $application->national_id }}</td>
        <td><abbr title="{{ sprintf('%s - %s - %s - %s',$application->school_name , $application->gender_name, $application->grade_name, $application->level_name) }}">{{ $application->level_name }}</abbr></td>
        <td>{{ $application->year_name }}</td>
        <td>{{ $application->transportation_type ?? 'لا يرغب' }}</td>
        <td><span class="badge bg-{{$application->color}}">{{ $application->status_name }}</span></td>
{{--        @can('accuonts-list')--}}
        @if($application->contract && $application->contract->total_paid > 0)
        <td><span class="badge bg-success">{{ $application->contract->total_paid  }} ر.س</span></td>
        @else
                    <td><span class="badge bg-danger">لم يسدد</span></td>
        @endif
{{--        @endcan--}}
        <td><abbr title="{{ $application->sales_id }}">{{ $application->salse_admin_name }}</abbr></td>
        <td><abbr title="{{ $application->created_at->format('Y-m-d H:m:s') }}">{{ $application->updated_at->format('Y-m-d H:m:s') }}</abbr></td>

        </tr>
        @endforeach
        </tbody>
    </x-slot>

    <x-slot name="pagination">
        {{ $applications->appends(request()->except('page'))->links() }}
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection

@section('page-modal')

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

@section('page-script')
@endsection
