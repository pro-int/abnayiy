

<?php $__env->startSection('title', 'الأدوار'); ?>

<?php $__env->startSection('vendor-style'); ?>
<!-- Vendor css files -->
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php
$breadcrumbs = [[['link' => route('roles.index'), 'name' => "الأدوار"]],['title'=>'ادارة الأدوار']];

?>

<?php $__env->startSection('page-style'); ?>
<!-- Page css files -->
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/form-validation.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<h3>ادارة المستويات الأدارية</h3>
<p class="mb-2">
  الأدوار تلعب دور هام في النظام .. كل دور في النظام لدية مجموعة من الصلاحيات اللازمة لاتمام جميع العمليات الخاصة بالدور .
</p>

<!-- Role cards -->
<div class="row">
  <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <span><?php echo e($role->users->count()); ?> مستخدم</span>
          <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 fix-afatar">
            <?php $__currentLoopData = $role->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="<?php echo e($user->id . ' : ' . $user->first_name); ?>" class="avatar avatar-sm pull-up">
              <img class="rounded-circle" src="<?php echo e(asset($user->profile_photo_path ?? 'images/avatars/'.rand(1,12).'-small.png')); ?>" alt="<?php echo e($user->first_name); ?>" />
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
          <div class="role-heading">
            <h4 class="fw-bolder"><?php echo e($role->display_name); ?> (<?php echo e($role->name); ?>)</h4>
            <a href="<?php echo e(route('roles.edit',$role->id)); ?>" class="role-edit-modal">
              <small class="fw-bolder">تعديل</small>
            </a>
          </div>

          <a class="text-danger" data-bs-toggle="offcanvas" data-bs-target="#deleteModal" aria-controls="deleteRecord" data-bs-toggle="tooltip" data-bs-placement="right" title="حدف" data-href="<?php echo e(route('roles.destroy',$role->id)); ?>">
            <me data-feather="trash"></me>
          </a>

        </div>
      </div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.SideDeletePopUp','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.SideDeletePopUp'); ?>
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

  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="row">
        <div class="col-sm-7">
          <div class="card-body text-sm-start text-center">
            <a href="<?php echo e(route('roles.create')); ?>">
              <span class="btn btn-primary mb-1">اضافة دور جديد</span>
            </a>
            <p class="mb-0">دور غير مسجل ؟ سجلة الان</p>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="d-flex align-items-end justify-content-center h-100">
            <img src="<?php echo e(asset('images/illustration/faq-illustrations.svg')); ?>" class="img-fluid mt-2" alt="Image" width="85" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Role cards -->

<!-- Striped rows start -->
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.table','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
   <?php $__env->slot('title', null, []); ?> المديرين المسجلين بالنظام <?php $__env->endSlot(); ?>
   <?php $__env->slot('cardbody', null, []); ?> قائمة بجميع المديرين المسجلين في النظام و الأدوار الممنوحة لهم. <?php $__env->endSlot(); ?>

   <?php $__env->slot('thead', null, []); ?> 
    <tr>
      <th>كود</th>
      <th>الاسم الاول</th>
      <th>الاسم الاخير</th>
      <th>البريد</th>
      <th>رقم الجوال</th>
      <th>الدولة</th>
      <th>الاجراءات المتاحة</th>
    </tr>
   <?php $__env->endSlot(); ?>

   <?php $__env->slot('tbody', null, []); ?> 
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
      <td>#<?php echo e($user->id); ?></td>
      <td><?php echo e($user->first_name); ?></td>
      <td><?php echo e($user->last_name); ?></td>
      <td><?php echo e($user->email); ?></td>
      <td><?php echo e($user->phone); ?></td>
      <td><?php echo e($user->country_name); ?></td>

      <td>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.view','data' => ['route' => route('users.show',$user->id)]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('users.show',$user->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-edit')): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.edit','data' => ['route' => route('users.edit',$user->id)]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('users.edit',$user->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-delete')): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.delete','data' => ['route' => route('admins.destroy',$user->id)]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admins.destroy',$user->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
   <?php $__env->endSlot(); ?>

   <?php $__env->slot('pagination', null, []); ?> 
    <?php echo e($users->appends(request()->except('page'))->links()); ?>

   <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.SideDeletePopUp','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.SideDeletePopUp'); ?>
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

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.SideDeletePopUp','data' => ['modelId' => 'deleteRec','route' => route('admins.destroy',$user->id)]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.SideDeletePopUp'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['modelId' => 'deleteRec','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admins.destroy',$user->id))]); ?>
   <?php $__env->slot('title', null, []); ?> 
    تأكيد حذف الدور ؟
   <?php $__env->endSlot(); ?>
  سيتم حذف الدور المحدد وجميع الصلاحيات المرتبطة بة
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<!-- Striped rows end -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
<!-- Vendor js files -->
<script src="<?php echo e(asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/tables/datatable/buttons.bootstrap5.min.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<!-- Page js files -->
<!-- <script src="<?php echo e(asset(mix('js/scripts/pages/modal-add-role.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('js/scripts/pages/app-access-roles.js'))); ?>"></script> -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/rolesPermission/index.blade.php ENDPATH**/ ?>