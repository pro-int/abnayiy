<?php
$configData = Helper::applClasses();
?>


<?php $__env->startSection('title', 'خطأ في اعدادات النظام'); ?>

<?php $__env->startSection('page-style'); ?>
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/pages/page-misc.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Not authorized-->
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
      <h2 class="mb-1">خطأ في اعدادات النظام <em data-feather='alert-circle'></em></h2>
      <p class="mb-2">للاسف ! 😖 نعتذر ولكن اعدادات النظام لم تتم بالشكل الصحيح .</p>

      <h3 class="mb-2  text-danger"><?php echo e($message); ?></h3>
      <?php if($configData['theme'] === 'dark'): ?>
      <img class="img-fluid" src="<?php echo e(asset('images/pages/error-dark.svg')); ?>" alt="Not authorized page" />
      <?php else: ?>
      <img class="img-fluid" src="<?php echo e(asset('images/pages/error.svg')); ?>" alt="Not authorized page" />
      <?php endif; ?>
    </div>
    <div class="text-center">
      <a class="btn btn-primary mb-1 btn-sm-block mt-2" href="<?php echo e(url()->previous()); ?>">العودة للصفحة السابقة</a>
    </div>
  </div>
</div>
<!-- / Not authorized-->
</section>
<!-- maintenance end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.fullLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/errors/400.blade.php ENDPATH**/ ?>