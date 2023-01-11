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

<x-forms.search route="applications.index">
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
            <x-inputs.select.generic label="حالة الطلب" name="status_id" data-placeholder="اختر حالة الطلب" :options="['all' => 'جميع الطلبات'] + App\Models\ApplicationStatus::Statuses()" />
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
    <x-slot name="title">طلبات الألتحاق بالمدرسة @if(request('myapplications')) <span class="text-danger">(المقدمة من حسابي)</span> @endif</x-slot>
    <x-slot name="cardbody">قائمة الطلبات المقدمة من اولياء الأمور .. {{$applications->count()}} طلب</x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">الاسم</th>
            <th scope="col">رقم الجوال
            <th scope="col">رقم الهوية</th>
            <th scope="col">الصف</th>
            <th scope="col">العام</th>
            <th scope="col">النقل</th>
            <th scope="col">حالة الطلب</th>
            @can('accuonts-list')
            <th scope="col">السداد</th>
            @endcan
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تعديل</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($applications as $key => $application)
        <td>

        @can('applications-list')
        <x-inputs.btn.generic icon="book-open" data-bs-original-title="سجل الطلب" colorClass="primary" route="{{ route('applications.logs',$application->id) }}" />
        <x-inputs.btn.view route="{{ route('applications.show',$application->id) }}" />
        @endcan

        @can('applications-edit')
        @if($application->status_id < 2)
        <x-inputs.btn.edit :route="route('applications.edit',$application->id)" />

        @endif
        @switch($application->status_id)
        @case(1)
        <x-inputs.btn.generic icon="message-circle" colorClass="warning" data-id="{{ $application->appointment_id }}" onClick="GetMettingInfo(this)" data-bs-original-title="تفاصيل المقابلة" />

        <x-inputs.btn.generic icon="message-circle" colorClass="secondary" data-id="{{ $application->appointment_id }}, {{ $application->id }}" onClick="updateMettingresult(this)" data-bs-original-title="نتيجة المقابلة" />
            @break

            @case(2)
            <x-inputs.btn.generic icon="link" colorClass="info" data-id="{{ $application->id }}" onClick="ChangeStatus(this)" data-bs-original-title="مضاف الي نور" data-changeTo="noor" />
            @break

            @case(3)
            <x-inputs.btn.generic icon="link" colorClass="warning" data-id="{{ $application->id }}" onClick="ChangeStatus(this)" data-bs-original-title="قائمة الانتظار" data-changeTo="pending" />

            <x-inputs.btn.generic icon="link" colorClass="warning" data-id="{{ $application->id }}" onClick="ChangeStatus(this)" data-bs-original-title="قبول نهائي " data-changeTo="confirm" />

            @break

            @case(4)
            <x-inputs.btn.generic icon="link" colorClass="warning" data-id="{{ $application->id }}" onClick="ChangeStatus(this)" data-bs-original-title="قبول نهائي " data-changeTo="confirm" />

            @break

            @case(6)
            <x-inputs.btn.generic icon="book-open" colorClass="warning" data-id="{{ $application->id }}" onClick="ChangeStatus(this)" data-bs-original-title="اعادة فتح الطلب" data-changeTo="reopen" />

            @break
            @endswitch
            @endcan

            @can('applications-delete')
            <x-inputs.btn.delete :route="route('applications.destroy',$application->id)" />
            @endcan

        </td>
        <th>{{ $application->id }}</th>
        <td>@if(!$application->contract) {{ $application->student_name }} @else <a href="{{ route('students.index',http_build_query(['search'=> $application->national_id, 'academic_year_id' => $application->academic_year_id])) }}">{{ $application->student_name }}</a> @endif</td>
        <td>{{ $application->phone }}</td>
        <td>{{ $application->national_id }}</td>
        <td><abbr title="{{ sprintf('%s - %s - %s - %s',$application->school_name , $application->gender_name, $application->grade_name, $application->level_name) }}">{{ $application->level_name }}</abbr></td>
        <td>{{ $application->year_name }}</td>
        <td>{{ $application->transportation_type ?? 'لا يرغب' }}</td>
        <td><span class="badge bg-{{$application->color}}">{{ $application->status_name }}</span></td>
        @can('accuonts-list')
        @if($application->contract && $application->contract->total_paid > 0)
        <td><span class="badge bg-success">{{ $application->contract->total_paid  }} ر.س</td>
        @else
        <td><span class="badge bg-danger">لم يسدد</td>
        @endif
        @endcan
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
<div class="offcanvas offcanvas-start" tabindex="-1" id="AssignAdminModal" aria-labelledby="AssignAdminModalLabel">
    <div class="offcanvas-header">
        <h5 id="AssignAdminModalLabel" class="offcanvas-title">اضافة ولي امر كمدير</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <div class="text-center mb-2 text-danger">
            <me data-feather="user-plus" class="font-large-3"></me>
        </div>
        <h3 class="text-center text-dark" id="slot">
            جاري تحميل المعلومات
        </h3>
        {!! Form::open(['route' => 'admins.assignAdminRole','method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

        <input type="hidden" name="user_id" id="user_id">

        <div class="col-lg mb-1">
            <x-inputs.text.Input label="المسمي الوظيفي" icon="user" name="job_title" placeholder="ادخل المسمي الوظيفي" data-msg="ادخل المسمي الوظيفي بشكل صحيح" />
        </div>

        <div class="col-lg mb-1">
            <x-inputs.select.generic label="الدور الأداري" name="roles[]" data-placeholder="اختر الدور الأداري" data-msg="رجاء اختيار الدور الأجاري" :options="Spatie\Permission\Models\Role::pluck('display_name', 'name')->toArray()" multiple />
        </div>


        <button type="submit" class="btn btn-danger mb-1 d-grid w-100">تأكيد</button>
        {!! Form::close() !!}
        <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
            تراجع
        </button>
    </div>
</div>

<div class="offcanvas offcanvas-width-30 offcanvas-start" tabindex="-1" id="meetingModal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">

</div>
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
    var AssignAdminModal = document.getElementById('AssignAdminModal')
    AssignAdminModal.addEventListener('show.bs.offcanvas', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget

        // Extract info from data-bs-* attributes
        var user_id = button.getAttribute('data-bs-user_id')
        var user_name = button.getAttribute('data-bs-user_name')

        // Update the modal's content.
        var modalTitle = AssignAdminModal.querySelector('#slot')
        var user_id_input = AssignAdminModal.querySelector('#AssignAdminModal #user_id')

        modalTitle.textContent = 'تعيين ولي الامر : ' + user_name + ' #(' + user_id + ') - كمدير'
        user_id_input.value = user_id
    })
</script>
@endsection
