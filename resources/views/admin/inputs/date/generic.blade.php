<label for="{{ $input_name }}" class="col-md-4 col-form-label text-md-right">{{ $text }}</label>
<div class="col-md-6">
    {!! Form::date($input_name,(isset($value) ? $value : (isset($item->$input_name) ? $item->$input_name : old($input_name))),['required' => !isset($NotRrequired),'class' => 'form-control'. ($errors->has($input_name) ? ' is-invalid' : null),'id' => $input_name]) !!}

    @error($input_name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>