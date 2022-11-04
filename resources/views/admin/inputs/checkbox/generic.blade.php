<label class="col-md-4 col-form-label text-md-right">{{ $text }}</label>
<div class="col-md-6">
    <div class="form-check">
        {!! Form::checkbox($input_name,null,(isset($checked) && $checked == 1 ? true : old($input_name)),['id'=> $input_name,'class'=>'form-check-input' . ($errors->has($input_name) ? ' is-invalid' : null)]) !!}
        {{ Form::label($input_name, (isset($label) ? $label : $text),['class'=> 'form-check-label']) }}
        @error($input_name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>