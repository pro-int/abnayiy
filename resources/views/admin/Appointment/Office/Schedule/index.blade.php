@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('appointments.sections.index'), 'name' => "اقسام المقابلات"],['link' => route('appointments.offices.index'), 'name' => "مكاتب المقابلات"],['link' => route('appointments.offices.edit',$office), 'name' => " $office->office_name"],['link' => route('appointments.offices.days.index',$office), 'name' => "اعدادا المواعيد"]],['title'=> 'اعدادات المواعيد']];
@endphp

@section('title', sprintf('اعدادات المواعيد المكتب رقم (%s) - %s',$office->id, $office->office_name))

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">{{ sprintf('اعدادات المواعيد المكتب رقم (%s) - %s',$office->id, $office->office_name) }}</x-slot>
    <x-slot name="cardbody">من خلال هذة الشاشة يمكن اعدادات مواعيد العمل الخاصة بالمكتب خلال ايام الأسبوع</x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('appointments.offices.days.create',[$office->id]) }}">
            <em data-feather='plus-circle'></em> اضافة يوم </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
        <th scope="col">كود</th>
                <th scope="col">اليوم</th>
                <th scope="col">من</th>
                <th scope="col">إلى</th>
                <th scope="col">الحالة</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

    @foreach ($schedules as $schedule)
        <tr>
        <th scope="row">
                    {{ $schedule->id }}
                </th>
                <td>{{ App\Models\officeSchedule::daysArray($schedule->day_of_week)  }}</td>
                <td>{{ Carbon\Carbon::parse($schedule->time_from)->format('H:m') }}</td>
                <td>{{ Carbon\Carbon::parse($schedule->time_to)->format('h:i') }}</td>
                <td>{{ $schedule->active ? 'فعال' : 'غير مفعل' }}</td>
            <td>
              
            @can('appointments-list')
                <x-inputs.btn.view :route="route('appointments.offices.days.show',[$schedule->office_id,$schedule->id])" />
                @endcan

                @can('appointments-edit')
                <x-inputs.btn.edit :route="route('appointments.offices.days.edit',[$schedule->office_id,$schedule->id])" />
                @endcan

                @can('appointments-delete')
                <x-inputs.btn.delete :route="route('appointments.offices.days.destroy', [$schedule->office_id,$schedule->id])" />
                @endcan
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
