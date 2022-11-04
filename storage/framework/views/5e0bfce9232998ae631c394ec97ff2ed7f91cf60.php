<?php foreach($attributes->onlyProps(['lock' => false]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['lock' => false]); ?>
<?php foreach (array_filter((['lock' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<button <?php echo e($attributes); ?> type="submit" class="<?php echo e($class ?? 'btn btn-primary me-1' . ($lock ? ' btn-page-block-custom ' : null)); ?>" ><?php echo e($slot); ?></button><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/submit.blade.php ENDPATH**/ ?>