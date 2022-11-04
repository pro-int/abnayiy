@extends('layouts/contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('home'), 'name' => 'الرئيسية'], ['name' => 'الرموز']],['title' => 'ادارة رمز API']];
@endphp

@section('title', 'API Tokens')


@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
  @livewire('api.api-token-manager')
@endsection
