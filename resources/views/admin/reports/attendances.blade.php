@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table_filter ">
    {!! Form::open(['route' => 'reports.attandance','method'=>'GET']) !!}
    <div class="pair_header">
        <h4>تقرير الغياب</h4>
        <div class="col-sm-12 pair_form_s">
            <div class="pair_inputs">
                <div class="col-6">
                    {{ Form::label('student_id','طلاب محددين') }}
                    {{ Form::select('student_id[]',request()->input('student_id') ? request()->input('student_id') : [],null,['class' => 'form-control','id' => 'student_id','multiple' => true]) }}
                </div>
                <div class="col-6">
                    {{ Form::label('class_id','الفصل :') }}
                    <select name="class_id[]" class="form-control" id="class_id" multiple>
                            @foreach($classes as $type)
                                @foreach($type->genders as $gender)
                                    @foreach($gender->grades as $grade)
                                        @foreach($grade->levels as $level)
                                            @if(count($level->classes) > 0)
                                            <optgroup label="{{ $type->school_name }} -> {{ $gender->gender_name }} -> {{ $grade->grade_name }} -> {{ $level->level_name }}">
                                                @foreach($level->classes as $class)
                                                    <option @if(request()->input('class_id') && in_array($class->id,request()->input('class_id'))) selected @endif  value="{{ $class->id }}">{{ $class->class_name }}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
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
                <th scope="col">كود الطالب</th>
                <th scope="col">اسم الطالب</th>
                <th scope="col">تاريخ الغياب</th>
                <th scope="col">السبب</th>
                <th scope="col">الفصل</th>
                <th scope="col">المدير</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($StudentAbsents as $key => $StudentAbsent)
            <tr class="table-light">
                <th scope="row">
                    {{ $StudentAbsent->id }}
                </th>
                <td>#({{ $StudentAbsent->student_id}}) {{ $StudentAbsent->student_name }}</td>
                <td>{{ $StudentAbsent->absent_date }}</td>
                <td>{{ $StudentAbsent->reason }}</td>
                <td>{{ $StudentAbsent->class_name }}</td>
                <td>{{ $StudentAbsent->admin_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $StudentAbsents->appends(request()->except('page'))->links() }}

</div>


@endsection

@section('custom-script')
<script>
    jQuery(function() {
        $('#class_id').select2({
            // dir: "rtl"
            tags: true,
            tokenSeparators: [','],
            placeholder: "اختر الفصل"
        });
        $('#student_id').select2({
            // dir: "rtl"
            tags: true,
            tokenSeparators: [','],
            placeholder: "ادخل كود الطالب"
        });

    })
</script>
@endsection