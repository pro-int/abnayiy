@extends('layouts.contentLayoutMaster')

@section('title', 'اِستئذان الطلاب')

@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => "الطلاب"], ['link' => route('permissions.index'), 'name' => "اِستئذان الطلاب"]],['title' => 'اِستئذان الطلاب']];
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



@section('content')

<x-forms.search route="permissions.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input :required="false" icon="search" label="اليحث" name="search" placeholder="اسم الطالب" />
        </div>
        <div class="col-md">
            <x-inputs.select.generic :required="false" label="حالة الطلب" name="case_id" data-placeholder="حالة الطلب" :options="['' => 'جميع الحالات'] + getPermissionsCases()" />
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

   {{--
    <x-slot name="export">
        <div class="btn-group">
            <button class="btn btn-outline-secondary waves-effect" name="action" type="submit" value="export_xlsx"><em data-feather='save'></em> اكسل</button>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden"></span>
            </button>
        </div>
    </x-slot>
    --}}
</x-forms.search>

<x-ui.table>
    <x-slot name="title">اِستئذان الطلاب</x-slot>
    <x-slot name="cardbody">قائمة بجميع طلبات اِستئذان الطلاب المقدمة من اولاء الأمور</x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">#</th>
            <th scope="col">الاسم</th>
            <th scope="col">المرافق</th>
            <th scope="col">السبب</th>
            <th scope="col">المدة</th>
            <th scope="col">المسار</th>
            <th scope="col">التوقيت</th>
            <th scope="col">الحالة</th>
            <th scope="col">بواسطة</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($permissions as $permission)
        <tr>
            <th scope="row">
                {{ $permission->id }}
            </th>
            <td>{{ $permission->student_name }} (#{{ $permission->student_id }})</td>
            <td>{{ $permission->pickup_persion }}</td>
            <td>{{ $permission->permission_reson }}</td>
            <td>{{ $permission->permission_duration }}</td>
            <td>{{ sprintf('%s - %s - %s - %s - %s' ,$permission->school_name,$permission->gender_name,$permission->grade_name,$permission->level_name,$permission->class_name) }}</td>
            <td>{{ $permission->pickup_time }}</td>
            <td><span class="badge bg-{{ $permission->case_color }}">{{ $permission->case_name }}</span></td>
            <td>{{ $permission->admin_name }}</td>

            <td>
                @if(null == $permission->approved_by)
                <button class="btn btn-sm btn-primary" data-href="{{ route('permissions.update',$permission->id) }}" onclick="updatePermissionStatus(this)">اجراء</button>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>

    <x-slot name="pagination">
        {{ $permissions->appends(request()->except('page'))->links() }}
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />


<div class="modal fade add_back text-end" id="updatePermissionModal" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تحديث حالة الأستئذان</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form role="form" method="POST" action="#" name="updatePermissionForm">
                <div class="modal-body">
                    @csrf
                    @method('put')

                    <div class="mb-3 text_centers">
                        <label for="case_id" class="col-md-4 col-form-label text-md-right">حالة الاذن : </label>
                        {{ Form::select('case_id', getPermissionsCases() , null, ['required' => true,'class'=> 'select2 form-control','id' => 'case_id']) }}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        عوده
                    </button>
                    <button type="submit" class="btn btn-success">تأكيد</button>
                </div>
            </form>
        </div>
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
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection