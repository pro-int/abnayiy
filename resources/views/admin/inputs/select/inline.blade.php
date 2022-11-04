{{ Form::select($input_name, $data , (isset($id) ? $id : old($input_name)),['required' => !isset($NotRrequired),'class'=> 'form-select form-select-lg mb-3'. ($errors->has($input_name) ? ' is-invalid' : null),'id' => $input_name]) }}

@error($input_name)
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror