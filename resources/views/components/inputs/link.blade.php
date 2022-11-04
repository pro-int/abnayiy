@props(['route','params' => []])
<a {{ $attributes }} class="btn btn-outline-secondary waves-effect me-1" href="{{ route($route,$params) }}">{{ $slot }}</a>