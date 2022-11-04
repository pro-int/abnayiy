<label for="{{ $input_name }}" class="col-md-4 col-form-label text-md-right">{{ $text }}</label>
<div class="col-md-6">
    {!! Form::password($input_name,['autocomplete' => 'new-password' ,'placeholder'=> $text ,'class' => 'form-control'. ($errors->has($input_name) ? ' is-invalid' : null),'required' => !isset($NotRrequired)]) !!}

    @error($input_name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>