<?php foreach($attributes->onlyProps(['type' => 'text','model','value']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['type' => 'text','model','value']); ?>
<?php foreach (array_filter((['type' => 'text','model','value']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php echo $hasLabel(); ?>


<div class="input-group input-group-merge <?php echo e($errors->has($name) ? ' is-invalid' : null); ?>">
  <span class="input-group-text"><em data-feather="<?php echo e($icon); ?>"></em></span>
  <?php echo Form::$type($name, $value ??  request()->$name, $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : null)])->getAttributes() + ['required' => true,'id' => $id ?? $name]); ?>

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
</div>
<?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/text/withIcon.blade.php ENDPATH**/ ?>