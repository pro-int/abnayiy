
<ul class="menu-content">
  <?php if(isset($menu)): ?>
  <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <li>
    <a href="<?php echo e(isset($submenu->url) ? (Route::has($submenu->url) ? (isset($submenu->query) ? route($submenu->url,$submenu->query) : route($submenu->url)) : url($submenu->url)) : 'javascript:void(0)'); ?>" class="d-flex align-items-center" target="<?php echo e(isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'); ?>">
      <?php if(isset($submenu->icon)): ?>
      <em data-feather="<?php echo e($submenu->icon); ?>"></em>
      <?php endif; ?>
      <span class="menu-item text-truncate"><?php echo e($submenu->name); ?></span>
    </a>
    <?php if(isset($submenu->submenu)): ?>
    <?php echo $__env->make('panels/submenu', ['menu' => $submenu->submenu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
  </li>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endif; ?>
</ul>
<?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/panels/submenu.blade.php ENDPATH**/ ?>