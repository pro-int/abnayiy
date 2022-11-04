<label for="{{ $input_name }}" class="col-md-4 col-form-label text-md-right">{{ $text }}</label>

<div class="col-md-6">
    {{ Form::select($input_name, $data , (isset($id) ? $id : old($input_name)),['multiple' => true,'required' => !isset($NotRrequired),'class'=> 'select2 form-control'. ($errors->has(str_replace('[]','',$input_name)) ? ' is-invalid' : null),'id'=> (isset($id)) ? $id : $input_name ]) }}

    @error(str_replace('[]','',$input_name))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>