<label for="{{ $input_name }}" class="col-md-4 col-form-label text-md-right">{{ $text }}</label>

<div class="col-md-6">
    <select class="form-control {{ $errors->has($input_name) ? ' is-invalid' : '' }}" name="{{$input_name}}" id="{{$input_name}}" required>
        
        @foreach(App\Models\Helper::colors() as $color)
    <option class="badge badge-{{$color['class']}}" value="{{$color['class']}}">{{$color['text']}}</option>
    @endforeach
</select>
    @error($input_name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>