<?php
$configData = Helper::applClasses();
?>


<?php $__env->startSection('title', 'وصول غير مسموح'); ?>

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
      <h2 class="mb-1">وصول غير مسموح بة 🔐</h2>
      <p class="mb-2">نعتذر انت تحاول الوصول الي صفحة ليست ضمن حدود الصلاحيات الممنوحة لك .. رجاء التواصل مع مدير النظام لطلب صلاحية الوصول اولا .. قم حاول مرة اخري</p>
      <a class="btn btn-primary mb-1 btn-sm-block" href="<?php echo e(url()->previous()); ?>">العودة للصفحة السابقة</a>
      <?php if($configData['theme'] === 'dark'): ?>
      <img class="img-fluid" src="<?php echo e(asset('images/pages/not-authorized-dark.svg')); ?>" alt="Not authorized page" />
      <?php else: ?>
      <img class="img-fluid" src="<?php echo e(asset('images/pages/not-authorized.svg')); ?>" alt="Not authorized page" />
      <?php endif; ?>
    </div>
  </div>
</div>
<!-- / Not authorized-->
</section>
<!-- maintenance end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/fullLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/errors/403.blade.php ENDPATH**/ ?>