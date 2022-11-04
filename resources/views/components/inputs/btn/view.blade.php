@props(['route'])
<a {{$attributes}}  class="btn btn-icon round btn-sm btn-outline-success" href="{{ $route }}"  data-bs-toggle="tooltip" data-bs-placement="right" title="مشاهدة">
    <em data-feather="eye"></em>
    <span>{{ $slot ?? null }}</span>

</a>