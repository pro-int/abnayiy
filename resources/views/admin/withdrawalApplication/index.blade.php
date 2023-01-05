@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('withdrawals.index'), 'name' => "الطلبات"],['name'=> 'طلبات الأنسحاب']],['title'=> 'ادارة الطلبات']];
@endphp

@section('title', 'طلبات الأنسحاب')
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

    <div class="message alert mb-1 rounded-0" role="alert" style="display: none">
        <div class="messageBody alert-body"></div>
    </div>
    <div class="alert alert-warning mb-1 rounded-0" role="alert">
        <div class="alert-body" style="font-weight: bold">  لا يمكن مسح طلب الانسحاب بعد تاكيد الطلب ولا يمكن استرجاع الدفعات المحذوفه من التعاقد</div>
    </div>

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">طلبات الأنسحاب بالمدرسة </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">اسم الطالب</th>
            <th scope="col">رقم الهوية</th>
            <th scope="col">تاريخ الانسحاب</th>
            <th scope="col">الصف</th>
            <th scope="col">العام</th>
            <th scope="col">حالة الطلب</th>
            <th scope="col">سبب الانسحاب</th>
            <th scope="col">التعليق</th>
            <th scope="col">المدرسه المحول لها</th>
            <th scope="col">رسوم الطلب(الدراسيه + الضرائب)</th>
            <th scope="col">رسوم النقل</th>
            <th scope="col">اجمالي الرسوم</th>
            <th scope="col">الاجراءات</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($withdrawalApplication as $application)
            <th scope="row">
                {{ $application->id }}
            </th>

            <td>{{ $application->student_name }}</td>
            <td>{{ $application->national_id }}</td>
            <td>{{ $application->date }}</td>
            <td>{{ $application->level_name }}</td>
            <td>{{ $application->year_name }}</td>
            <td><span class="badge {{ $application->application_status ? 'bg-info' : 'bg-success' }}">{{ $application->application_status ? 'مقبول' : 'جديد' }}</span></td>
            <td>{{ $application->reason }}</td>
            <td>{{ $application->comment }}</td>
            <td>{{ $application->school_name }}</td>
            <td>{{ $application->transportation_fees? ($application->amount_fees - $application->transportation_fees) : $application->amount_fees }}</td>
            <td>{{ $application->transportation_fees }}</td>
            <td>{{ $application->amount_fees}}</td>
            <td>
                @can('applications-list')
                    <x-inputs.btn.view route="{{ route('withdrawals.show',$application->id) }}" />
                @endcan

                @can('applications-edit')
                    @if($application->application_status == 0)
                            <a class="btn btn-icon round btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="right" onclick='openConfirmModel({{$application->id}}, {{$application->trans_id}})' title="قبول الطلب">
                                <em data-feather="edit-2"></em>
                            </a>
                    @endif
                @endcan
                    <p id="demo"></p>

            </td>

            </tr>
        @endforeach
        </tbody>
    </x-slot>

</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
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

    <script>
        function openConfirmModel(app_id, e=null) {
            if(e){
                let fees = prompt("ادخل قيمة رسوم النقل... علما بان الضفط علي زر ok سوف يتم قبول الطلب فورا");
                if (fees != null) {
                    $.ajax(
                        {
                            type: "GET",
                            url: "withdrawals/" + app_id + "/edit?",
                            data: {
                                "fees": fees
                            },
                            success: function(response)
                            {
                                console.log(response)
                                if(response.code == 200){
                                    $(".message").css("display","block");
                                    $('.message').removeClass("alert-danger");
                                    $('.message').removeClass("alert-success");
                                    $('.message').addClass("alert-success");
                                    $('.messageBody').text(response.message);
                                    window.setTimeout(function(){
                                        location.reload()
                                    }, 2000);
                                }else{
                                    $(".message").css("display","block");
                                    $('.message').removeClass("alert-success");
                                    $('.message').removeClass("alert-danger");
                                    $('.message').addClass("alert-danger");
                                    $('.messageBody').text(response.message);
                                }
                            }
                        }
                    );
                }
            }else{
                let conformInput = confirm("هل انت متاكد من قبول طلب الانسحاب ؟");
                if(conformInput){
                    $.ajax(
                        {
                            type: "GET",
                            url: "withdrawals/" + app_id + "/edit?",
                            data: {
                                "fees": null
                            },
                            success: function(response)
                            {
                                if(response.code == 200){
                                    $(".message").css("display","block");
                                    $('.message').removeClass("alert-danger");
                                    $('.message').removeClass("alert-success");
                                    $('.message').addClass("alert-success");
                                    $('.messageBody').text(response.message);
                                    window.setTimeout(function(){
                                        location.reload()
                                    }, 2000);
                                }else{
                                    $(".message").css("display","block");
                                    $('.message').removeClass("alert-success");
                                    $('.message').removeClass("alert-danger");
                                    $('.message').addClass("alert-danger");
                                    $('.messageBody').text(response.message);
                                }
                            }
                        }
                    );
                }
            }

        }
    </script>
@endsection

@section('page-script')
<script type="text/javascript">

</script>
@endsection
