{!! Form::text($input_name,(isset($item) && isset($item->$input_name) ? $item->$input_name : (request()->input($input_name) ?? old($input_name))),['required' => !isset($NotRrequired),'placeholder'=> $placeholder,'class' => 'form-control'. ($errors->has($input_name) ? ' is-invalid' : null),'id' => $input_name]) !!}

@error($input_name)
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror