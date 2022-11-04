@props(['route'])
<button {{$attributes}}  class="btn btn-icon round btn-sm btn-outline-danger" data-bs-toggle="offcanvas" data-bs-target="#deleteModal" aria-controls="deleteRecord" data-bs-placement="right" @if(isset($route)) data-href="{{ $route }}" @endif title="حذف">
    <me data-feather="trash"></me>
    <span>{{ $slot ?? null }}</span>

</button>