<label class="col-md-4 col-form-label text-md-right">الحالة</label>

<div class="col-md-6">
    <div class="form-check">
        {!! Form::checkbox('active',null,(isset($checked) && $checked == 1 ? true : old('active')),['id'=> 'active','class'=>'form-check-input']) !!}
        {{ Form::label('active', 'مفعل',['class'=> 'form-check-label']) }}
    </div>
    @error('active')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>