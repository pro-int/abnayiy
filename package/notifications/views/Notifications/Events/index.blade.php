@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('sections.index'), 'name' => "مناسبات الأشعار"],  ['link' => route('sections.edit', $section), 'name' => "$section->section_name"]],['title'=> 'مناسبات القسم :' . $section->section_name]];
@endphp

@section('title', 'ادارة مناسبات قسم :' . $section->section_name)

@section('content')

<!-- Striped rows start -->
<x-ui.table>
      <x-slot name="title">ادارة مناسبات الأشعار </x-slot>
    <x-slot name="cardbody">ادارة مناسبات الأشعار الخاصة بالقسم <span class="text-danger">{{ $section->section_name }}</span></x-slot>

    <x-slot name="thead">
        <tr>
        <th scope="col">كود</th>
                <th scope="col">مناسبة الأشعار</th>
                <th scope="col">اسم القسم</th>
                <th scope="col">مرة واحدة</th>
                <th scope="col">متكرر</th>
            <th scope="col" style="min-width: 180px;">الاجراءات </th>
        </tr>
    </x-slot>

    <x-slot name="tbody">

    @foreach($events as $event)
                <th scope="row">
                    {{ $event->id }}
                </th>
                <td>{{ $event->event_name }}</td>
                <td>{{ $event->section_name }}</td>
                <td>{{ $event->single_allowed ? 'متاح' : 'غير متاح' }}</td>
                <td>{{ $event->frequent_allowed ? 'متاح' : 'غير متاح'  }}</td>

        <td>
        @can('notifications-edit')                
            <x-inputs.btn.edit :route="route('sections.events.edit',['section' =>$event->section_id,'event' => $event->id])" />
            @endcan

        </td>
        </tr>
        @endforeach
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

@endsection



@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
    <div class="pair_header">
        <h4>مناسبات الأشعارات</h4>
    </div>

    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">كود</th>
                <th scope="col">مناسبة الأشعار</th>
                <th scope="col">اسم القسم</th>
                <th scope="col">مرة واحدة</th>
                <th scope="col">متكرر</th>
                <th scope="col">الاجراءات المتاحة</th>
            </tr>
        </thead>

        <tbody>
            @foreach($events as $event)
            <tr class="table-light">
                <th scope="row">
                    {{ $event->id }}
                </th>
                <td>{{ $event->event_name }}</td>
                <td>{{ $event->section_name }}</td>
                <td>{{ $event->single_allowed ? 'متاح' : 'غير متاح' }}</td>
                <td>{{ $event->frequent_allowed ? 'متاح' : 'غير متاح'  }}</td>
              
                <td>
                    @can('notifications-edit')
                    <a class="btn btn-sm btn-success" href="{{ route('sections.events.edit',['section' =>$event->section_id,'event' => $event->id]) }}">تعديل</a>
                    @endcan
                </td>
            </tr>
            @endforeach


        </tbody>
    </table>
</div>

@endsection