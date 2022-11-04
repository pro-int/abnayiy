

<?php
$breadcrumbs = [[['link' => route('transfers.index'), 'name' => "طلبات تجديد التعاقد"],['name'=> 'طلبات تجديد التعاقد']],['title'=> 'ادارة طلبات تجديد التعاقد']];
?>

<?php $__env->startSection('title', 'طلبات تجديد التعاقد'); ?>

<?php $__env->startSection('vendor-style'); ?>
<!-- vendor css files -->
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/pickers/pickadate/pickadate.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-style'); ?>
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/pickers/form-pickadate.css'))); ?>">

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.forms.search','data' => ['route' => 'transfers.index']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'transfers.index']); ?>
    <div class="row mb-1">
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['icon' => 'search','label' => 'اليحث','name' => 'search'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'placeholder' => 'يمكنك البحث عن اسم او رقم جوال او هوية ويمكن البحث بالكود عن طريق اضافة = قبل لكمة البحث']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'السنة الدراسية','name' => 'academic_year_id','options' => ['' => 'جميع السنوات'] + App\Models\AcademicYear::years()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-placeholder' => 'السنة الدراسية']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'طريقة السداد','name' => 'payment_method_id','options' => ['' => 'جميع طرق الدفع'] + paymentMethods(1)] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-placeholder' => 'اختر طريقة السداد']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'حالة الطلب','name' => 'status_id','options' => ['' => 'جميع الطبات' ,'new' => 'طلب جديد' ,'pending' => 'بأنتظار التأكيد' ,'complete' => 'مدفوع' ,'NoPayment' => 'فشل الدفع' ,'expired' =>  'منتهي الصلاحية']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-placeholder' => 'اختر حالة الطلب']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['icon' => 'calendar','label' => 'تاريخ من :','name' => 'date_from'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flatpickr-basic','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'placeholder' => 'yyyy-mm-dd']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['icon' => 'calendar','label' => 'تاريخ الي :','name' => 'date_to'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flatpickr-basic','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'placeholder' => 'yyyy-mm-dd']); ?>
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
            <label class="form-label">خدمة النقل </label>
            <?php if (isset($component)) { $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Checkbox::class, ['name' => 'transportation'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Checkbox::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>يرغب في خدمة النقل <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543)): ?>
<?php $component = $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543; ?>
<?php unset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543); ?>
<?php endif; ?>
        </div>
    </div>
     <?php $__env->slot('export', null, []); ?> 
        <div class="btn-group">
            <button class="btn btn-outline-secondary waves-effect" name="action" type="submit" value="export_xlsx"><em data-feather='save'></em> اكسل</button>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button class="dropdown-item" name="action" type="submit" value="export_pdf"><em data-feather='save'></em> PDF</button>
            </div>
        </div>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

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
     <?php $__env->slot('title', null, []); ?> طلبات تجديد التعاقد واعادة القيد للعام الدراسي <span class="text-danger">(<?php echo e(request()->filled('academic_year_id') ? 'المحدد ' : 'المتاح للتقديم '); ?> <?php echo e($year->year_name); ?>)</span> <?php $__env->endSlot(); ?>
     <?php $__env->slot('cardbody', null, []); ?> <?php echo sprintf('قائمة طلبات تجديد التعاقد و اعادة القيد المفدمة من اولياء الأمور .. معروض الطلبات من <span class="text-danger">%s</span> الي <span class="text-danger">%s</span> طلب من اجمالي <span class="text-danger">%s</span> طلب تجديد', $transfers->firstItem() ,$transfers->lastItem(), $transfers->total()); ?> <?php $__env->endSlot(); ?>

     <?php $__env->slot('thead', null, []); ?> 
        <tr>
            <th scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">اسم الطالب</th>
            <th scope="col">العام</th>
            <th scope="col">الصف</th>
            <th scope="col">ينتقل الي</th>
            <th scope="col">خطة السداد</th>
            <th scope="col">النقل</th>
            <th scope="col">طريقة الدفع</th>
            <th scope="col">الخصم ينتهي في</th>
            <th scope="col">حالة الطلب</th>
            <th scope="col">تاريخ الطلب</th>
            <th scope="col">اخر تعديل</th>
        </tr>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('tbody', null, []); ?> 
        <?php $__currentLoopData = $transfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfers-list')): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.view','data' => ['route' => route('transfers.show',$transfer->id)]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('transfers.show',$transfer->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfers-edit')): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.edit','data' => ['route' => route('transfers.edit',$transfer->id)]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('transfers.edit',$transfer->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfers-delete')): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.delete','data' => ['route' => route('transfers.destroy', $transfer->id)]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('transfers.destroy', $transfer->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>

            </td>
            <th><?php echo e($transfer->id); ?></th>
            <td><a href="<?php echo e(route('students.contracts.index',$transfer->student_id)); ?>"><?php echo e($transfer->student_name); ?></a></td>
            <td><?php echo e($transfer->year_name); ?></td>
            <td><?php echo e($transfer->level_name); ?></td>
            <td><?php echo e($transfer->new_level_name); ?></td>
            <td><?php echo e($transfer->plan_name); ?></td>
            <td><?php echo e($transfer->transportation_id ? 'مشترك' : 'لا يرغب'); ?></td>
            <td><?php echo e($transfer->method_name); ?> <?php if($transfer->bank_name): ?>(<?php echo e($transfer->bank_name); ?>) <?php endif; ?></td>
            <td><?php echo e($transfer->due_date); ?></td>
            <td><?php echo $transfer->getStatus(); ?></td>
            <td><abbr title="<?php echo e($transfer->created_at); ?>"><?php echo e($transfer->created_at->format('d-m-Y')); ?></abbr></td>
            <td><abbr title="<?php echo e($transfer->updated_at); ?>"><?php echo e($transfer->updated_at->format('d-m-Y')); ?></abbr></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('pagination', null, []); ?> 
        <?php echo e($transfers->appends(request()->except('page'))->links()); ?>

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
<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/TransferRequest/index.blade.php ENDPATH**/ ?>