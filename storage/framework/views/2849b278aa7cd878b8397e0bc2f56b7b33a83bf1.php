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
<a <?php echo e($attributes); ?> class="btn btn-outline-secondary waves-effect me-1" href="<?php echo e(route($route,$params)); ?>"><?php echo e($slot); ?></a><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/link.blade.php ENDPATH**/ ?>