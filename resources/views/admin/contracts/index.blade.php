@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('contracts.all'), 'name' => "التعاقدات"],['name'=> 'طلبات الألتحاق']],['title'=> 'ادارة الطلبات']];
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

<x-forms.search route="contracts.all">
    <div class="row mb-1">
        <div class="col-2">
            <x-inputs.select.generic label="نوع البحث" name="search_code_type" data-placeholder="اختر نوع البحث" :options="['contract' => 'كود العقد','student' => 'كود الطالب','user' => 'كود ولي الامر']" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input :required="false" icon="search" label="البحث بالكود" name="search_code" placeholder="يمكنك البحث عن اسم او رقم جوال او هوية ويمكن البحث بالكود عن طريق اضافة = قبل لكمة البحث" />
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-sm">
            <x-inputs.text.Input icon="user" :required="false" label="البحث عن اسم الطالب او ولى الامر" name="search" placeholder="للبحث استخدم كل او جزء من اسم الطالب او ولي الامر" />
        </div>
        <div class="col-sm">
            <x-inputs.text.Input icon="user" :required="false" label="البحث عن رقم الجوال او الهوية" name="search_number" placeholder="للبحث استخدم كل او جزء من  رقم الجوال او الهوية الطالب او ولي الامر" />
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-sm">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ من :" name="date_from" placeholder="yyyy-mm-dd" />
        </div>
        <div class="col-sm">
            <x-inputs.text.Input class="flatpickr-basic" icon="calendar" :required="false" label="تاريخ الي :" name="date_to" placeholder="yyyy-mm-dd" />
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
            <label class="form-label">خدمة النقل </label>
            <x-inputs.checkbox :required="false" name="transportation">مشترك في خدمة النقل</x-inputs.checkbox>
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
    <x-slot name="title">قائمة التعاقدات </x-slot>
    <x-slot name="cardbody">قائمة التعاقدات المسجلة بالمدرسة .. {{ sprintf('معروض %s من اصل %s تعاقد مطابقين لمعطيات البحث',$contracts->count(),$contracts->total()) }} طلب</x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الطالب</th>
            <th scope="col">اسم ولى الامر</th>
            <th scope="col">هوية الطالب</th>
            <th scope="col">هوية ولى الأمر</th>
            <th scope="col">رقم الجوال</th>
            <th scope="col">الفصول المسجلة</th>
            <th scope="col">السنة الدراسية</th>
            <th scope="col">الشروط و الاحكام</th>
            <th scope="col">بواسطة</th>
            <th scope="col">الاجراءات</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
            @foreach ($contracts as $key => $contract)
            <tr>
                <th>{{ $contract->id }}</th>
                <td>{{ $contract->student_name }} (<a href="{{ route('students.edit',$contract->studentCode) }}">{{ $contract->studentCode }}</a>)</td>
                <td>{{ $contract->guardianName }} (<a href="{{ route('users.edit',$contract->guardianCode) }}">{{ $contract->guardianCode }}</a>)</td>
                <td>{{ $contract->guardianNationalId }}</td>
                <td>{{ $contract->studentNationalId }}</td>
                <td>{{ $contract->phone}} </td>
                <td>{{ count($contract->applied_semesters) }}</td>
                <td>{{ $contract->year_name }}</td>
                <td><a href="{{ route('contract_terms.show',$contract->terms_id) }}">{{ $contract->terms_id }}</a></td>
                <td>{{ $contract->admin_name }}</td>
                <td>
                    @can('students-list')
                    <x-inputs.btn.view :route="route('students.contracts.show', ['student' => $contract->student_id ,'contract' => $contract->id])" />
                    @endcan
                </td>
            </tr>
            @endforeach
    </x-slot>

    <x-slot name="pagination">
        {{ $contracts->appends(request()->except('page'))->links() }}
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
