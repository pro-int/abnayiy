@props(['autoWith' => true])

<div class="row {{ $autoWith ? 'td-auto-with' : null }}" id="table-striped">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title text-primary mt-50">
          {{ $title ?? null  }}
        </h3>
        {{ $button ?? null }}
        
      </div>
      @if(isset($cardbody))
      <div class="card-body">
        <p class="card-text text-dark mb-2">
          {{$cardbody}}
        </p>
      </div>
      @endif
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            {!! $thead ?? null !!}
          </thead>
          <tbody>
            {!! $tbody ?? null !!}
          </tbody>
        </table>

      </div>
      <div class="d-flex align-self-center mx-0 row m-2 ">
        <div class="col-md-12">

          {!! $pagination ?? null !!}
        </div>
      </div>
    </div>
  </div>
</div>