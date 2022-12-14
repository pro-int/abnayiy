
@extends('layouts.contentLayoutMaster')

@section('title', 'الرئيسية')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
  <div class="row match-height">
    <!-- Statistics Card -->
    <div class="col-6" style="margin: auto;">
      <div class="card card-statistics">
        <div class="card-header">
          <h4 class="card-title">مرحبا بك ... {{ Auth::user()->first_name }}</h4>
        </div>
        <div class="card-body statistics-body">
          <div class="row">
              <div class="col-lg-12">
                  <a href="{{route('parent.showChildrens')}}">
                      <button type="button" class="btn btn-info mb-1">أبنائي</button>
                  </a>

                  <a href="{{route('parent.applications.create')}}">
                      <button type="button" class="btn btn-primary mb-1">تقديم طلب التحاق</button>
                  </a>

                  <a href="{{route('parent.withdrawals.create')}}">
                      <button type="button" class="btn btn-dark mb-1">تقديم طلب انسحاب</button>
                  </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Statistics Card -->
  </div>

</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/dashboard-ecommerce.js')) }}"></script>
@endsection
