@props(['color' => 'primary'])
<div class="divider divider-{{$color}}">
    <div class="divider-text">
    <h5 class="text-{{$color}} fw-600 m-2"> {!! $slot !!}</h5>
   </div>
</div>