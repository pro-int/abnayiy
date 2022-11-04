@props('label')
@if(!empty($label)) <label class="form-label" for="fp-default">{{$label}}</label> @endif
<input {{ $attributes }} type="text" id="{{$name}}" name={{$name}} class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" />

{{ Form:: }}