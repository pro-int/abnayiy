@props(['route','colorClass'])
<a {{$attributes}} class="dropdown-item text-{{ $colorClass ?? 'primary' }}" href="{{ $route ?? 'javascript:void(0);' }}">
    <em data-feather="{{$icon ?? 'info'}}" class="me-50"></em>
    <span>{{ $slot ?? null }}</span>
</a>