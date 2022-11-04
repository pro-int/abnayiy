@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
  <div class="pair_header">
    <h4>مشاركة الطلاب</h4>
  </div>
</div>

<table class="table table-style">
  <thead class="add_posation">
    <tr class="table-light">
      <th scope="col">#</th>
      <th scope="col">الفصل</th>
      <th scope="col">عدد الطلاب</th>
      <th style="min-width: 220px;" scope="col">الاجراءات المتاحة</th>
    </tr>
  </thead>

  <tbody>
    @foreach ($classes as $key => $class)
    <tr class="table-light">
      <th scope="row">
        {{ $class->id }}
      </th>
      <td>{{ $class->class_name }}</td>
      <td>{{ $class->students->count() }} طالب</td>
      <td>

        @can('StudentParticipations-edit')
        <a class="btn btn-sm btn-primary" href="{{  route('StudentParticipations.create',['class' => $class->id]) }}">تسجيل المشاركة</a>
        @endcan
        @can('StudentParticipations-edit')
        <a class="btn btn-sm btn-info" href="{{  route('StudentParticipations.reports',['class_id' => $class->id]) }}">تفاصيل المشاركة</a>
        @endcan

       
      </td>

    </tr>
    @endforeach
  </tbody>
</table>
@endsection