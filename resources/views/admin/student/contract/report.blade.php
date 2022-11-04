@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => "الطلاب"],['name'=> 'ادارة الطلاب' ]],['title'=> 'ادارة الطلاب']];
@endphp

@section('title', 'ادارة الطلاب')

@section('vendor-style')
<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')

<x-forms.search route="students.index">


    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic label="العام الدارسي السابق" name="old_academic_year_id" :options="['' => 'اختر العام الدراسي'] + App\Models\AcademicYear::years()" />
        </div>
        <div class="col-md">
            <x-inputs.select.generic label="العام الدراسي الحالي" name="new_academic_year_id" :options="['' => 'اختر العام الدراسي'] + App\Models\AcademicYear::years()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic  label="حالة التجديد" name="new_contract_status" :options="getRenewStatus()" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المدرسة" onLoad="{{ request('school_id') ? null : 'change'}}" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="النوع" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار النوع" :options="request('school_id') ? ['' => 'اختر النوع'] + App\Models\Gender::genders(true,request('school_id')) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المرحلة" name="grade_id" data-placeholder="اختر المرحلة" data-msg="رجاء اختيار المرحلة" :options="request('gender_id') ? ['' => 'اختر المرحلة'] + App\Models\Grade::grades(true,request('gender_id')) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="request('grade_id') ?  ['' => 'اختر الصف'] + App\Models\Level::levels(true,request('grade_id')) : []" />
        </div>

    </div>

    <div class="row mb-1">

        <div class="col-md">
            <x-inputs.select.generic :required="false" label="حالة التعاقد" name="status" data-placeholder="اختر حالة التعاقد" :options="['' => 'اختر حالة التعاقد'] + App\Models\Contract::STATUS" />
        </div>

        <div class="col-md-3">
            <x-inputs.select.generic :required="false" label="حالة الطالب" name="student_status" :options="['' => 'جميع الطلاب'] + getStudentStatus()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" label="نتيجة الطالب" name="exam_result" data-placeholder="اختر نتيجة الطالب" :options="['' => 'اختر نتيجة الطالب', 'null' => 'غير محدد' ] + App\Models\Contract::EXAM_RESULT" />
        </div>

        <div class="col-md">
            <label class="form-label">خدمة النقل </label>
            <x-inputs.checkbox :required="false" :checked="request()->has('transportation')" name="transportation">مشترك في خدمة النقل</x-inputs.checkbox>
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
    <x-slot name="title">الطلاب المسجلين بالمدرسة @if(! is_null($year))<span class="text-danger"> للعام الدراسي({{ $year->year_name }})</span>@endif</x-slot>
    <x-slot name="cardbody">قائمة الطلاب المسجلين بالمدرسة .. {{ sprintf('معروض %s طالب من اصل %s طالب مسجل بالنظام مطابق لمعطيات البحث ',$students->count(),$students->total()) }}</x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">اسم الطالب</th>
            <th scope="col">النوع</th>
            <th scope="col">رقم الهوية</th>
            <th scope="col">الجنسية</th>
            <th scope="col">الفئة</th>
            @if(request('academic_year_id'))
            <th scope="col">حالة الطالب</th>
            @can('accuonts-list')
            <th scope="col">الخطة</th>
            <th scope="col">السداد</th>
            @endcan
            <th scope="col">الصف</th>
            <th scope="col">النتيجة</th>
            <th scope="col">حالة التعاقد</th>
            <th scope="col">مقدم الطلب</th>
            @endif
            <th scope="col">الرعاية</th>
            <th scope="col">مزامنة نور</th>
            <th scope="col">اخر تعديل</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($students as $student)
        <td>
            @can('students-list')
            <x-inputs.btn.view :route="route('students.show', [$student->id])" />
            @endcan

            @can('students-edit')
            <x-inputs.btn.edit :route="route('students.edit', [$student->id])" />
            @endcan

            @can('accuonts-list')
            <x-inputs.btn.generic colorClass="warning btn-icon round" icon="list" :route="route('students.contracts.index', [$student->id])" title="قائمة التعاقدات" />
            @endcan

            @if($student->contract_id)
            @can('accuonts-list')
            <x-inputs.btn.generic colorClass="primary btn-icon round" icon="dollar-sign" :route="route('students.contracts.transactions.index', [$student->id,$student->contract_id])" title="تفاصيل تعاقد عام {{$year->year_name}}" />
            @endcan
            @endif

        </td>

        <th scope="row"> {{ $student->id }} </th>
        <td><abbr title="{{$student->student_name_en}}">{{ $student->student_name }}</abbr></td>
        <td>{{ $student->gender ? 'ذكر' : 'انثي' }}</td>
        <td>{{ $student->national_id }}</td>
        <td>{{ $student->nationality_name }}</td>
        <td><span class="badge bg-{{$student->color }}">{{ $student->category_name }}</span></td>
        @if($student->contract_id)
        <td>{!! $student->contract->getStudentStatus($student->graduated) !!}</td>
        @can('accuonts-list')
        <td>{{ $student->plan_name }}</td>
        <td>{!! $student->contract->GetContractSpan() !!}</td>
        @endcan
        <td><abbr title="{{ sprintf('%s - %s - %s - %s',$student->school_name , $student->gender_name, $student->grade_name, $student->level_name) }}">{{ $student->level_name }}</abbr></td>
        <td>{!! $student->contract->getExamResult() !!}</td>
        <td>{!! $student->contract->getStatus() !!}</td>
        <td>{{ $student->sales_admin_name }}</td>
        @endif
        <td>{{ $student->student_care ? 'نعم' : 'لا' }}</td>
        <td>@if(null !== $student->last_noor_sync) <abbr title="{{ $student->last_noor_sync }}"><em data-feather='check-circle' class="text-success"></em></abbr>@else <em class="text-danger" data-feather='x-circle'></em> @endif</td>
        <td><abbr title="{{ $student->created_at->format('Y-m-d h:m:s') }}">{{ $student->updated_at->format('Y-m-d h:m:s') }}</abbr></td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>

    <x-slot name="pagination">
        {{ $students->appends(request()->except('page'))->links() }}
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
        {!! Form::open(['route' => 'admins.assignAdminRole','method'=>'POST' , 'onsubmit' => 'showLoader()']) !!}

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

@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

@endsection
@section('page-script')
<!-- Page js files -->

<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
<script src="{{asset('js/scripts/components/components-dropdowns.js')}}"></script>

@endsection