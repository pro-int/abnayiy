<?php foreach($attributes->onlyProps(['route']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['route']); ?>
<?php foreach (array_filter((['route']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<button <?php echo e($attributes); ?>  class="btn btn-icon round btn-sm btn-outline-danger" data-bs-toggle="offcanvas" data-bs-target="#deleteModal" aria-controls="deleteRecord" data-bs-placement="right" <?php if(isset($route)): ?> data-href="<?php echo e($route); ?>" <?php endif; ?> title="حذف">
    <me data-feather="trash"></me>
    <span><?php echo e($slot ?? null); ?></span>

</button><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/btn/delete.blade.php ENDPATH**/ ?>