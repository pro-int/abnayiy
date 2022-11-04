<div class="content-header row">
  <div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
      <div class="col-12">
        <h2 class="content-header-title float-start mb-0"><?php echo e($breadcrumbs[1]['title'] ?? (isset($breadcrumbs[0]) ? $breadcrumbs[count($breadcrumbs[0])]['name'] : '')); ?> </h2>
        <div class="breadcrumb-wrapper">
          <?php if(@isset($breadcrumbs[0])): ?>
          <ol class="breadcrumb">
              
              <?php $__currentLoopData = $breadcrumbs[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="breadcrumb-item">
                  <?php if(isset($breadcrumb['link'])): ?>
                  <a href="<?php echo e($breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link']:url($breadcrumb['link'])); ?>">
                      <?php endif; ?>
                      <?php echo e($breadcrumb['name']); ?>

                      <?php if(isset($breadcrumb['link'])): ?>
                  </a>
                  <?php endif; ?>
              </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ol>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
    <div class="mb-1 breadcrumb-right">
      <div class="dropdown">
        <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="grid"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="#">
            <i class="me-1" data-feather="check-square"></i>
            <span class="align-middle">Todo</span>
          </a>
          <a class="dropdown-item" href="#">
            <i class="me-1" data-feather="message-square"></i>
            <span class="align-middle">Chat</span>
          </a>
          <a class="dropdown-item" href="#">
            <i class="me-1" data-feather="mail"></i>
            <span class="align-middle">Email</span>
          </a>
          <a class="dropdown-item" href="#">
            <i class="me-1" data-feather="calendar"></i>
            <span class="align-middle">Calendar</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/panels/breadcrumb.blade.php ENDPATH**/ ?>