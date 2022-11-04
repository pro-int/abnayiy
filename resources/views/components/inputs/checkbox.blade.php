@props(['divClass' => '','value','id','checked'])
<div class="{{ $divClass ?? 'form-check' }}  mt-1">
    {!! Form::checkbox($name,$value ?? null,(isset($checked) && $checked == 1 ? true : old($name)),$attributes->getAttributes() +['id'=> $id ?? $name,'class'=>'form-check-input me-1' . ($errors->has(str_replace('[]','',$name)) ? ' is-invalid' : null)]) !!}
    <label class="form-check-label mr-1" for="{{ $id ?? $name}}"> {{$slot ?? '' }} </label>
    @error(str_replace('[]','',$name))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>