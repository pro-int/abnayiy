


<?php $__env->startSection('title', 'تعديل  دور'); ?>

<?php $__env->startSection('vendor-style'); ?>
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/forms/select/select2.min.css'))); ?>">
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/editors/quill/katex.min.css'))); ?>">
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/editors/quill/monokai-sublime.min.css'))); ?>">
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/editors/quill/quill.snow.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-style'); ?>

<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/form-validation.css'))); ?>">

<?php 
$breadcrumbs = [[['link' => route('roles.index'), 'name' => "الأدوار"], ['link' => route('roles.edit', $role->id), 'name' => "تعديل : $role->display_name"]],['title'=>'تعديل دور']];
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section id="multiple-column-form">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">تعديل  الدور :  <?php echo e($role->display_name); ?> <?php echo e(auth()->user()->id); ?></h4>
          
        </div>
        <div class="card-body">
        <!-- Add role form -->
        <?php echo e(Form::model($role,['route' => ['roles.update',$role->id],'method'=>'PUT','id' => 'addRoleForm', 'class' => 'row','onsubmit' => 'return false'])); ?>

        <div class="row">
          <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'اسم الدور  انجليزي','name' => 'name'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'ادخل اسم الدور انجليزي','data-msg' => 'رجاء ادخال اسم الدور انجليزي بشكل صحيح']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
          </div>

          <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'اسم الدور عربي','name' => 'display_name'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'ادخل اسم الدور عربي','data-msg' => 'رجاء ادخال اسم الدور عربي بشكل صحيح']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
          </div>

          <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal845082fdb39570549ef5a2e5f4148730a968b635 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Color::class, ['label' => 'اللون المميز','name' => 'color'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Color::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($role->color),'placeholder' => 'ادخل اللون','data-msg' => 'رجاء ادخال اللون المميز للدور']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal845082fdb39570549ef5a2e5f4148730a968b635)): ?>
<?php $component = $__componentOriginal845082fdb39570549ef5a2e5f4148730a968b635; ?>
<?php unset($__componentOriginal845082fdb39570549ef5a2e5f4148730a968b635); ?>
<?php endif; ?>
          </div>
        </div>
        <div class="col-12">
          <h4 class="mt-2 pt-50">صلاحيات الدور</h4>
          <!-- Permission table -->
          <div class="table-responsive">
            <table class="table table-flush-spacing">
              <tbody>
                <tr>
                  <td class="text-nowrap fw-bolder">
                    جميع الصلاحيات ؟
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="تحديد جميع الصلاحيات المتاحة بالنظام">
                      <em data-feather="info"></em></span>
                  </td>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="selectAll" />
                      <label class="form-check-label" for="selectAll"> تحديد الكل </label>
                    </div>
                  </td>
                </tr>
                <?php $__currentLoopData = $PermissionsCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td class="text-nowrap fw-bolder"><?php echo e($category->category_name); ?></td>
                  <td>
                    <div class="d-flex">
                      <?php $__currentLoopData = $category->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if (isset($component)) { $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Checkbox::class, ['name' => 'permission[]'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Checkbox::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-msg' => 'رجاء تحديد صلاحية واحدة علي الاقل','divClass' => 'form-check col-md','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($permission->id),'id' => 'permission'.e($permission->id).'','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(in_array($permission->id, $rolePermissions))]); ?>
                        <?php echo e($permission->display_name); ?>

                       <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543)): ?>
<?php $component = $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543; ?>
<?php unset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543); ?>
<?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>
          <!-- Permission table -->
        </div>
        <div class="col-12 text-center mt-2">
          <?php if (isset($component)) { $__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Submit::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Submit::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>تحديث <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a)): ?>
<?php $component = $__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a; ?>
<?php unset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a); ?>
<?php endif; ?>
          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.link','data' => ['route' => 'roles.index']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'roles.index']); ?>عودة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        </div>
        <?php echo Form::close(); ?>

        <!--/ Add role form -->
        </div>
      </div>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
<script src="<?php echo e(asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script src="<?php echo e(asset(mix('js/scripts/pages/modal-add-role.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/rolesPermission/edit.blade.php ENDPATH**/ ?>