<body class="vertical-layout vertical-menu-modern <?php echo e($configData['verticalMenuNavbarType']); ?> <?php echo e($configData['blankPageClass']); ?> <?php echo e($configData['bodyClass']); ?> <?php echo e($configData['sidebarClass']); ?> <?php echo e($configData['footerType']); ?> <?php echo e($configData['contentLayout']); ?>" data-open="click" data-menu="vertical-menu-modern" data-col="<?php echo e($configData['showMenu'] ? $configData['contentLayout'] : '1-column'); ?>" data-framework="laravel" data-asset-path="<?php echo e(asset('/')); ?>">

  <!-- BEGIN: Header-->
  <?php echo $__env->make('panels.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- END: Header-->

  <!-- BEGIN: Main Menu-->
  <?php if((isset($configData['showMenu']) && $configData['showMenu'] === true)): ?>
  <?php echo $__env->make('panels.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php endif; ?>
  <!-- END: Main Menu-->

  <!-- BEGIN: Content-->
  <div class="app-content content <?php echo e($configData['pageClass']); ?>">
    <!-- BEGIN: Header-->
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.alert','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if(($configData['contentLayout']!=='default') && isset($configData['contentLayout'])): ?>
    <div class="content-area-wrapper <?php echo e($configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : ''); ?>">
      <div class="<?php echo e($configData['sidebarPositionClass']); ?>">
        <div class="sidebar">
          
          <?php echo $__env->yieldContent('content-sidebar'); ?>
        </div>
      </div>
      <div class="<?php echo e($configData['contentsidebarClass']); ?>">

        <div class="content-wrapper">
          <div class="content-body">
            
            <?php echo $__env->yieldContent('content'); ?>
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="content-wrapper <?php echo e($configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : ''); ?>">
      
      <?php if($configData['pageHeader'] === true && isset($configData['pageHeader'])): ?>
      <?php echo $__env->make('panels.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>

      <div class="content-body">
        
        <?php echo $__env->yieldContent('content'); ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
  <!-- End: Content-->

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  
  <?php echo $__env->make('panels.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
  <?php echo $__env->make('panels.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <script type="text/javascript">
    $(window).on('load', function() {
      let item = $('.main-menu-content ul li a[href="' + window.location.href + '"]');
      if (!item.length) {
        item = $('.main-menu-content ul li a[href="' +  window.location.origin + window.location.pathname + '"]');
      }
     
      item.parent().addClass('active');
      item.parent().parent().parent().addClass('open')

      if (feather) {
        feather.replace({
          width: 14,
          height: 14
        });
      }
    })
  </script>
</body>

</html><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/layouts/verticalLayoutMaster.blade.php ENDPATH**/ ?>