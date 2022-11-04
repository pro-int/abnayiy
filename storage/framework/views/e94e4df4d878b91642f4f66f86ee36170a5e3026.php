
<?php
$breadcrumbs = [[['link' => route('schools.index'), 'name' => "البنوك"]],['title'=> 'مشاهدة معلومات المدرسة']];
?>

<?php $__env->startSection('title', 'مشاهدة معلومات المدرسة'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('vendor-style'); ?>
<!-- vendor css files -->
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/pickers/pickadate/pickadate.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-style'); ?>
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/pickers/form-pickadate.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startComponent('components.forms.formCard',['title' => sprintf('مشاهدة معلومات المدرسة %s', $school->school_name)]); ?>

<?php echo Form::model($school,['route' => ['schools.update',$school],'method'=>'PUT' , 'onsubmit' => 'showLoader()']); ?>


<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.divider','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.divider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>معلومات المدرسة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <div class="row mb-1">
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'المجمع الدراسي','name' => 'corporate_id','options' => corporates()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-placeholder' => 'اختر المجمع الدراسي']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>

        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['icon' => 'home','label' => 'اسم المدرسة','name' => 'school_name'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'ادخل اسم المدرسة','data-msg' => '\'اسم المدرسة بشكل صحيح']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <label class="form-label mr-1" for="active"> الحالة </label>
            <?php if (isset($component)) { $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Checkbox::class, ['name' => 'active'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Checkbox::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>مفعل <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543)): ?>
<?php $component = $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543; ?>
<?php unset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543); ?>
<?php endif; ?>
        </div>
    </div>

    <div class="col-12 text-center mt-2">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.link','data' => ['route' => 'schools.index']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'schools.index']); ?>عودة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>
    <?php echo Form::close(); ?>


    <?php echo $__env->renderComponent(); ?>

    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('vendor-script'); ?>
    <!-- vendor files -->
    <script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/picker.js'))); ?>"></script>
    <script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/picker.date.js'))); ?>"></script>
    <script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/picker.time.js'))); ?>"></script>
    <script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/legacy.js'))); ?>"></script>
    <script src="<?php echo e(asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js'))); ?>"></script>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('page-script'); ?>
    <!-- Page js files -->
    <script src="<?php echo e(asset(mix('js/scripts/forms/pickers/form-pickers.js'))); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/Corporate/School/show.blade.php ENDPATH**/ ?>