<input name="{{ $input_name }}" type="{ isset($type) ? $type : 'text }}" class="form-control form-control @error($input_name) is-invalid @enderror" value="{{ isset($item->$input_name) ? $item->$input_name : old($input_name) }}" id="{{ $input_name }}" placeholder="{{ $text }}" required />
<label for="{{ $input_name }}">{{ $text }}</label>
@error($input_name)
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror
