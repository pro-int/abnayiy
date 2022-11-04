@props(['options'=> [],'model','selected'])
{!! $label() !!}
{{ Form::select($name, count($options) > 0 ? $options : [''=> 'لا يوجد خيارات'], isset($selected) ? $selected : request()->$name ,$attributes->merge(['class' => 'form-select' . ($errors->has(str_replace('[]','',$name)) ? ' is-invalid' : null)])->getAttributes() + ['required' => true, 'id' => $id ?? $name]) }}

@error(str_replace('[]','',$name))
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror