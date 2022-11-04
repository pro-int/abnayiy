@extends('layouts.contentLayoutMaster')

@section('content')
{!! Form::open(['route' => ['StudentParticipations.details.update',['report_id' => request()->report_id]],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}

<div class="container_table">
  <div class="pair_header">
    {{-- <h4>تسجيل مشاركة الفصل : {{$class->class_name}}</h4> --}}
    {{ Form::label('subject_id','المادة')}}
    {{ Form::select('subject_id', App\Models\Subject::subjects() , old('subject_id'),['required' => true,'class'=> 'select2 form-control'. ($errors->has('subject_id') ? ' is-invalid' : null),'id' => 'subject_id']) }}

    @error('subject_id')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  <div class="container">

    <!-- start tools table -->
    <div class="contanier_tools_table">
      <table class="table">
        <tbody>
          <tr>
            <th scope="row" style="border-bottom: 0"></th>
            <td style="border-bottom: 0">اسم الطالب</td>
            <td>واجبات</td>
            <td>المشاركة</td>
            <td>الانتباة</td>
            <td>الألتزام بالتعليمات</td>
          </tr>
          <tr style="border-bottom: 2px solid #ccc">
            <th scope="row"></th>
            <td>الدرجة من</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
          </tr>

          @foreach($students as $student)
          <tr>
            <th scope="row">{{ $student->student_id }}#</th>
            <td>{{ $student->student_name }}</td>
            <td>
              <div class="input-group">
                <input type="number" class="form-control" name="marks[{{$student->id}}][home_work]" value="{{ $student->home_work }}" placeholder="10" min="0" max="10" aria-label="Username" aria-describedby="basic-addon1"  />
              </div>
            </td>
            <td>
              <div class="input-group">
                <input type="number" name="marks[{{$student->id}}][participation]" value="{{ $student->participation }}" placeholder="10" min="0" max="10" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="{{ $student->participation }}" />
              </div>
            </td>
            <td>
              <div class="input-group">
                <input type="number" name="marks[{{$student->id}}][attention]" value="{{ $student->attention }}" placeholder="10" min="0" max="10" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="{{ $student->attention }}" />
              </div>
            </td>
            <td>
              <div class="input-group">
                <input type="number" name="marks[{{$student->id}}][tools]" value="{{ $student->tools }}" placeholder="10" min="0" max="10" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="{{ $student->tools }}" />
              </div>
            </td>
          </tr>
          @endforeach

        </tbody>
      </table>

      <!--start buttons bar  -->
      <div class="pair_btn">
        <button type="button" class="btn btn-info {{ $errors->has('report_date') ? ' is-invalid' : null }}">
          <span>تاريخ اليوم</span> <input name="report_date" type="date" required value="{{ $report->report_date }}" disabled/>
        </button>
        @error('report_date')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
        <!-- <button type="button" class="btn btn-success">استيراد</button>
        <button type="button" class="btn btn-danger">تصدير</button> -->
        <button type="submit" class="btn btn-primary">تعديل المشاركة</button>
      </div>
      <!-- End buttons bar -->
    </div>

    <!-- start tools table -->
  </div>
</div>
{!! Form::close() !!}
@endsection