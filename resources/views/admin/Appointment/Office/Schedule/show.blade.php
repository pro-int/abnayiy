@extends('layouts.contentLayoutMaster')

@php
$day_name = App\Helpers\Helpers::daysArray($day->day_of_week);
$breadcrumbs = [[['link' => route('appointments.sections.index'), 'name' => "اقسام المقابلات"],['link' => route('appointments.offices.index'), 'name' => "مكاتب المقابلات"],['link' => route('appointments.offices.edit',$office), 'name' => " $office->office_name"],['link' => route('appointments.offices.days.index',$office), 'name' => "اعدادا المواعيد"],['link' => route('appointments.offices.days.destroy', [$office->id,$day->id]), 'name' => "يوم $day_name"]],['title'=> 'مشاهدة']];
@endphp


@section('title', sprintf('مشاهدة مواعيد المكتب رقم (%s) - %s - يوم %s',$office->id,$office->office_name,App\Helpers\Helpers::daysArray($day->day_of_week)))

@section('content')

@component('components.forms.formCard',['title' => sprintf('مشاهدة مواعيد المكتب رقم (%s) - %s - يوم %s',$office->id,$office->office_name,$day_name)])

{!! Form::model($day, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['appointments.offices.days.update', [$office,$day]]]) !!}

<x-ui.divider>معلومات المكتب</x-ui-divider>

<div class="row mb-1">
    <div class="col-md">
    <x-inputs.select.generic label="اليوم" name="day_of_week" :options="App\Helpers\Helpers::daysArray()" :disabled="true"/>
    </div>
</div>

<div class="row mb-1">
    <div class="col-md">
        <x-inputs.text.Input step="{{ env('MEETING_PERIOD',30) * 60 }}" type="time" label="بداية  المواعيد" name="time_from" placeholder="ادخل بداية  المواعيد" data-msg="'بداية  المواعيد بشكل صحيح" />
    </div>

    <div class="col-md">
        <x-inputs.text.Input  step="{{ env('MEETING_PERIOD',30) * 60 }}" type="time" label="نهاية المواعيد" name="time_to" placeholder="ادخل نهاية المواعيد" data-msg="'نهاية المواعيد بشكل صحيح" />
    </div>
</div>

<div class="row mb-1">
        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active" >مفعل</x-inpurs.checkbox>

    </div>


<div class="col-12 text-center mt-2">
    <x-inputs.link route="appointments.offices.days.index" :params="$office">عودة</x-inputs.link>
</div>
{!! Form::close() !!}

@endcomponent

@endsection