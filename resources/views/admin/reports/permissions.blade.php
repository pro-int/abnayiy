@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table_filter ">
    {!! Form::open(['route' => 'reports.permissions','method'=>'GET']) !!}
    <div class="pair_header">
        <h4>تقرير الاستئذان</h4>
        <div class="col-sm-12 pair_form_s">
            <div class="pair_inputs">
                <div class="col-6">
                    {{ Form::label('student_id','طلاب محددين') }}
                    {{ Form::select('student_id[]',request()->input('student_id') ? request()->input('student_id') : [],null,['class' => 'form-control','id' => 'student_id','multiple' => true]) }}
                </div>
                <div class="col-6">
                    {{ Form::label('case_id','حاله الاستئذان : ') }}
                    {{ Form::select('case_id[]',App\Models\PermissionCase::cases(),request()->input('case_id'),['class' => 'form-select','id' => 'case_id','multiple' => true]) }}
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
                    <button type="submit" class="btn btn-primary" name="action" value="searchReport">بحث</button>
                </div>
                <div class="col-6" style="display: flex;justify-content: end;">
                    <button type="submit" class="btn btn-info" name="action" value="saveReport">حفظ التقرير</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">كود</th>
                <th scope="col">اسم الطالب</th>
                <th scope="col">المرافق</th>
                <th scope="col">الوقت</th>
                <th scope="col">السبب</th>
                <th scope="col">المدة</th>
                <th scope="col">الحالة</th>
                <th scope="col">التاريخ</th>
                <th scope="col">المدير</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($permissions as $key => $permission)
            <tr class="table-light">
                <th scope="row">
                    {{ $permission->id }}
                </th>
                <td>#({{ $permission->student_id}}) {{ $permission->student_name }}</td>
                <td>{{ $permission->pickup_persion }}</td>
                <td>{{ $permission->pickup_time }}</td>
                <td>{{ $permission->permission_reson }}</td>
                <td>{{ $permission->permission_duration }}</td>
                <td><span class="badge bg-{{$permission->case_color}}">{{ $permission->case_name }}</span></td>
                <td>{{ $permission->created_at->format('Y-m-d') }}</td>
                <td>{{ $permission->admin_name }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $permissions->appends(request()->except('page'))->links() }}

</div>


@endsection

@section('custom-script')
<script>
    jQuery(function() {
        $('#student_id').select2({
            // dir: "rtl"
            tags: true,
            tokenSeparators: [','],
            placeholder: "ادخل اكواد الطالب"
        });
        $('#case_id').select2({
            // dir: "rtl"
            tags: true,
            tokenSeparators: [','],
            placeholder: "اختر حالة الاذن"
        });

    })
</script>
@endsection