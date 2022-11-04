@props(['route'])
<a {{$attributes}} class="dropdown-item text-danger" data-bs-toggle="offcanvas" data-bs-target="#deleteModal" aria-controls="deleteRecord" data-href="{{ $route }}">
    <me data-feather="trash" class="me-50"></me>
    <span>{{ $slot ?? null }}</span>
</a>
