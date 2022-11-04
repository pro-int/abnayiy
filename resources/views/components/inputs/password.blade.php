{!! $label() !!}

<div class="input-group input-group-merge form-password-toggle @error($name) is-invalid @enderror">
    <input {{ $attributes }} type="password" class="form-control form-control-merge @error($name) is-invalid @enderror" id="{{$name}}" name="{{$name}}" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="{{$name}}" />
    <span class="input-group-text cursor-pointer"><em data-feather="eye"></em></span>
</div>

@error($name)
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror