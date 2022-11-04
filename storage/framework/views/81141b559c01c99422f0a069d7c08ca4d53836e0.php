

<?php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$student), 'name' => $student->student_name],['link' => route('students.contracts.index',$student), 'name' => "تعاقدات الطالب"]],['title'=> 'ادارة تعاقدات الطالب']];
?>

<?php $__env->startSection('title', 'ادارة تعاقدات الطالب'); ?>


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
     <?php $__env->slot('title', null, []); ?> تعاقدات الطالب :  <?php echo e($student->student_name); ?> <?php $__env->endSlot(); ?>
     <?php $__env->slot('cardbody', null, []); ?>  قائمة بجميع تعاقدات الطالب بالمدرسة خلال السنوات الدراسية السابقة  <?php $__env->endSlot(); ?>

     <?php $__env->slot('thead', null, []); ?> 
        <tr>
            <th scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">السنة الدراسية</th>
            <th scope="col">الفصول المسجلة</th>
            <th scope="col">الصف الدراسي</th>
            <th scope="col">النتيجة</th>
            <th scope="col">خطة الدفع</th>
            <th scope="col">الرسوم الداراسية</th>
            <th scope="col">خصم فترة</th>
            <th scope="col">كوبون</th>
            <th scope="col">النقل</th>
            <th scope="col">الضرائب</th>
            <th scope="col">مديونيات</th>
            <th scope="col">الأجمالي</th>
            <th scope="col">مسدد</th>
            <th scope="col">متبقي</th>
            <th scope="col">خدمة النقل</th>
            <th scope="col">الدفع</th>
            <th scope="col">حالة التعاقد</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تحديث</th>
        </tr>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('tbody', null, []); ?> 
        <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.view','data' => ['route' => route('students.contracts.show', [$student->id,$contract->id])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.show', [$student->id,$contract->id]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-delete')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.delete','data' => ['route' => route('students.contracts.destroy', [$student->id,$contract])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.destroy', [$student->id,$contract]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transportations-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.generic','data' => ['colorClass' => 'danger btn-icon round','icon' => 'home','route' => route('students.contracts.transportations.index', [$contract->student_id,$contract->id]),'title' => 'خدمة النقل']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colorClass' => 'danger btn-icon round','icon' => 'home','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.transportations.index', [$contract->student_id,$contract->id])),'title' => 'خدمة النقل']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.generic','data' => ['colorClass' => 'primary btn-icon round','icon' => 'dollar-sign','route' => route('students.contracts.transactions.index', [$student->id,$contract->id]),'title' => 'الدفعات']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colorClass' => 'primary btn-icon round','icon' => 'dollar-sign','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.transactions.index', [$student->id,$contract->id])),'title' => 'الدفعات']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.generic','data' => ['colorClass' => 'info btn-icon round','icon' => 'file','route' => route('students.contracts.files.index', [$student->id,$contract->id]),'title' => 'ملفات التعاقد']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colorClass' => 'info btn-icon round','icon' => 'file','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.files.index', [$student->id,$contract->id])),'title' => 'ملفات التعاقد']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>

        </td>

        <th scope="row">
            <?php echo e($contract->id); ?>

        </th>
        <td><?php echo e($contract->year_name); ?></td>
        <td><?php echo e(count($contract->applied_semesters)); ?></td>
        <td><?php echo e($contract->level_name); ?></td>
        <td><?php echo $contract->getExamResult(); ?></td>
        <td><?php echo e($contract->plan_name); ?> (<?php echo e($contract->transactions->count()); ?> دفعة)</td>
        <td><?php echo e($contract->tuition_fees); ?></td>
        <td><?php echo e($contract->period_discounts); ?></td>
        <td><?php echo e($contract->coupon_discounts); ?></td>
        <td><?php echo e($contract->bus_fees); ?></td>
        <td><?php echo e($contract->vat_amount); ?> (<?php echo e($contract->vat_rate); ?>%)</td>
        <td><?php echo e($contract->debt); ?></td>
        <td><?php echo e($contract->total_fees); ?></td>
        <td><?php echo e($contract->total_paid); ?></td>
        <td><?php echo e(round($contract->total_fees - $contract->total_paid,2)); ?></td>
        <td><?php if(count($contract->transportation)): ?> مشترك <?php else: ?> غير مشترك <?php endif; ?></td>
        <td><?php echo ($contract->GetContractSpan()); ?></td>
        <td><?php echo $contract->getStatus(); ?></td>
        <td><?php echo e($contract->admin_name); ?></td>
        <td><abbr title="تاريخ التسجيل : <?php echo e($contract->created_at->format('Y-m-d h:m:s')); ?>"><?php echo e($contract->updated_at->diffforhumans()); ?></abbr></td>

        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
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

<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/student/contract/index.blade.php ENDPATH**/ ?>