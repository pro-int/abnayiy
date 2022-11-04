<div class="content-header row">
  <div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
      <div class="col-12">
        <h2 class="content-header-title float-start mb-0">{{ $breadcrumbs[1]['title'] ?? (isset($breadcrumbs[0]) ? $breadcrumbs[count($breadcrumbs[0])]['name'] : '') }} </h2>
        <div class="breadcrumb-wrapper">
          @if(@isset($breadcrumbs[0]))
          <ol class="breadcrumb">
          <li class="breadcrumb-item">
                  <a href="{{route('home')}}"><em data-feather="home"></em> الرئيسية</a>
              </li>
              {{-- this will load breadcrumbs dynamically from controller --}}
              @foreach ($breadcrumbs[0] as $breadcrumb)
              <li class="breadcrumb-item">
                  @if(isset($breadcrumb['link']))
                  <a href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link']:url($breadcrumb['link']) }}">
                      @endif
                      {{$breadcrumb['name']}}
                      @if(isset($breadcrumb['link']))
                  </a>
                  @endif
              </li>
              @endforeach
          </ol>
          @endisset
        </div>
      </div>
    </div>
  </div>
  <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
    <div class="mb-1 breadcrumb-right">
      <div class="dropdown">
        <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <em data-feather="grid"></em>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="{{ route('applications.index',['status_id' => 1]) }}">
            <em class="me-1" data-feather="calendar"></em>
            <span class="align-middle">الطلبات الجديدة</span>
          </a>
          <a class="dropdown-item" href="{{ route('students.index') }}">
            <em class="me-1" data-feather="check-square"></em>
            <span class="align-middle">قائمة الطلاب</span>
          </a>
          <a class="dropdown-item" href="{{ route('applications.index') }}">
            <em class="me-1" data-feather="message-square"></em>
            <span class="align-middle">طلبات الألتحاق</span>
          </a>
          <a class="dropdown-item" href="{{ route('transfers.index') }}">
            <em class="me-1" data-feather="mail"></em>
            <span class="align-middle">طلبات النقل</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
