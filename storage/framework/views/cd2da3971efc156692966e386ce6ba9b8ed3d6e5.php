<?php
$configData = Helper::applClasses();
?>


<?php $__env->startSection('title', 'صفحة غير موجود 404'); ?>

<?php $__env->startSection('page-style'); ?>
  
  <link rel="stylesheet" href="<?php echo e(asset(mix('css/base/pages/page-misc.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Error page-->
<div class="misc-wrapper">
  <a class="brand-logo" href="<?php echo e(route('home')); ?>">
    <?php if (isset($component)) { $__componentOriginalfe81a1d7f258410bdfb10701626540fd85d433e2 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Ui\Logo::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Ui\Logo::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfe81a1d7f258410bdfb10701626540fd85d433e2)): ?>
<?php $component = $__componentOriginalfe81a1d7f258410bdfb10701626540fd85d433e2; ?>
<?php unset($__componentOriginalfe81a1d7f258410bdfb10701626540fd85d433e2); ?>
<?php endif; ?>
  </a>
  <div class="misc-inner p-2 p-sm-3">
      <div class="w-100 text-center">
          <h2 class="mb-1">الصفحة المطلوبة غير موجودة 🕵🏻‍♀️</h2>
          <p class="mb-2">للاسف ! 😖 نعتذر لم نعثر علي الصفحة المطلوبة .. ربما تم نقلها الي رابط اخر .. او احد العناصر المطلوبة لعرض الصقحة غير متوفر.</p>
          <a class="btn btn-primary mb-2 btn-sm-block" href="<?php echo e(url()->previous()); ?>">العودة</a>
          <?php if($configData['theme'] === 'dark'): ?>
          <img class="img-fluid" src="<?php echo e(asset('images/pages/error-dark.svg')); ?>" alt="Error page" />
          <?php else: ?>
          <img class="img-fluid" src="<?php echo e(asset('images/pages/error.svg')); ?>" alt="Error page" />
          <?php endif; ?>
    </div>
  </div>
</div>
<!-- / Error page-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.fullLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/errors/404.blade.php ENDPATH**/ ?>