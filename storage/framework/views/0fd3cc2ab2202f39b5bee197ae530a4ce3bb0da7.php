

<?php
$breadcrumbs = [[['link' => route('students.contracts.index',$student), 'name' => "الطالب : $student->student_name"], ['link' => route('students.contracts.transactions.index' ,[$student->id, $contract]), 'name' => "تعاقد #". $contract->year_name], ['link' => route('students.contracts.transportations.index' ,[$student->id, $contract]), 'name' => "ادارة خدمة النقل"]],['title' => 'تعديل خدمة النقل ']];
?>

<?php $__env->startSection('title', sprintf('ادارة خدمة النقل الطالب : %s', $student->student_name)); ?>

<?php $__env->startSection('content'); ?>

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
     <?php $__env->slot('title', null, []); ?> <?php echo sprintf('ادارة خدمة النقل الطالب : <span class="text-danger">%s - تعاقد رقم %s </span> <span> - للعام الدراسي %s</span> ', $student->student_name ,$contract->id,$contract->year_name); ?>  <?php $__env->endSlot(); ?>
     <?php $__env->slot('cardbody', null, []); ?> يمكنك من خلال هذة الصفحة ادارة خدمة النقل للطلاب خلال العام الدراسي <?php $__env->endSlot(); ?>
     <?php $__env->slot('button', null, []); ?> 
        <a class="btn btn-primary mb-1" href="<?php echo e(route('students.contracts.transportations.create',[$student->id,$contract])); ?>">
            <em data-feather='plus-circle'></em> اضافة حدمة نقل </a>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('thead', null, []); ?> 
        <tr>
            <th scope="col">كود</th>
            <th scope="col">الخطة</th>
            <th scope="col">الرسوم</th>
            <th scope="col">الضرائب</th>
            <th scope="col">الأجمالي</th>
            <th scope="col">طريقة الدفع</th>
            <th scope="col">تاريخ الانتهاء</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تحديث</th>
            <th scope="col">الاجراءات المتاحة</th>
        </tr>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('tbody', null, []); ?> 

        <?php $__currentLoopData = $transportations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transportation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <th><?php echo e($transportation->id); ?></th>
            <td><?php echo e($transportation->transportation_type); ?></td>
            <td><?php echo e($transportation->base_fees); ?></td>
            <td><?php echo e($transportation->vat_amount); ?></td>
            <td><?php echo e($transportation->total_fees); ?></td>
            <td><?php echo e(App\Models\Transportation::payment_plans($transportation->payment_type)); ?></td>
            <td><?php echo e(! is_null($transportation->expire_at) ? $transportation->expire_at->format('Y-n-d') : 'غير محدد'); ?></td>
            <td><?php echo e($transportation->admin_name); ?></td>
            <td><abbr title="تاريخ التسجيل : <?php echo e($transportation->created_at->format('Y-m-d h:m:s')); ?>"><?php echo e($transportation->updated_at->diffforhumans()); ?></abbr></td>

            <td>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transportations-list')): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.view','data' => ['route' => route('students.contracts.transportations.show',[$student->id,$contract,$transportation->id])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.transportations.show',[$student->id,$contract,$transportation->id]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transportations-edit')): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.edit','data' => ['route' => route('students.contracts.transportations.edit',[$student->id,$contract,$transportation->id])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.transportations.edit',[$student->id,$contract,$transportation->id]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transportations-delete')): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.delete','data' => ['route' => route('students.contracts.transportations.destroy',[$student->id,$contract,$transportation->id])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.transportations.destroy',[$student->id,$contract,$transportation->id]))]); ?>
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

<!-- Striped rows end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/student/transportation/index.blade.php ENDPATH**/ ?>