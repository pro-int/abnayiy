@props(['type' => 'text','model','value','divClass' => ''])
{!! $hasLabel() !!}

<div  class="{{ $divClass }} input-group input-group-merge {{ $errors->has($name) ? ' is-invalid' : null }}">
  <span class="input-group-text"><em data-feather="{{$icon}}"></em></span>
  {!! Form::$type($name, $value ??  request()->$name, $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : null)])->getAttributes() + ['required' => true,'id' => $id ?? $name]) !!}
  @error($name)
  <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>
