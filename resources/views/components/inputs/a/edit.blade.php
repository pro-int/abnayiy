@props(['route'])
<a {{ $attributes }} class="dropdown-item text-primary" href="{{ $route ?? 'javascript:void(0)' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="تعديل" >
    <em data-feather="edit-2" class="me-50"></em>
    <span>{{ $slot ?? null }}</span>
</a>