@props(['route','params' => []])
<section id="collapsible">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h3 class="card-title"><em data-feather="search"></em> {{ $text ?? ' البحث' }}</h3>
                    <a class="btn btn-sm btn-icon btn-outline-primary round waves-effect" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <em data-feather="search"></em>
                    </a>
                </div>
                <div class="card-body">
                    <div class="collapse {{ request()->except('page') ? 'show' : NULL }}" id="collapseExample">
                        {!! Form::open(['route' => [$route,$params] ,'method'=>'GET' , 'onsubmit' => 'showLoader(5000)']) !!}
                        {{ $slot }}
                        <div class="col-12 text-center mt-2">
                            @if(request()->except('page'))
                            <x-inputs.link :route="$route" :params="$params">الغاء البحث</x-inputs.link>
                            @endif
                            <x-inputs.submit value="search" >بــحــث</x-inputs.submit>
                            {{ $export ?? null }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>