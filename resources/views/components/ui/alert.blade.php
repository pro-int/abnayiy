@foreach (['danger', 'warning', 'success', 'info', 'secondary', 'primary'] as $msg)
@if(Session::has('alert-' . $msg))
<div class="alert alert-{{ $msg }}" role="alert">
    <div class="alert-body">
        {!! Session::get('alert-' . $msg) !!}
    </div>
</div>
@endif
@endforeach
