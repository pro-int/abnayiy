@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('contents.index'), 'name' => "محتوي الأشعار"],['link' => route('contents.create'), 'name' => "اضافة"]],['title'=> 'اضافة محتوي جديد']];
@endphp

@section('title', 'اضافة محتوي جديد ')

@section('content')


@component('components.forms.formCard',['title' => 'اضافة محتوي جديد '])

{!! Form::open(['method' => 'POST','route' => 'contents.store']) !!}

<x-ui.divider>معلومات المحتوي</x-ui-divider>

    <x-slot name="button">
        <button type="button" class="btn btn-primary mb-1" onClick="GetDynamicContent(document.getElementById('event_id').value)">
            <em data-feather='info'></em> عرض المحتوي المتغير
        </button>
    </x-slot>
    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input icon="info" label="وصف المحتوي" name="content_name" placeholder="ادخل وصف المحتوي" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="القسم" name="section_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="['' => 'اختر'] + Gtech\AbnayiyNotification\Models\NotificationSection::sections()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="المناسبة" name="event_id" data-placeholder="اختر المناسبة" data-msg="رجاء اختيار المناسبة" :options="Gtech\AbnayiyNotification\Models\NotificationEvent::events()" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md-12">
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.input label="عنوان سالة البريد الألكتروني" name="email_subject" placeholder="ادخل عنوان سالة البريد الألكتروني" />
        </div>
        <div class="col-md">
            <x-inputs.text.input type="textarea" label="المحتوي البريد" name="email_content" placeholder="ادخل المحتوي البريد" rows="6" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.input type="textarea" label="المحتوي الداخلي" name="internal_content" placeholder="ادخل المحتوي الداخلي" rows="6" />

        </div>
        <div class="col-md">
            <x-inputs.text.input type="textarea" label="المحتوي الرسائل SMS" name="sms_content" placeholder="ادخل المحتوي الرسائل SMS" rows="6" />
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.input type="textarea" label="المحتوي تليجرام" name="telegram_content" placeholder="ادخل المحتوي تليجرام" rows="6" />
        </div>

        <div class="col-md">
            <x-inputs.text.input type="textarea" label="المحتوي واتساب" name="whatsapp_content" placeholder="ادخل المحتوي واتساب" rows="6" />
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <x-inputs.submit>اضافة المحتوي</x-inputs.submit>
        <x-inputs.link route="contents.index">عودة</x-inputs.link>
    </div>
    {!! Form::close() !!}

    @endcomponent

    <div class="modal fade add_back text-end" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmTransactionModal">المحتوي المتغير</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="res">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">عوده</button>
                </div>
            </div>
        </div>
    </div>
    @endsection