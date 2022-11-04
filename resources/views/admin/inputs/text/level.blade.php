<label for="level_name" class="col-md-4 col-form-label text-md-right">{{ $text }}</label>

<div class="col-md-6">
    <input id="level_name" type="text" class="form-control @error('level_name') is-invalid @enderror" name="level_name" value="{{ old('level_name') }}" required autocomplete="level_name" autofocus>

    @error('level_name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>