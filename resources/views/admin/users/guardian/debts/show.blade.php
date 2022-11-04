@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('guardians.index'), 'name' => "اولياء الأمور"], ['link' => route('debts.index'), 'name' => "المديونيات"], ['link' => route('debts.show',$debt->id), 'name' => "مديونيات : $debt->first_name"]],['title' => 'مديونيات ولي الأمر']];
@endphp

@section('title', 'مديونيات ولي الأمر : '. $debt->getFullName())

@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
@endsection

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection



@section('content')

<x-forms.search route="debts.show" :params="[$debt->id]">
    <div class="row mb-1">
        <div class="col-md">
        <x-inputs.select.generic select2="select2" label="طلاب محديين" name="student_id" data-placeholder="اختر اسماء الطلاب" :options="['' => 'جميع الطلاب'] + $students" :required="false" />
            </div>
    </div>

    <x-slot name="export">

        <div class="btn-group">
            <button class="btn btn-outline-secondary waves-effect" name="action" type="submit" value="export_xlsx"><em data-feather='save'></em> اكسل</button>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden"></span>
            </button>
        </div>
    </x-slot>
</x-forms.search>

<!-- Striped rows start -->

@foreach($students as $k => $student)
@if($student_transactions = $transactions->where('student_id', $k))
@if(count($student_transactions)> 0)
<x-ui.table>
    <x-slot name="title">مديونية الطالب : <span class="text-danger">{{ $student }}</span></x-slot>
    <x-slot name="button">
    <x-inputs.link route="debts.index">عودة</x-inputs.link>

    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col"># </th>
            <th scope="col">الدفعة</th>
            <th scope="col">عن عام</th>
            <th scope="col">الي عام</th>
            <th scope="col">المبلغ</th>
            <th scope="col">مدفوع</th>
            <th scope="col">متبقي</th>
            <th scope="col">تاريح الترحيل</th>
            <th scope="col">التفاصيل</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($student_transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->installment_name }}</td>
            <td>{{ $transaction->debt_year_name ?? 'غير محدد' }}</td>
            <td>{{ $transaction->year_name }}</td>
            <td>{{ $transaction->amount_after_discount + $transaction->vat_amount}} ر.س</td>
            <td><span class="badge bg-success">{{ $transaction->paid_amount }} ر.س</span></td>
            <td> <span class="badge bg-danger">{{ $transaction->residual_amount }} ر.س</span></td>
            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
            <td><x-inputs.btn.generic class="withLoader" colorClass="warning" :route="route('students.contracts.transactions.index', [$transaction->student_id,$transaction->contract_id])">تفاصيل المديونية</x-inputs.btn.generic></td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>

</x-ui.table>
@endif
@endif
@endforeach
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

@endsection