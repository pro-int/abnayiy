@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year), 'name' => "$year->year_name"],['link' => route('years.periods.show',[$year,$period]), 'name' => $period->period_name ],['link' => route('years.periods.discounts.index',[$year,$period]), 'name' => "خصومات : $period->period_name"]],['title'=> 'ادارة خصومات '. $period->period_name]];
@endphp

@section('title', sprintf('اعدادات الخصومات للفترة %s - العام الدراسي %s ',$period->period_name,$year->year_name))

@section('content')

@component('components.forms.formCard',['title' => sprintf('اعدادات الخصومات للفترة %s - العام الدراسي %s ',$period->period_name,$year->year_name)])

<p class="card-text">{{ sprintf('خصومات الفترة : %s - من : %s الي %s ',$period->period_name ,$period->apply_start->format('d-m-Y'),$period->apply_end->format('d-m-Y'))}}</p>

<x-ui.divider>اختر المسار للبدء في اعداد الخصومات</x-ui-divider>
    <x-slot name="button">
        <x-inputs.link route="years.periods.discounts.index" :params="[$year,$period]">عودة</x-inputs.link>

    </x-slot>
    <input type="hidden" name="csrf-token" id="csrf-token" value="{{ csrf_token()  }}">
    <input type="hidden" name="period_id" id="period_id" value="{{ $period->id }}">
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.select.generic select2="" label="المدرسة" onLoad="change" name="school_id" data-placeholder="اختر المدرسة" data-msg="رجاء اختيار المدرسة" :options="schools()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic label="النوع" name="gender_id" data-placeholder="اختر النوع" data-msg="رجاء اختيار النوع" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic label="المرحلة" name="grade_id" data-placeholder="اختر المرحلة" data-msg="رجاء اختيار المرحلة" />
        </div>

    </div>

    <div class="row mb-1" id="resp_dev">

    </div>
    <div class="col-12 text-center mt-2">
        <x-inputs.link route="years.periods.discounts.index" :params="[$year,$period]">عودة</x-inputs.link>
    </div>

    @endcomponent

    @endsection