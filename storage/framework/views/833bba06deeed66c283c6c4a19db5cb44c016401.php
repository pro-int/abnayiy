

<?php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$contract->student_id), 'name' => $contract->student_name],['link' => route('students.contracts.index',$contract->student_id), 'name' => "تعاقدات الطالب"],['link' => route('students.contracts.files.index',[$contract->student_id,$contract->id]), 'name' => "مرفقات التعاقد"]],['title'=> 'ادارة مرفقات التعاقد']];
?>

<?php $__env->startSection('title', 'ادارة مرفقات تعاقدات الطالب'); ?>


<?php $__env->startSection('content'); ?>

<!-- Striped rows start -->
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.table','data' => ['autoWith' => false]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autoWith' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
     <?php $__env->slot('title', null, []); ?> <?php echo sprintf('مرفقات العقد رقم : <span class="text-danger">(%s)</span> - الطالب <span class="text-danger">(%s)</span> - العام الدراسي <span class="text-danger">(%s)</span>', $contract->id,$contract->student_name, $contract->year_name); ?> <?php $__env->endSlot(); ?>
     <?php $__env->slot('cardbody', null, []); ?>  قائمة بجميع مرفقات التعاقد   <?php $__env->endSlot(); ?>
     <?php $__env->slot('button', null, []); ?> 
        <a class="btn btn-primary mb-1" href="<?php echo e(route('students.contracts.files.create',[$contract->student_id,$contract->id])); ?>">
            <em data-feather='plus-circle'></em> اضافة  ملف جديد </a>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('thead', null, []); ?> 
        <tr>
            
            <th scope="col">#</th>
            <th scope="col">نوع المرفق</th>
            <th scope="col">رابط الملف</th>
            <th scope="col">بواسطة</th>
            <th scope="col">تاريخ التحميل</th>
            <th scope="col">اخر تحديث</th>
            <th scope="col">الاجراءات</th>
        </tr>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('tbody', null, []); ?> 
        <?php $__currentLoopData = $contract->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <th scope="row">
            <?php echo e($file->id); ?>

        </th>
        <td><?php echo $file->fileType(); ?></td>
        <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.generic','data' => ['colorClass' => 'success','icon' => 'download','route' => Storage::disk('public')->url($file->file_path)]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colorClass' => 'success','icon' => 'download','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Storage::disk('public')->url($file->file_path))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
        <td><?php echo e($file->admin_name); ?></td>
        <td><abbr title="<?php echo e($file->updated_at->format('Y-m-d h:m:s')); ?>"><?php echo e($file->updated_at->diffforhumans()); ?></abbr></td>
        <td><abbr title="<?php echo e($file->created_at->format('Y-m-d h:m:s')); ?>"><?php echo e($file->created_at->diffforhumans()); ?></abbr></td>

        <td>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.delete','data' => ['route' => route('students.contracts.files.destroy', [$contract->student_id,$contract->id,$file->id])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.files.destroy', [$contract->student_id,$contract->id,$file->id]))]); ?>
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

<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/student/contract/file/index.blade.php ENDPATH**/ ?>