@props(['route'])
<a {{$attributes}}  class="btn btn-icon round btn-sm btn-outline-primary" href="{{ $route }}" data-bs-toggle="tooltip" data-bs-placement="right" title="تعديل">
    <em data-feather="edit-2"></em>
    <span>{{ $slot ?? null }}</span>

</a>