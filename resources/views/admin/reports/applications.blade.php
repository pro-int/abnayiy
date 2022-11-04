@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table_filter ">
    {!! Form::open(['route' => 'reports.applications','method'=>'GET']) !!}
    <div class="pair_header">
        <h4>تقرير الطلبات</h4>
        <div class="col-sm-12 pair_form_s">
            <div class="pair_inputs">
                <div class="col-6">
                    {{ Form::label('status_id','حاله الطلب: ') }}
                    {{ Form::select('status_id',['all' => 'جميع الحالات'] + App\Models\ApplicationStatus::Statuses(),request()->input('status_id'),['class' => 'form-select']) }}

                </div>

                <div class="col-6">
                    <div class="form-check" style="padding-top: 30px;">
                        {{ Form::checkbox('transportation',null,request()->input('transportation'),['id'=> 'transportation','class'=>'form-check-input']) }}
                        {{ Form::label('transportation','يرغب في خدمه النقل',['class' => 'form-check-label']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 pair_form_s">
            <div class="pair_inputs">
                <div class="col-6">
                    {{ Form::label('date_from','تاريخ من : ') }}
                    {{ Form::date('date_from',request()->input('date_from'),['class' => 'form-control']) }}
                </div>

                <div class="col-6">
                    {{ Form::label('date_to','تاريخ الي : ') }}
                    {{ Form::date('date_to',request()->input('date_to'),['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="col-sm-12 pair_form_s">
            <div class="pair_inputs">
                <div class="col-6" style="display: flex;justify-content: start;">
                    <button type="submit" class="btn btn-primary" name="action" value="searchReport" >بحث</button>
                </div>
                <div class="col-6" style="display: flex;justify-content: end;">
                    <button type="submit" class="btn btn-info" name="action" value="saveReport" >حفظ التقرير</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">كود</th>
                <th scope="col">الاسم</th>
                <th scope="col">رقم الجوال
                <th scope="col">رقم الهوية</th>
                <th scope="col">الصف</th>
                <th scope="col">النقل</th>
                <th scope="col">حالة الطلب</th>
                <th scope="col">تاريخ الطلب</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($applications as $key => $application)
            <tr class="table-light">
                <th scope="row">
                    {{ $application->id }}
                </th>
                <td>{{ $application->student_name }}</td>
                <td>{{ $application->phone }}</td>
                <td>{{ $application->national_id }}</td>
                <td>{{ $application->school_name }} - {{ $application->gender_name }} - {{ $application->grade_name }} - {{ $application->level_name }}</td>
                <td>{{ $application->transportation_type }}</td>
                <td><span class="badge bg-{{$application->color}}">{{ $application->status_name }}</span></td>
                <td>{{ $application->created_at->format('Y-m-d') }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $applications->appends(request()->except('page'))->links() }}
 
</div>


@endsection