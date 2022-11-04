<label for="{{ $input_name }}" class="col-md-4 col-form-label text-md-right">{{ $text }}</label>
<div class="col-md-6">
    {{ Form::select($input_name, count($data) > 0 ? $data : [''=> 'لا يوجد خيارات'], (isset($id) ? $id : old($input_name)),['required' => !isset($NotRrequired),'class'=> 'select2 form-control'. ($errors->has($input_name) ? ' is-invalid' : null),'id' => $input_name,'disabled' => isset($disabled) ? $disabled : false, 'onLoad' => isset($onLoad) ? 'change' : '']) }}

    @error($input_name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>