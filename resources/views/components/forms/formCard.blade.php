<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">{!! $title ?? null !!}</h3>
                    </h3>
                    {{ $button ?? null }}
                </div>
                <div class="card-body">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</section>