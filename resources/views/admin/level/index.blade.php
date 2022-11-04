@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('levels.index'), 'name' => "الصفوف الدراسية"]],['title'=> 'الصفوف الدراسية المسجلة']];
@endphp

@section('title', 'ادارة الصفوف الدراسية')

@section('content')

<x-forms.search route="levels.index">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المدرسة" onLoad="{{ request('school_id') ? null : 'change'}}" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'اختر المدرسة'] +schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="النوع" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار النوع" :options="request('school_id') ? ['' => 'اختر النوع'] + App\Models\Gender::genders(true,request('school_id')) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المرحلة" name="grade_id" data-placeholder="اختر المرحلة" data-msg="رجاء اختيار المرحلة" :options="request('gender_id') ? ['' => 'اختر النوع'] + App\Models\Grade::grades(true,request('gender_id')) : []" />
        </div>
    </div>

</x-forms.search>

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">الصفوف الدراسية </x-slot>
    <x-slot name="cardbody">قائمة الصفوف الدراسية المسجلة بالمدرسة .. {{ isset($gender_id) ?  'االصفوف الدراسية الخاصة بالمرحلة  : ' . $type->gender_name  : 'الصفوف الدراسية' }} </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('levels.create') }}">
            <em data-feather='plus-circle'></em> اضافة صف جديد </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الصف</th>
            <th scope="col">الاسم في نور</th>
            <th scope="col">المرحلة</th>
            <th scope="col">النوع</th>
            <th scope="col">المدرسة</th>
            <th scope="col">الرسوم الدراسية</th>
            <th scope="col">الصف التالي</th>
            <th scope="col">الحالة</th>
            <th scope="col" style="min-width:350px;">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($levels as $level)
            <th scope="row">{{ $level->id }}</th>
            <td>{{ $level->level_name }}</td>
            <td>{{ $level->level_name_noor }}</td>
            <td>{{ $level->grade_name }}</td>
            <td>{{ $level->gender_name }}</td>
            <td>{{ $level->school_name }}</td>
            <td>{{ $level->tuition_fees }} ر.س</td>
            <td>
                @if($level->is_graduated)
                <a class="btn btn-flat-danger btn-sm" href="{{ route('levels.nextLevel', $level->id) }}">متخرج</a>
                @else
                    @if($level->next_level_id)
                    <a class="btn btn-flat-primary btn-sm" href="{{ route('levels.nextLevel', $level->id) }}">{{ $level->next_level_name }}</a> 
                    @else
                    <x-inputs.btn.generic colorClass="warning" icon="plus" :route="route('levels.nextLevel', $level->id)"/>
                    @endif
                @endif
            </td>
            <td>{{ $level->active == 1 ? 'فعال' : 'غير مفعل' }}</td>
            <td>
                @can('levels-list')
                <x-inputs.btn.view :route="route('levels.show',$level->id)" />
                @endcan

                @can('levels-edit')
                <x-inputs.btn.edit :route="route('levels.edit',$level->id)" />
                @endcan

                @can('levels-delete')
                <x-inputs.btn.delete :route="route('levels.destroy', $level->id)" />
                @endcan

                @can('levels-list')
                <x-inputs.btn.generic icon="clock" colorClass="warning" :route="route('levels.subjects.index', $level->id)">المواد</x-inputs.btn.generic>
                @endcan
            </td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- edit card modal  -->
<div class="modal fade" id="editLevel" tabindex="-1" aria-labelledby="editLevelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-sm-5 mx-50 pb-5" id="level-card-body">

      </div>
    </div>
  </div>
</div>
<!--/ edit card modal  -->

<!-- Striped rows end -->
@endsection