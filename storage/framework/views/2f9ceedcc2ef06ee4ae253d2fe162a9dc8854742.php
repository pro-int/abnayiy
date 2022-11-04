<?php foreach($attributes->onlyProps(['autoWith' => true]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['autoWith' => true]); ?>
<?php foreach (array_filter((['autoWith' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="row <?php echo e($autoWith ? 'td-auto-with' : null); ?>" id="table-striped">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title text-primary mt-50">
          <?php echo e($title ?? null); ?>

        </h3>
        <?php echo e($button ?? null); ?>

        
      </div>
      <div class="card-body">
        <p class="card-text text-dark mb-2">
          <?php echo e($cardbody); ?>

        </p>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <?php echo $thead ?? null; ?>

          </thead>
          <tbody>
            <?php echo $tbody ?? null; ?>

          </tbody>
        </table>

      </div>
      <div class="d-flex align-self-center mx-0 row m-2 ">
        <div class="col-md-12">

          <?php echo $pagination ?? null; ?>

        </div>
      </div>
    </div>
  </div>
</div><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/components/ui/table.blade.php ENDPATH**/ ?>