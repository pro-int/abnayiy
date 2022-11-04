<?php foreach($attributes->onlyProps(['color' => 'primary']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['color' => 'primary']); ?>
<?php foreach (array_filter((['color' => 'primary']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="divider divider-<?php echo e($color); ?>">
    <div class="divider-text">
    <h5 class="text-<?php echo e($color); ?> fw-600 m-2"> <?php echo e($slot); ?></h5>
   </div>
</div><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/ui/divider.blade.php ENDPATH**/ ?>