<div class="form-check form-check-inline">
    {!! Form::radio($name,$value ?? null,(isset($checked) && $checked == 1 ? true : NULL),$attributes->getAttributes() +['id'=> $id ?? $name,'class'=>'form-check-input me-1' . ($errors->has($name) ? ' is-invalid' : null)]) !!}
    <label class="form-check-label" for="{{ $is ?? $name }}">{{ $slot }}</label>
</div>
@error($name)
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror