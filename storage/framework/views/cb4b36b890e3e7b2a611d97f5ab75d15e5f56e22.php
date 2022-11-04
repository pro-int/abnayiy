

<?php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$student->id), 'name' => $student->student_name],['link' => route('students.contracts.index',[$student->id,$contract]), 'name' => 'تعاقد #'.$contract],['link' => route('students.contracts.transactions.index',[$student->id,$contract,$transaction->id]), 'name' => $transaction->installment_name]],['title'=> 'سجل الدفع #'. $transaction->id]];
?>

<?php $__env->startSection('title', 'سجل محاولات الدفع #'. $transaction->id); ?>

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
     <?php $__env->slot('title', null, []); ?> سجل محاولات الدفع - للدفعة رقم #<?php echo e($transaction->id); ?> - (<?php echo e($transaction->installment_name); ?>) <?php $__env->endSlot(); ?>
     <?php $__env->slot('cardbody', null, []); ?>  محاولات الدفع للعقد رقم #<?php echo e($contract . ' - اسم الطالب : ' . $student->student_name  .' - الدفعة : #' . $transaction->id . ' - '. $transaction->installment_name); ?>  <?php $__env->endSlot(); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-create')): ?>
     <?php $__env->slot('button', null, []); ?> 
        <a class="btn btn-primary mb-1" href="<?php echo e(route('students.contracts.transactions.attempts.create',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id])); ?>">
            <em data-feather='plus-circle'></em> اضافة دفعة جديدة </a>
     <?php $__env->endSlot(); ?>
    <?php endif; ?>

     <?php $__env->slot('thead', null, []); ?> 
        <tr>
            <th style="min-width: 180px;" scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">الفترة</th>
            <th scope="col">وسيلة الدفع</th>
            <th scope="col">مبلغ الدفعه</th>
            <th scope="col">خ.قسيمة</th>
            <th scope="col">خ.فترة</th>
            <th scope="col">المحصل</th>
            <th scope="col">حالة الدفع</th>
            <th scope="col">المرجع</th>
            <th scope="col">بواسطة</th>
            <th scope="col">اخر تحديث</th>
        </tr>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('tbody', null, []); ?> 
        <?php $__currentLoopData = $PaymentAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $PaymentAttempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <?php if($PaymentAttempt->getRawOriginal('approved') == 0): ?>
            <a class="btn btn-icon round btn-sm btn-outline-success" href="#" data-id="<?php echo e($PaymentAttempt->id); ?>" id="confirmTransaction-btn" onclick="handelModelIdConfirmTrans(this)" data-bs-toggle="tooltip" data-bs-placement="right" title="تأكيد الدفعة">
                <me data-feather="check-square"></me>
            </a>

            <a class="btn btn-icon round btn-sm btn-outline-warning" href="#" data-id="<?php echo e($PaymentAttempt->id); ?>" id="refuseTransaction-btn" onclick="handelModelId(this)" data-bs-toggle="tooltip" data-bs-placement="right" title="رفض الدفعة">
                <me data-feather="x-octagon"></me>
            </a>
            <?php elseif($PaymentAttempt->getRawOriginal('approved') == 1): ?>
            <a class="btn btn-icon round btn-sm btn-outline-warning" href="<?php echo e(route('students.contracts.transactions.attempts.show',['student' => request()->student,'contract' => request()->contract,'transaction' => $transaction->id,'attempt' => $PaymentAttempt->id])); ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="ايصال السداد">
                <me data-feather="image"></me>
            </a>
            
            <?php endif; ?>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-delete')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.delete','data' => ['route' => route('students.contracts.transactions.attempts.destroy', [$student->id,$contract,$PaymentAttempt->transaction_id,$PaymentAttempt->id])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.transactions.attempts.destroy', [$student->id,$contract,$PaymentAttempt->transaction_id,$PaymentAttempt->id]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>


        </td>

        <th scope="row">
            <?php echo e($PaymentAttempt->id); ?>

        </th>
        <td><?php echo e($PaymentAttempt->period_name); ?></td>
        <td><?php echo e($PaymentAttempt->method_name); ?> <?php echo $PaymentAttempt->bank_name ? sprintf('<abbr title="رقم الحساب : %s">(%s)</abbr>',$PaymentAttempt->account_number,$PaymentAttempt->bank_name) : ''; ?> <?php echo $PaymentAttempt->network_name ? sprintf('<abbr title="رقم الحساب : %s">(%s)</abbr>',$PaymentAttempt->network_account_number,$PaymentAttempt->network_name) : ''; ?></td>
        <td><?php echo e($PaymentAttempt->requested_ammount); ?></td>
        <td><?php echo e(null !== $PaymentAttempt->coupon ? sprintf('خصم %s - (%s)',$PaymentAttempt->coupon_discount,$PaymentAttempt->coupon) : ''); ?></td>
        <td><?php echo e($PaymentAttempt->period_discount); ?></td>
        <td><?php echo e($PaymentAttempt->received_ammount); ?></td>
        <td><?php echo e($PaymentAttempt->approved()); ?></td> 
        <td><?php if(in_array($PaymentAttempt->payment_method_id,[1,2,4]) && ! empty($PaymentAttempt->attach_pathh) && Storage::disk('public')->exists($PaymentAttempt->attach_pathh)): ?>
            <a class="btn btn-sm btn-info" href="<?php echo e(Storage::url($PaymentAttempt->attach_pathh)); ?>" target="_blank"><em  data-feather="share"></em></a>
            <?php else: ?> <?php echo e($PaymentAttempt->reference); ?> <?php endif; ?>
        </td>
        <td><?php echo e($PaymentAttempt->admin_name); ?></td>
        <td><abbr title="تاريخ التسجيل : <?php echo e($PaymentAttempt->created_at->format('Y-m-d h:m:s')); ?>"><?php echo e($PaymentAttempt->updated_at->diffforhumans()); ?></abbr></td>
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

<div class="modal fade add_back" id="confirmTransactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="res">

            <div class="modal-header">
                <h5 class="modal-title" id="confirmTransactionModal">تأكيد الدفعه</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" role="form" method="POST" name="transactionsconfirm" action="<?php echo e(route('paymentattempt.confirm')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <input type="hidden" name="paymentAttempt_id" id="id">


                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'المبلغ المدفوع','icon' => 'dollar-sign','name' => 'received_ammount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','step' => '.01']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <label for="attach_pathh" class="form-label mb-1" for="attach_pathh">صوره الايصال </label>
                            <input type="file" class="form-control" id="attach_pathh" name="receipt" accept="image/png, image/jpeg ,application/pdf">
                        </div>
                    </div>


                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <label class="form-label mb-1" for="notifyuser"> ارسال اشعار </label>
                            <?php if (isset($component)) { $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Checkbox::class, ['name' => 'notifyuser'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Checkbox::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>اعلام ولي الامر بأستلام الدفعة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543)): ?>
<?php $component = $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543; ?>
<?php unset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543); ?>
<?php endif; ?>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        عوده
                    </button>
                    <button type="submit" class="btn btn-success">تأكيد قبول الدفعة</button>

                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade add_back" id="refuseTransactionModal" tabindex="-1" aria-labelledby="refusetransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="res">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmTransactionModal">تأكيد الدفعه</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form role="form" method="POST" name="transactionsrefuse" action="<?php echo e(route('paymentattempt.refuse')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>

                    <input type="hidden" name="paymentAttempt_id" id="id">


                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'سبب الرفض','icon' => 'type','name' => 'reason'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-1 justify-content-center">
                        <div class="col-md">
                            <label class="form-label mb-1" for="notifyuser2"> ارسال اشعار </label>
                            <?php if (isset($component)) { $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Checkbox::class, ['name' => 'notifyuser'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Checkbox::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'notifyuser2']); ?>اعلام ولي الامر برفض الدفعة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543)): ?>
<?php $component = $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543; ?>
<?php unset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543); ?>
<?php endif; ?>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        عوده
                    </button>
                    <button type="submit" class="btn btn-danger">تأكيد رفض الدفعة</button>
                </div>

            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/student//contract/transaction/attempt/index.blade.php ENDPATH**/ ?>