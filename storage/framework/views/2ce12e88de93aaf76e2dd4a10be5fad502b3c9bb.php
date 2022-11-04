<?php foreach($attributes->onlyProps(['divClass' => '','value','id','checked']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['divClass' => '','value','id','checked']); ?>
<?php foreach (array_filter((['divClass' => '','value','id','checked']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="<?php echo e($divClass ?? 'form-check'); ?>">
    <?php echo Form::checkbox($name,$value ?? null,(isset($checked) && $checked == 1 ? true : old($name)),$attributes->getAttributes() +['id'=> $id ?? $name,'class'=>'form-check-input me-1' . ($errors->has($name) ? ' is-invalid' : null)]); ?>

    <label class="form-check-label mr-1" for="<?php echo e($id ?? $name); ?>"> <?php echo e($slot ?? ''); ?> </label>
    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <span class="invalid-feedback" role="alert">
        <strong><?php echo e($message); ?></strong>
    </span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/checkbox.blade.php ENDPATH**/ ?>