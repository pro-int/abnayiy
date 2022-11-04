{{-- For submenu --}}
<ul class="menu-content">
  @if(isset($menu))
  @foreach($menu as $submenu)
  <li>
    <a href="{{ isset($submenu->url) ? (Route::has($submenu->url) ? (isset($submenu->query) ? route($submenu->url,$submenu->query) : route($submenu->url)) : url($submenu->url)) : 'javascript:void(0)' }}" class="d-flex align-items-center" target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
      @if(isset($submenu->icon))
      <em data-feather="{{$submenu->icon}}"></em>
      @endif
      <span class="menu-item text-truncate">{{ $submenu->name }}</span>
    </a>
    @if (isset($submenu->submenu))
    @include('panels/submenu', ['menu' => $submenu->submenu])
    @endif
  </li>
  @endforeach
  @endif
</ul>
