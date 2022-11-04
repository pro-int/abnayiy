<div class="offcanvas-header">
    <h5 id="AssignAdminModalLabel" class="offcanvas-title">نتيجة مقابلة الطلب رقم : # <?php echo e($meeting->application_id); ?></h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body my-auto mx-0 flex-grow-0">
    <div class="text-center mb-2 text-danger">
        <me data-feather="headphones" class="font-large-3"></me>
    </div>
    <h3 class="text-center text-dark" id="slot">
        نتيجة المقابلة
    </h3>
    <?php echo Form::model($meeting,['route' => 'applications.meeting_result','method'=>'PUT' , 'onsubmit' => 'showLoader()']); ?>


    <input type="hidden" name="appointment_id" value="<?php echo e($meeting->id); ?>">
    <input type="hidden" name="application_id" value="<?php echo e($meeting->application_id); ?>">

    <div class="col-lg mb-1">
        <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'ملخص الاجتماع','icon' => 'file-text','name' => 'summary'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'ادخل ملخص الاجتماع','data-msg' => 'ادخل ملخص الاجتماع بشكل صحيح']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
    </div>

    <div class="col-lg mb-1">
        <label class="form-label">حضر الي المقابلة </label>
        <div class="col-md  mb-1">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.radio','data' => ['id' => 'attended','value' => '1','name' => 'attended']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attended','value' => '1','name' => 'attended']); ?> نعم <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.radio','data' => ['id' => 'attended2','value' => '0','name' => 'attended']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attended2','value' => '0','name' => 'attended']); ?> لم يحضر <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
    </div>

    <div class="col-lg mb-1">
        <label class="form-label">نتيجة المقابلة </label>
        <div class="col-md  mb-1">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.radio','data' => ['id' => 'approved','value' => '1','name' => 'approved']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'approved','value' => '1','name' => 'approved']); ?> طالب مقبول <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.radio','data' => ['id' => 'approved2','value' => '0','name' => 'approved']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'approved2','value' => '0','name' => 'approved']); ?> طالب مرفوض <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
    </div>


    <button type="submit" class="btn btn-success  mb-1 d-grid w-100">حفظ النتيجة</button>
    <?php echo Form::close(); ?>

    <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
        تراجع
    </button>
</div><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/application/meetingResult.blade.php ENDPATH**/ ?>