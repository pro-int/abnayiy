<!-- BEGIN: Vendor JS-->
<script src="<?php echo e(asset(mix('vendors/js/vendors.min.js'))); ?>"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo e(asset(mix('vendors/js/ui/jquery.sticky.js'))); ?>"></script>
<?php echo $__env->yieldContent('vendor-script'); ?>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="<?php echo e(asset(mix('js/core/app-menu.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('js/core/app.js'))); ?>"></script>

<!-- custome scripts file for user -->
<script src="<?php echo e(asset(mix('js/core/scripts.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/extensions/sweetalert2.all.min.js'))); ?>"></script>

<?php if($configData['blankPage'] === false): ?>
<script src="<?php echo e(asset(mix('js/scripts/customizer.js'))); ?>"></script>
<?php endif; ?>
<?php echo $__env->yieldContent('page-modal'); ?>
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
<?php echo $__env->yieldContent('page-script'); ?>
<!-- END: Page JS-->

<?php echo $__env->yieldPushContent('modals'); ?>
<?php echo \Livewire\Livewire::scripts(); ?>

<script defer src="<?php echo e(asset(mix('vendors/js/alpinejs/alpine.js'))); ?>"></script>
<?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/panels/scripts.blade.php ENDPATH**/ ?>