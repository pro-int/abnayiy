@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
  <div class="pair_header">
    <h4>تفاصيل مشاركه الفصل </h4>
  </div>
</div>

<table class="table table-style">
  <thead class="add_posation">
    <tr class="table-light">
      <th scope="col">#</th>
      <th scope="col">الفصل</th>
      <th scope="col">اليوم</th>
      <th scope="col">التاريخ</th>

      <th style="min-width: 220px;" scope="col">الاجراءات المتاحة</th>
    </tr>
  </thead>

  <tbody>
    @foreach ($participation_reports as $key => $report)
    <tr class="table-light">
      <th scope="row">
        {{ $report->id }}
      </th>
      <td>{{ $report->class_name }}</td>
      <td>{{ $report->day_name }}</td>
      <td>{{ $report->report_date }}</td>

      <td>

        @can('StudentParticipations-edit')
        <a class="btn btn-sm btn-primary" href="{{  route('StudentParticipations.details',['report_id' => $report->id,'class_id'=>$report->class_id]) }}">تعديل المشاركة</a>
        
        @endcan

       
      </td>

    </tr>
    @endforeach
  </tbody>
</table>
@endsection