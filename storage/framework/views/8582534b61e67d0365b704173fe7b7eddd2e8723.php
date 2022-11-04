

<?php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$contract->student_id), 'name' => $contract->student_name],['link' => route('students.contracts.index',$contract->student_id), 'name' => 'التعاقدات'],['link' => route('students.contracts.index',[$contract->student_id,$contract->id]), 'name' => 'تعاقد '.$contract->year_name]],['title'=> 'دفعات التعاقد رقم #'. $contract->id]];
?>

<?php $__env->startSection('title', 'دفعات التعاقد رقم #'. $contract->id); ?>


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
     <?php $__env->slot('title', null, []); ?> تفاصيل دفعات العقد رقم #<?php echo e($contract->id); ?> - <?php echo $contract->getStatus(); ?> <?php $__env->endSlot(); ?>
     <?php $__env->slot('cardbody', null, []); ?>  <?php echo e('اسم الطالب : ' . $contract->student_name  .' - السنة الدراسية ' . $contract->year_name); ?>  <?php $__env->endSlot(); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transportations-list')): ?>
     <?php $__env->slot('button', null, []); ?> 
        <a class="btn btn-outline-danger mb-1" href="<?php echo e(route('students.contracts.transportations.index', [$contract->student_id,$contract->id])); ?>">
            <em data-feather='home'></em> ادارة خدمة النقل </a>
         <?php $__env->endSlot(); ?>
        <?php endif; ?>

     <?php $__env->slot('thead', null, []); ?> 
        <tr>
            <th style="min-width: 180px;" scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">الدفعة</th>
            <th scope="col">الاساسي</th>
            <th scope="col">الضرائب</th>
            <th scope="col">خ.فترة</th>
            <th scope="col">خ.قسيمة</th>
            <th scope="col">الأجمالي</th>
            <th scope="col">المدفوع</th>
            <th scope="col">المتبقي</th>
            <th scope="col">تاريخ الدفع</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تحديث</th>
        </tr>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('tbody', null, []); ?> 
        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.view','data' => ['route' => route('students.contracts.transactions.attempts.index',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.transactions.attempts.index',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if(!$transaction->payment_status): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.generic','data' => ['icon' => 'plus','route' => route('students.contracts.transactions.attempts.create',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id]),'title' => 'اضافة دفعة جديدة']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'plus','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.transactions.attempts.create',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id])),'title' => 'اضافة دفعة جديدة']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>


        </td>

        <th scope="row">
            <?php echo e($transaction->id); ?>

        </th>
        <td><?php echo e($transaction->installment_name); ?></td>
        <td><?php echo e(round($transaction->amount_before_discount, 2)); ?></td>
        <td><?php echo e(round($transaction->vat_amount,2)); ?></td>
        <td><?php echo e(round($transaction->period_discount,2)); ?></td>
        <td><?php echo e(round($transaction->coupon_discount,2)); ?></td>
        <td><?php echo e(round($transaction->amount_after_discount + $transaction->vat_amount, 2)); ?></td>
        <td><?php echo e(round($transaction->paid_amount, 2)); ?></td>
        <td><?php echo e(round($transaction->residual_amount, 2)); ?></td>
        <td><?php echo e($transaction->payment_status && $transaction->payment_date ? 'تم الدفع' . $transaction->payment_date : 'يجب الدفع قبل' . $transaction->payment_due); ?></td>
        <td><?php echo e($transaction->admin_name); ?></td>

        <td><abbr title="تاريخ التسجيل : <?php echo e($transaction->created_at->format('Y-m-d h:m:s')); ?>"><?php echo e($transaction->updated_at->diffforhumans()); ?></abbr></td>


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
<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/student/contract/transaction/index.blade.php ENDPATH**/ ?>