<?php foreach($attributes->onlyProps(['options'=> [],'select2' => 'select2','model']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['options'=> [],'select2' => 'select2','model']); ?>
<?php foreach (array_filter((['options'=> [],'select2' => 'select2','model']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php echo $label(); ?>

<?php echo e(Form::select($name, count($options) > 0 ? $options : [''=> 'لا يوجد خيارات'], isset($selected) ? $selected : request()->$name ,$attributes->getAttributes() + ['required' => true,'class'=> $select2 .' form-select '. ($errors->has($name) ? ' is-invalid' : null),'id' => $id ?? $name])); ?>


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
unset($__errorArgs, $__bag); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/select/generic.blade.php ENDPATH**/ ?>