<?php foreach($attributes->onlyProps(['selected' => '']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['selected' => '']); ?>
<?php foreach (array_filter((['selected' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php echo $label(); ?>


<select <?php echo e($attributes); ?> class="form-select <?php echo e($errors->has($name) ? 'is-invalid' : ''); ?>" name="<?php echo e($name); ?>" id="<?php echo e($name); ?>" required>
    <?php $__currentLoopData = $clolrsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option class="badge bg-<?php echo e($color['class']); ?>" value="<?php echo e($color['class']); ?>" <?php if((old($name) && $color['class']==old($name)) || $selected == $color['class']): ?> selected <?php endif; ?>><?php echo e($color['text']); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>
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
unset($__errorArgs, $__bag); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/select/color.blade.php ENDPATH**/ ?>