@props(['type' => 'number','model'])
{!! $label() !!}
<div class="input-group w-100">
    {!! Form::$type($name,isset($value) ? $value : request()->$name, $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : null)])->getAttributes() + ['required' => true,'id' => $id ?? $name]) !!}
    
    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

</div>    
