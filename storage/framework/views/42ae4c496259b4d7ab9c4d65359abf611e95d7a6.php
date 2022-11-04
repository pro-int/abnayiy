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
<a <?php echo e($attributes); ?>  class="btn btn-icon round btn-sm btn-outline-primary" href="<?php echo e($route); ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="تعديل">
    <em data-feather="edit-2"></em>
    <span><?php echo e($slot ?? null); ?></span>

</a><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/btn/edit.blade.php ENDPATH**/ ?>