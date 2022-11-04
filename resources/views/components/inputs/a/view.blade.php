@props(['route'])
<a {{$attributes}}  class="dropdown-item text-success" href="{{ $route ?? 'javascript:void(0);' }}"  data-bs-toggle="tooltip" data-bs-placement="right" title="مشاهدة">
    <em data-feather="eye" class="me-50"></em>
    <span>{{ $slot ?? null }}</span>
</a>