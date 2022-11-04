@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('appointments.sections.index'), 'name' => "مواعيد المقابلات"], ['link' => route('appointments.reserved.index'), 'name' => "المواعيد المحجوزة"]],['title'=> 'مواعيد المقابلات']];
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

@section('title', 'ادارة مواعيد المقابلات')

@section('content')

<x-forms.search route="appointments.reserved.index">
    <div class="row mb-1">

        <div class="col-md">
            <x-inputs.select.generic :required="false" label="جميع المكاتب" name="office_id" data-placeholder="جميع المكاتب" :options="['' => 'جميع المكاتب'] + App\Models\AppointmentOffice::offices()" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="التاريخ" name="selected_date" placeholder="yyyy-mm-dd" />
        </div>
    </div>

</x-forms.search>

<!-- Striped rows start -->
<x-ui.table :autoWith="false">
    <x-slot name="title">مواعيد المقابلات </x-slot>
    <x-slot name="cardbody">تحتوي الصفحة التالية علي مواعيد المقابلات التي تم حجزها من خلال نظام المقابلات</x-slot>
  
    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اليوم</th>
            <th scope="col">الموعد</th>
            <th scope="col"> اسم المكتب</th>
            <th scope="col">القسم</th>
            <th scope="col">اسم ولى الأمر</th>
            <th scope="col">تاريخ الحجز</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

        @foreach ($appointments as $key => $appointment)
        <tr>
            <th scope="row">
                {{ $appointment->id }}
            </th>
            <td>{{ $appointment->selected_date}}</td>
            <td>{{ Carbon\Carbon::parse($appointment->appointment_time)->format('h:i') }}</td>
            <td>{{ $appointment->office_name }}</td>
            <td>{{ $appointment->section_name }}</td>
            <td>{{ $appointment->first_name . " " .$appointment->last_name }}</td>
            <td><abbr title="اخر تحديث : {{ $appointment->updated_at->format('Y-m-d H:m') }}">{{ $appointment->created_at->format('Y-m-d H:m') }}</abbr></td>


        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
{{ $appointments->appends(request()->except('page'))->links() }}

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
