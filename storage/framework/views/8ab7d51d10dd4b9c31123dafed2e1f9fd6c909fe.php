<?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if(Session::has('alert-' . $msg)): ?>
<div class="alert alert-<?php echo e($msg); ?>" role="alert">
    <div class="alert-body">
        <?php echo Session::get('alert-' . $msg); ?>

    </div>
</div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/ui/alert.blade.php ENDPATH**/ ?>