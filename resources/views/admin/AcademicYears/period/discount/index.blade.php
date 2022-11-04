@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year), 'name' => "$year->year_name"],['link' => route('years.periods.show',[$year,$period]), 'name' => $period->period_name ],['link' => route('years.periods.discounts.index',[$year,$period]), 'name' => "خصومات : $period->period_name"]],['title'=> 'ادارة خصومات '. $period->period_name]];
@endphp

@section('title', 'ادارة خصومات فترة السداد')

@section('content')

<x-forms.search route="years.periods.discounts.index" :params="[$year, $period]">

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المدرسة" onLoad="{{ request('school_id') ? null : 'change'}}" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="['' => 'جميع الانظمة'] +schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="النوع" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار النوع" :options="request('school_id') ? ['' => 'اختر النوع'] + App\Models\Gender::genders(true,request('school_id')) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="المرحلة" name="grade_id" data-placeholder="اختر المرحلة" data-msg="رجاء اختيار المرحلة" :options="request('gender_id') ? ['' => 'اختر المرحلة'] + App\Models\Grade::grades(true,request('gender_id')) : []" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="الصف الدراسي" name="level_id" data-placeholder="اختر الصف الدراسي" data-msg="رجاء اختيار الصف الدراسي" :options="request('grade_id') ?  ['' => 'اختر الصف'] + App\Models\Level::levels(true,request('grade_id')) : []" />
        </div>
    </div>
    <div class="row mb-1">

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="خطة السداد" name="plan_id" data-placeholder="اختر خطة السداد" data-msg="رجاء اختيار خطة السداد" :options="['' => 'جميع الخطط'] + App\Models\Plan::plans()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" select2="" label="افئة ولي الامر" name="category_id" data-placeholder="اختر افئة ولي الامر" data-msg="رجاء اختيار افئة ولي الامر" :options="['' => 'جميع الفئات'] + App\Models\Category::categories()" />
        </div>
    </div>
</x-forms.search>


<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">خصومات فترة السداد للغترة {{$period->prtiod_name}} للعام الدراسي {{ $year->year_name }}</x-slot>
    <x-slot name="cardbody">
        {{ sprintf('يمكنك ادناة الأطلاع علي جميع الخصومات المسجلة للفترة %s : من %s  - الي : %s  خلال العام الدراسي %s',$period->period_name,$period->apply_start->format('d-m-Y') , $period->apply_end->format('d-m-Y'),$year->year_name) }}
    </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('years.periods.discounts.create',[$year,$period]) }}">
            <em data-feather='plus-circle'></em> اضافة وتعديل الخصومات </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الفئة</th>
            <th scope="col">خطة السداد</th>
            <th scope="col">المرحلة</th>
            <th scope="col">الخصم</th>
            <th scope="col">بواسطة</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        <tr>
            @foreach ($discounts as $key => $discount)
            <th scope="row">
                {{ $discount->id }}
            </th>
            <td><span class="badge bg-{{$discount->color}}">{{ $discount->category_name }}</span></td>
            <td>{{ $discount->plan_name }}</td>
            <td>{{ $discount->level_name }}</td>
            <td>{{ $discount->rate }} %</td>
            <td>{{ $discount->admin_name }}</td>


            <td>
                @can('discounts-delete')
                <x-inputs.btn.delete :route="route('years.periods.discounts.destroy', [$year, $period, $discount])" />
                @endcan
            </td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection