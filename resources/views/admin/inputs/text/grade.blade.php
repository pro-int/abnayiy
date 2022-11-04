<label for="grade_name" class="col-md-4 col-form-label text-md-right">{{ $text }}</label>

<div class="col-md-6">
    <input id="grade_name" type="text" class="form-control @error('grade_name') is-invalid @enderror" name="grade_name" value="{{ old('grade_name') }}" required autocomplete="grade_name" autofocus>

    @error('grade_name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>