@php
$configData = Helper::applClasses();
@endphp
<div
  class="main-menu menu-fixed {{ $configData['theme'] === 'dark' || $configData['theme'] === 'semi-dark' ? 'menu-dark' : 'menu-light' }} menu-accordion menu-shadow"
  data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item me-auto">
        <a class="navbar-brand" href="{{ url('/') }}">
          <span class="brand-logo">
            <x-ui.logo />
          </span>
        </a>
      </li>
      <li class="nav-item nav-toggle">
        <a class="nav-link modern-nav-toggle pe-0" data-toggle="collapse">
          <em class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></em>
          <em class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc"
            data-ticon="disc"></em>
        </a>
      </li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      {{-- Foreach menu item starts --}}

      @if (!Auth::user()->hasRole(\Spatie\Permission\Models\Role::where("name","parent")->first())  && isset($menuData[0]))
        @foreach ($menuData[0]->menu as $menu)
          @if (isset($menu->navheader))
            <li class="navigation-header">
              <span>{{ __('locale.' . $menu->navheader) }}</span>
              <em data-feather="more-horizontal"></em>
            </li>
          @else
            {{-- Add Custom Class with nav-item --}}
            @php
              $custom_classes = '';
              if (isset($menu->classlist)) {
                  $custom_classes = $menu->classlist;
              }
            @endphp
            <li
              class="nav-item {{ $custom_classes }}">
              <a href="{{ isset($menu->url) ? (Route::has($menu->url) ? route($menu->url) : url($menu->url)) : 'javascript:void(0)' }}" class="d-flex align-items-center"
                target="{{ isset($menu->newTab) ? '_blank' : '_self' }}">
                <em data-feather="{{ $menu->icon }}"></em>
                <span class="menu-title text-truncate">{{ $menu->name }}</span>
                @if (isset($menu->badge))
                  <?php $badgeClasses = 'badge rounded-pill badge-light-primary ms-auto me-1'; ?>
                  <span
                    class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{ $menu->badge }}</span>
                @endif
              </a>
              @if (isset($menu->submenu))
                @include('panels.submenu', ['menu' => $menu->submenu])
              @endif
            </li>
          @endif
        @endforeach
      @endif
      {{-- Foreach menu item ends --}}
    </ul>
  </div>
</div>
<!-- END: Main Menu-->
