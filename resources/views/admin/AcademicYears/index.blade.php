@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('years.index'), 'name' => "السنوات الدراسية"]],['title'=> 'السنوات الدراسية']];
@endphp

@section('title', 'ادارة السنوات الدراسية')

@section('content')

<!-- Striped rows start -->

<div class="row match-height">
    <div class="row d-flex flex-row-reverse mb-1">
        <div class="col col-md-3  d-flex flex-row-reverse">
            <a class="btn btn-primary mb-1" href="{{ route('years.create') }}">
                <em data-feather='plus-circle'></em> اضافة سنة دراسية </a>
        </div>
    </div>
    @foreach ($years as $year)
    <div class="col-lg-6 col-md-6 col-12">
        <div class="card card-profile">
            <div class="card-body">
                <h1 class="text-success">{{ $year->year_name }} </h1>
                <h3>({{ $year->year_numeric }})</h3>
                <h6 class="text">{{ sprintf('من %s  الي %s',$year->year_start_date->format('d-m-Y'),$year->year_end_date->format('d-m-Y') ) }}</h6>
                @if($year->current_academic_year)<span class="badge badge-light-primary profile-badge"> العام الحالي </span>@endif
                @if($year->is_open_for_admission)<span class="badge badge-light-success profile-badge"> متاح للتقديم </span> @else <span class="badge badge-light-danger profile-badge"> التقديم مغلق </span> @endif
                <hr class="mb-2" />
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-bolder">الاجراءات</h6>
                        @can('years-list')
                        <x-inputs.btn.view :route="route('years.show',$year->id)" />
                        @endcan

                        @can('years-edit')
                        <x-inputs.btn.edit :route="route('years.edit',$year->id)" />
                        @endcan

                        @can('years-delete')
                        <x-inputs.btn.delete :route="route('years.destroy', $year->id)" />
                        @endcan
                    </div>
                    @can('semesters-create')
                    <div>
                        <h6 class="text-muted fw-bolder">فصول الدراسية</h6>
                        <x-inputs.btn.generic colorClass="warning" :route="route('years.semesters.index', $year->id)">فصول السنة</x-inputs.btn.generic>
                    </div>
                    @endcan

                    @can('classes-create')
                    <div>
                        <h6 class="text-muted fw-bolder">فصول التدريس</h6>
                        <x-inputs.btn.generic icon="home" :route="route('years.classrooms.index', $year->id)">ادارة الفصول</x-inputs.btn.generic>
                    </div>
                    @endcan
                    @can('periods-create')
                    <div>
                        <h6 class="text-muted fw-bolder">فترات السداد</h6>
                        <x-inputs.btn.generic colorClass="success" icon="watch" :route="route('years.periods.index', $year->id)">ادارة فترات السداد</x-inputs.btn.generic>
                    </div>
                    @endcan
                    @can('periods-create')
                        <div>
                            <h6 class="text-muted fw-bolder">فترات طلبات الانسحاب</h6>
                            <x-inputs.btn.generic colorClass="danger" icon="watch" :route="route('years.withdrawalPeriods.index', $year->id)">ادارة فترات طلبات الانسحاب</x-inputs.btn.generic>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>



<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection
