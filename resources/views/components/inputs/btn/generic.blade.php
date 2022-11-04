@props(['route','colorClass' => 'primary','icon'])
<a {{ $attributes->merge(['class' => 'btn btn-sm round btn-outline-'. $colorClass .  ($slot == '' ? ' btn-icon' : '')]) }} href="{{ $route ?? 'javascript:void(0);' }}" data-bs-toggle="tooltip" data-bs-placement="right" >
    <em data-feather="{{$icon ?? 'info'}}"></em>
    <span>{{ $slot ?? null }}</span>
</a>