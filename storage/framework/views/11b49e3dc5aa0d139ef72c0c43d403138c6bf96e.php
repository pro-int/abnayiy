

<?php $__env->startSection('title', 'تسجيل الدخول'); ?>

<?php $__env->startSection('page-style'); ?>

<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/pages/authentication.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-wrapper auth-basic px-2">
  <div class="auth-inner my-2">
    <!-- Login basic -->
    <div class="card mb-0">
      <div class="card-body">
        <a href="/" class="brand-logo">
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

        <h4 class="card-title mb-1">👋 اهلا بك في ابنائي!</h4>
        <p class="card-text mb-2">رجاء استخدام رقم الجوال او البريد الأليكتروني لتسجيل الدخول</p>

        <?php if(session('status')): ?>
        <div class="alert alert-success mb-1 rounded-0" role="alert">
          <div class="alert-body">
            <?php echo e(session('status')); ?>

          </div>
        </div>
        <?php endif; ?>

        <form class="auth-login-form mt-2" method="POST" action="<?php echo e(route('login')); ?>">
          <?php echo csrf_field(); ?>
          <div class="mb-1">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'الجوال/ البريد الأليكتروني','name' => 'username'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'رقم الجوال او البريد الألكيتروني','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>

          </div>

          <div class="mb-1">
            <?php if (isset($component)) { $__componentOriginal25139e3851c4ed17d42e36348a81c779f02c6739 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Password::class, ['enableForgotPassword' => 'true','name' => 'password','label' => 'كلمة المرور'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.password'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Password::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25139e3851c4ed17d42e36348a81c779f02c6739)): ?>
<?php $component = $__componentOriginal25139e3851c4ed17d42e36348a81c779f02c6739; ?>
<?php unset($__componentOriginal25139e3851c4ed17d42e36348a81c779f02c6739); ?>
<?php endif; ?>

          </div>
          <div class="mb-1">
            <?php if (isset($component)) { $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Checkbox::class, ['name' => 'remember'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Checkbox::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
              تذكرني
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543)): ?>
<?php $component = $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543; ?>
<?php unset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543); ?>
<?php endif; ?>
          </div>
          
          <?php if (isset($component)) { $__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Submit::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Submit::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'btn btn-primary w-100']); ?>تسجيل الدخول <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a)): ?>
<?php $component = $__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a; ?>
<?php unset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a); ?>
<?php endif; ?>
        </form>

        <p class="text-center mt-2">
          <span>ليس لديك حساب ؟</span>
          <?php if(Route::has('register')): ?>
          <a href="<?php echo e(route('register')); ?>">
            <span>تسجيل مدير جديد</span>
          </a>
          <?php endif; ?>
        </p>
      </div>
    </div>
    <!-- /Login basic -->
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.fullLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/auth/login.blade.php ENDPATH**/ ?>