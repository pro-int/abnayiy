@extends('layouts.contentLayoutMaster')


@section('content')

{!! Form::open(['route' => ['StudentAttendances.store',['class_id' => $class->id]],'method'=>'POST' , 'onsubmit' => 'showLoader()'])  !!}
{{ Form::hidden('class_id',$class->id)}}
<div class="container_table">
    <div class="pair_header">
        <h4>تسجيل غياب الفصل : {{$class->class_name}}</h4>
    </div>
    <div class="container">
        <!-- start absent table -->
        <div class="contanier_absent_table">
            <!-- start tables contanier -->

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="border-left: 1px solid #ccc">
                            رقم الطالب
                        </th>
                        <th scope="col" style="border-left: 1px solid #ccc">الأسم</th>
                        <th style="border-left: 1px solid rgb(214, 214, 214)">غائب</th>
                        <th style="border-left: 1px solid rgb(214, 214, 214)">سبب الغياب</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td style="border-left: 1px solid #ccc">{{ $student->id }}#</td>
                        <td style="border-left: 1px solid #ccc">{{ $student->student_name }}</td>
                        <td style="padding-left: 50px; border-left: 1px solid rgb(214, 214, 214);">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="absent[{{$student->id}}][is_absent]" type="checkbox" id="flexSwitchCheckDefault" />
                            </div>
                        </td>
                        <td style="border-left: 1px solid #ccc"><input type="text" class="form-control" name="absent[{{$student->id}}][reason]" placeholder="بدون سبب"></td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- end tables contanier -->

            <!--start buttons bar  -->
            <div class="pair_btn">
                <button type="button" class="btn btn-info {{ $errors->has('absent_date') ? ' is-invalid' : null }}">
                    <span>تاريخ اليوم</span> <input name="absent_date" type="date" required />
                </button>
                @error('absent_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <!-- <button type="button" class="btn btn-danger">تصدير PDF</button>

            <button type="button" class="btn btn-success">استيراد Exel</button>
            <button type="button" class="btn btn-danger">تصدير Exel</button>

            <button type="button" class="btn btn-success">
                استيراد من نور
            </button>

            <button type="button" class="btn btn-danger">تصدير الي نور</button> -->

                <button type="submit" class="btn btn-primary">تسجيل الغياب</button>
            </div>
            <!-- End buttons bar -->
        </div>
        <!-- start absent table -->
        {!! Form::close() !!}
    </div>
</div>

@endsection