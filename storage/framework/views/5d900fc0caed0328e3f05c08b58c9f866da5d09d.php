

<?php
$breadcrumbs = [[['link' => route('years.index'), 'name' => "السنوات الدراسية"],['link' => route('years.show',$year), 'name' => "$year->year_name"],['link' => route('years.periods.show',[$year,$period]), 'name' => $period->period_name ],['link' => route('years.periods.discounts.index',[$year,$period]), 'name' => "خصومات : $period->period_name"]],['title'=> 'ادارة خصومات '. $period->period_name]];
?>

<?php $__env->startSection('title', sprintf('اعدادات الخصومات للفترة %s - العام الدراسي %s ',$period->period_name,$year->year_name)); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.forms.formCard',['title' => sprintf('اعدادات الخصومات للفترة %s - العام الدراسي %s ',$period->period_name,$year->year_name)]); ?>

<p class="card-text"><?php echo e(sprintf('خصومات الفترة : %s - من : %s الي %s ',$period->period_name ,$period->apply_start->format('d-m-Y'),$period->apply_end->format('d-m-Y'))); ?></p>

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.divider','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.divider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>اختر المسار للبدء في اعداد الخصومات <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
     <?php $__env->slot('button', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.link','data' => ['route' => 'years.periods.discounts.index','params' => [$year,$period]]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'years.periods.discounts.index','params' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([$year,$period])]); ?>عودة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

     <?php $__env->endSlot(); ?>
    <input type="hidden" name="csrf-token" id="csrf-token" value="<?php echo e(csrf_token()); ?>">
    <input type="hidden" name="period_id" id="period_id" value="<?php echo e($period->id); ?>">
    <div class="row mb-1">
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'المدرسة','name' => 'school_id','options' => schools()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['select2' => '','onLoad' => 'change','data-placeholder' => 'اختر المدرسة','data-msg' => 'رجاء اختيار المدرسة']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>

        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'النوع','name' => 'gender_id'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-placeholder' => 'اختر النوع','data-msg' => 'رجاء اختيار النوع']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>

        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'المرحلة','name' => 'grade_id'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-placeholder' => 'اختر المرحلة','data-msg' => 'رجاء اختيار المرحلة']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>

    </div>

    <div class="row mb-1" id="resp_dev">

    </div>
    <div class="col-12 text-center mt-2">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.link','data' => ['route' => 'years.periods.discounts.index','params' => [$year,$period]]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'years.periods.discounts.index','params' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([$year,$period])]); ?>عودة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>

    <?php echo $__env->renderComponent(); ?>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/AcademicYears/period/discount/create.blade.php ENDPATH**/ ?>