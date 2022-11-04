<?php foreach($attributes->onlyProps(['route','params' => []]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['route','params' => []]); ?>
<?php foreach (array_filter((['route','params' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<section id="collapsible">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h3 class="card-title"><em data-feather="search"></em> <?php echo e($text ?? ' البحث'); ?></h3>
                    <a class="btn btn-sm btn-outline-primary round waves-effect" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <em data-feather="search"></em>
                    </a>
                </div>
                <div class="card-body">
                    <div class="collapse <?php echo e(request()->except('page') ? 'show' : NULL); ?>" id="collapseExample">
                        <?php echo Form::open(['route' => [$route,$params] ,'method'=>'GET']); ?>

                        <?php echo e($slot); ?>

                        <div class="col-12 text-center mt-2">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.link','data' => ['route' => $route,'params' => $params]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($route),'params' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($params)]); ?>الغاء البحث <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Submit::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Submit::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>بــحــث <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a)): ?>
<?php $component = $__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a; ?>
<?php unset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a); ?>
<?php endif; ?>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/forms/search.blade.php ENDPATH**/ ?>