<?php foreach($attributes->onlyProps(['route','colorClass' => 'primary','icon']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['route','colorClass' => 'primary','icon']); ?>
<?php foreach (array_filter((['route','colorClass' => 'primary','icon']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<a <?php echo e($attributes->merge(['class' => 'btn btn-sm round btn-outline-'. $colorClass .  ($slot == '' ? ' btn-icon' : '')])); ?> href="<?php echo e($route ?? 'javascript:void(0);'); ?>" data-bs-toggle="tooltip" data-bs-placement="right" >
    <em data-feather="<?php echo e($icon ?? 'info'); ?>"></em>
    <span><?php echo e($slot ?? null); ?></span>
</a><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/btn/generic.blade.php ENDPATH**/ ?>