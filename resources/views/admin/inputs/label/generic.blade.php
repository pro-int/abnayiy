<label for="{{ $input_name }}" class="col-md-4 col-form-label text-md-right">{{ $text }}</label>
<div class="col-md-6">
    {!! Form::label($input_name,(isset($value) ? $value : (isset($item->$input_name) ? $item->$input_name : null)),['class' => 'form-control ' . (isset($class) ? $class : '')]) !!}
</div>