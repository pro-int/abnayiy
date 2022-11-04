<?php foreach($attributes->onlyProps(['route','method','btnClass']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['route','method','btnClass']); ?>
<?php foreach (array_filter((['route','method','btnClass']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="offcanvas offcanvas-start" tabindex="-1" id="deleteModal" aria-labelledby="deleteModalLabel">
  <div class="offcanvas-header">
    <h5 id="deleteModalLabel" class="offcanvas-title">هل تريد تأكيد الحذف ؟</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body my-auto mx-0 flex-grow-0">
    <div class="text-center mb-2 text-danger">
      <me data-feather="trash-2" class="font-large-3"></me>
    </div>
    <p class="text-center" id="slot">
      في حالة حذف احد العناصر - يتم حذف جميع المعلومات المرتبطة بة
    </p>
    <?php echo Form::open(['url' => '','method'=>'DELETE','id'=> 'deleteFrom']); ?>

    <button type="submit" class="btn btn-<?php echo e($btnClass ?? 'danger'); ?> mb-1 d-grid w-100  btn-page-block-custom">تأكيد</button>
    <?php echo Form::close(); ?>

    <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
      تراجع
    </button>
  </div>
</div><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/ui/SideDeletePopUp.blade.php ENDPATH**/ ?>