<div class="form-check">
    {!! Form::checkbox('active',null,(isset($checked) && $checked == 1 ? true : old('active')) ,['class' => 'form-check-input','id' => 'active']) !!}
    {{ Form::label('active', 'مفعل',['class'=> 'form-check-label']) }}
    @error('active')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>