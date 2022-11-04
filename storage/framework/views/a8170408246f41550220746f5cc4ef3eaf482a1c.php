<div class="form-check form-check-inline">
    <?php echo Form::radio($name,$value ?? null,(isset($checked) && $checked == 1 ? true : NULL),$attributes->getAttributes() +['id'=> $id ?? $name,'class'=>'form-check-input me-1' . ($errors->has($name) ? ' is-invalid' : null)]); ?>

    <label class="form-check-label" for="<?php echo e($is ?? $name); ?>"><?php echo e($slot); ?></label>
</div>
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
unset($__errorArgs, $__bag); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/inputs/radio.blade.php ENDPATH**/ ?>