@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('sections.index'), 'name' => "محتوي الأشعار"],['link' => route('sections.edit',$section), 'name' => "تعديل القسم"]],['title'=> 'تعديل القسم : ' .$section->section_name]];
@endphp

@section('title', 'تعديل القسم : ' .$section->section_name)

@section('content')


@component('components.forms.formCard',['title' => 'تعديل القسم : ' .$section->section_name])

{!! Form::model($section, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['sections.update', $section->id ]]) !!}

<x-ui.divider>معلومات القسم</x-ui-divider>
  
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="file-text" label="اسم القسم" name="section_name" placeholder="ادخل اسم القسم" />
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>تعديل القسم</x-inputs.submit>
        <x-inputs.link route="sections.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    @endsection
    