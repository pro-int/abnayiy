@extends('layouts.contentLayoutMaster')
@php
$breadcrumbs = [[['link' => route('contents.index'), 'name' => "محتوي الأشعار"],['link' => route('contents.show',$content), 'name' => "محتوي الأشعار"]],['title'=> 'مشاهدة محتوي الأشعار']];
@endphp

@section('title', 'مشاهدة محتوي الأشعار : ' . $content->content_name)

@section('content')


@component('components.forms.formCard',['title' => sprintf('مشاهدة معلومات المحتوي : %s', $content->content_name)])

{!! Form::model($content, ['method' => 'PUT', 'onsubmit' => 'showLoader()','route' => ['contents.update', $content->id ]]) !!}

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
            <x-inputs.select.generic select2="" label="القسم" name="section_id" data-placeholder="اختر القسم" data-msg="رجاء اختيار القسم" :options="Gtech\AbnayiyNotification\Models\NotificationSection::sections()" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic select2="" label="المناسبة" name="event_id" data-placeholder="اختر المناسبة" data-msg="رجاء اختيار المناسبة" :options="Gtech\AbnayiyNotification\Models\NotificationEvent::events(1,$content->section_id)" />
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

    <div class="row mb-1">
        <label class="form-label mr-1" for="active"> الحالة </label>
        <x-inputs.checkbox name="active">مفعل</x-inpurs.checkbox>

    </div>

    <div class="col-12 text-center mt-2">
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