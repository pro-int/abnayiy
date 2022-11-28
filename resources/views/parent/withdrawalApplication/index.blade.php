@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('parent.withdrawals.index'), 'name' => "الطلبات"],['name'=> 'طلبات الأنسحاب']],['title'=> 'ادارة الطلبات']];
@endphp

@section('title', 'طلبات الأنسحاب')
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
<x-ui.table>
    <x-slot name="title">طلبات الأنسحاب بالمدرسة </x-slot>
    <x-slot name="cardbody">قائمة الطلبات المقدمة  .. {{$withdrawalApplication->count()}} طلب</x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الطالب</th>
            <th scope="col">رقم الهوية</th>
            <th scope="col">الصف</th>
            <th scope="col">العام</th>
            <th scope="col">حالة الطلب</th>
            <th scope="col">سبب الانسحاب</th>
            <th scope="col">التعليق</th>
            <th scope="col">المدرسه المحول لها</th>
            <th scope="col">رسوم الطلب</th>
            <th scope="col">الاجراءات</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($withdrawalApplication as $application)
            <th scope="row">
                {{ $application->id }}
            </th>

            <td>{{ $application->student_name }}</td>
            <td>{{ $application->national_id }}</td>
            <td>{{ $application->level_name }}</td>
            <td>{{ $application->year_name }}</td>
            <td><span class="badge {{ $application->application_status ? 'bg-info' : 'bg-success' }}">{{ $application->application_status ? 'مقبول' : 'جديد' }}</span></td>
            <td>{{ $application->reason }}</td>
            <td>{{ $application->comment }}</td>
            <td>{{ $application->school_name }}</td>
            <td>{{ $application->amount_fees }}</td>
            <td>
                @can('guardian-applications-list')
                    <x-inputs.btn.view route="{{ route('parent.withdrawals.show',$application->id) }}" />
                @endcan


            </td>

            </tr>
        @endforeach
        </tbody>
    </x-slot>


    <x-slot name="pagination">
        {{ $withdrawalApplication->appends(request()->except('page'))->links() }}
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

@section('page-script')
<script type="text/javascript">

</script>
@endsection
