@props(['selected' => ''])
{!! $label() !!}

<select {{ $attributes }} class="form-select {{ $errors->has($name) ? 'is-invalid' : '' }}" name="{{$name}}" id="{{$name}}" required>
    @foreach($clolrsData as $color)
    <option class="badge bg-{{$color['class']}}" value="{{$color['class']}}" @if((old($name) && $color['class']==old($name)) || $selected == $color['class']) selected @endif>{{$color['text']}}</option>
    @endforeach

</select>
@error($name)
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror