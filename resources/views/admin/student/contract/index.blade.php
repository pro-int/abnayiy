@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$student), 'name' => $student->student_name],['link' => route('students.contracts.index',$student), 'name' => "تعاقدات الطالب"]],['title'=> 'ادارة تعاقدات الطالب']];
@endphp

@section('title', 'ادارة تعاقدات الطالب')


@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">تعاقدات الطالب :  {{ $student->student_name }}</x-slot>
    <x-slot name="cardbody"> قائمة بجميع تعاقدات الطالب بالمدرسة خلال السنوات الدراسية السابقة </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">السنة الدراسية</th>
            <th scope="col">الفصول المسجلة</th>
            <th scope="col">الصف الدراسي</th>
            <th scope="col">النتيجة</th>
            <th scope="col">خطة الدفع</th>
            <th scope="col">الرسوم الداراسية</th>
            <th scope="col">خصم فترة</th>
            <th scope="col">كوبون</th>
            <th scope="col">النقل</th>
            <th scope="col">الضرائب</th>
            <th scope="col">مديونيات</th>
            <th scope="col">الأجمالي</th>
            <th scope="col">مسدد</th>
            <th scope="col">متبقي</th>
            <th scope="col">خدمة النقل</th>
            <th scope="col">الدفع</th>
            <th scope="col">حالة التعاقد</th>
            <th scope="col">مزامنة رسوم الدراسيه odoo</th>
            <th scope="col">مزامنة رسوم النقل odoo</th>
            <th scope="col">مزامنة المديونات odoo</th>
            <th scope="col">اخطاء مزامنة رسوم الدراسيه odoo</th>
            <th scope="col">اخطاء مزامنة رسوم النقل odoo</th>
            <th scope="col">اخطاء مزامنة المديونيات odoo</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تحديث</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($contracts as $contract)
        <td>
            @can('accuonts-list')
            <x-inputs.btn.view :route="route('students.contracts.show', [$student->id,$contract->id])" />
            @endcan

            @can('accuonts-delete')
            <x-inputs.btn.delete :route="route('students.contracts.destroy', [$student->id,$contract])" />
            @endcan

            @can('transportations-list')
            <x-inputs.btn.generic colorClass="danger btn-icon round" icon="home" :route="route('students.contracts.transportations.index', [$contract->student_id,$contract->id])"  title="خدمة النقل"/>
            @endcan

            @can('accuonts-list')
            <x-inputs.btn.generic colorClass="primary btn-icon round" icon="dollar-sign" :route="route('students.contracts.transactions.index', [$student->id,$contract->id])" title="الدفعات"/>
            @endcan


            @can('accuonts-list')
            <x-inputs.btn.generic colorClass="info btn-icon round" icon="file" :route="route('students.contracts.files.index', [$student->id,$contract->id])" title="ملفات التعاقد"/>
            @endcan

            @if(($contract->odoo_sync_study_status == 0 || ($contract->odoo_sync_transportation_status == 0 && $contract->bus_fees !=0) || ($contract->odoo_sync_journal_status == 0 && $contract->debt !=0) ) && $contract->current_academic_year == 1)
                <x-inputs.btn.generic colorClass="primary btn-icon round" icon="repeat" :route="route('contracts.resendToOdoo', ['id' => $contract->id])" title="مزامنه حسابات odoo" />
            @endif

        </td>

        <th scope="row">
            {{ $contract->id }}
        </th>
        <td>{{ $contract->year_name }}</td>
        <td>{{ count($contract->applied_semesters) }}</td>
        <td>{{ $contract->level_name }}</td>
        <td>{!! $contract->getExamResult() !!}</td>
        <td>{{ $contract->plan_name }} ({{ $contract->transactions->count() }} دفعة)</td>
        <td>{{ $contract->tuition_fees }}</td>
        <td>{{ $contract->period_discounts }}</td>
        <td>{{ $contract->coupon_discounts }}</td>
        <td>{{ $contract->bus_fees }}</td>
        <td>{{ $contract->vat_amount }} ({{ $contract->vat_rate }}%)</td>
        <td>{{ $contract->debt }}</td>
        <td>{{ $contract->total_fees }}</td>
        <td>{{ $contract->total_paid }}</td>
        <td>{{ round($contract->total_fees - $contract->total_paid,2) }}</td>
        <td>@if(count($contract->transportation)) مشترك @else غير مشترك @endif</td>
        <td>{!! ($contract->GetContractSpan()) !!}</td>
        <td>{!! $contract->getStatus() !!}</td>
        <td>@if($contract->odoo_sync_study_status) <abbr title="{{ $contract->odoo_sync_study_status }}"><em data-feather='check-circle' class="text-success"></em></abbr>@else <em class="text-danger" data-feather='x-circle'></em> @endif</td>
        <td>@if($contract->odoo_sync_transportation_status) <abbr title="{{ $contract->odoo_sync_transportation_status }}"><em data-feather='check-circle' class="text-success"></em></abbr>@else <em class="text-danger" data-feather='x-circle'></em> @endif</td>
        <td>@if($contract->odoo_sync_journal_status) <abbr title="{{ $contract->odoo_sync_journal_status }}"><em data-feather='check-circle' class="text-success"></em></abbr>@else <em class="text-danger" data-feather='x-circle'></em> @endif</td>
        <td>{{ !$contract->odoo_sync_study_status?$contract->odoo_message_study : 'لا يوجد'}}</td>
        <td>{{ !$contract->odoo_sync_transportation_status?$contract->odoo_message_transportation : 'لا يوجد'}}</td>
        <td>{{ !$contract->odoo_sync_journal_status?$contract->odoo_message_journal : 'لا يوجد'}}</td>

        <td>{{ $contract->admin_name }}</td>
        <td><abbr title="تاريخ التسجيل : {{ $contract->created_at->format('Y-m-d h:m:s') }}">{{ $contract->updated_at->diffforhumans() }}</abbr></td>

        </tr>
        @endforeach
        </tbody>
    </x-slot>

</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
