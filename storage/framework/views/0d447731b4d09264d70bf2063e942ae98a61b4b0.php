


<?php
$breadcrumbs = [[['link' => route('students.index'), 'name' => 'الطلاب'],['link' => route('students.show',$student), 'name' => "طالب #$student"],['link' => route('students.contracts.index',[$student,$transaction->contract_id]), 'name' => 'تعاقد #'.$transaction->contract_id],['link' => route('students.contracts.transactions.show',[$student,$transaction->contract_id,$transaction->id]), 'name' => "دفعة #$transaction->id"]],['title'=> 'اضافة دفعة جديدة']];
?>


<?php $__env->startSection('title', "اضافة سجل جديد للعقد رقم #$transaction->contract_id - دفعة #$transaction->id"); ?>

<?php $__env->startSection('vendor-style'); ?>
<!-- vendor css files -->
<link rel='stylesheet' href="<?php echo e(asset(mix('vendors/css/forms/wizard/bs-stepper.min.css'))); ?>">
<link rel='stylesheet' href="<?php echo e(asset(mix('vendors/css/forms/select/select2.min.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-style'); ?>
<!-- Page css files -->
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/form-wizard.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/form-validation.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/pages/modal-create-app.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.forms.formCard',['title' => sprintf('تسجيل دفعة %s #%s - متبقي %s',$transaction->installment_name,$transaction->id,$transaction->residual_amount)]); ?>

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.divider','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.divider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>معلومات الدفعة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <div class="row mb-1 ">
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'قيمة الدفعة','icon' => 'file-text','name' => 'amount_before_discount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction->amount_before_discount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>

        <?php if($transaction->vat_amount): ?>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'قيمة الضرائب','icon' => 'file-text','name' => 'vat_amount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction->vat_amount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>
        <?php endif; ?>


        <?php if($transaction->period_discount): ?>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'خصومات الفترة','icon' => 'file-text','name' => 'period_discount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction->period_discount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if($transaction->coupon_discount): ?>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'خصومات الفسيمة','icon' => 'file-text','name' => 'coupon_discount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction->coupon_discount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if($transaction->amount_before_discount != $transaction->amount_after_discount ): ?>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'بعد الخصم','icon' => 'file-text','name' => 'amount_after_discount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction->amount_after_discount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'الاجمالي','icon' => 'file-text','name' => 'total'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction->amount_after_discount + $transaction->vat_amount),'disabled' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>

        <?php if($transaction->paid_amount): ?>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'مدفوع','icon' => 'file-text','name' => 'paid_amount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction->paid_amount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>

        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'متبقي','icon' => 'file-text','name' => 'total'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction->residual_amount > 0 ? $transaction->residual_amount : 'مدفوع')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>
        <?php endif; ?>

    </div>


    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ui.divider','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.divider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>تفاصيل الدفعة الجديدة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <?php if($transaction->residual_amount > 0): ?>
        <?php if($transaction_info['new_period_discount']): ?>
        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'خصم الفترة الحالية','icon' => 'dollar-sign','name' => 'new_period_discount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction_info['new_period_discount']),'class' => 'is-valid','divClass' => 'is-valid','readonly' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if($transaction_info['coupon_code'] && $transaction_info['coupon_discount']): ?>
        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'خصم قسيمة ('.e($transaction_info['coupon_code']).')','icon' => 'dollar-sign','name' => 'coupon_discount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction_info['coupon_discount']),'class' => 'is-valid','divClass' => 'is-valid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
            </div>
        </div>
        <?php endif; ?>


        <?php echo Form::open(['route' => ['students.contracts.transactions.attempts.store',['student' => $student,'contract' => $contract,'transaction' => $transaction]],'method'=>'POST','enctype'=>"multipart/form-data" ,'onsubmit' => 'showLoader()']); ?>


        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'المطلوب سداداة','icon' => 'file-text','name' => 'residual_amount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaction_info['residual_amount'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
            </div>
        </div>

        <?php if(!request()->has('coupon_code') || empty(request()->coupon_code)): ?>
        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <button type="button" class="btn btn-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#refuseCoupon">
                    اضافة قسيمة
                </button>
            </div>
        </div>

        <?php else: ?>

        <div class="row mb-1 justify-content-center mt-1">
            <div class="col-md-6">
                <?php echo Form::label('coupon_code','القسيمة'); ?>

                <?php echo Form::label('coupon_code',request()->coupon_code,['class' => 'form-control '. ($transaction_info['is_coupon_valid'] ? 'is-valid' : 'is-invalid')]); ?>

                <?php if(!$transaction_info['is_coupon_valid']): ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($transaction_info['message'] ?? 'قسيمة غير صالحة'); ?></strong>
                </span>
                <?php else: ?>
                <span class="valid-feedback">
                    <?php echo e($transaction_info['message'] ??  'تم تطبيق القسيمة'); ?>

                </span>
                <input type="hidden" name="coupon" value="<?php echo e(request()->coupon_code); ?>">
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-1 justify-content-center mt-1">
            <div class="col-md-6">
                <a href="<?php echo e(url()->current()); ?>" class="btn btn-sm btn-danger">ازالة القسيمة <em data-feather="trash"></em></a>
            </div>
        </div>

        <?php endif; ?>


        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'المبلغ المدفوع','icon' => 'file-text','name' => 'requested_ammount'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('requested_ammount')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(sprintf('فيمة الدفعة بحد اقصي %s ', $transaction_info['residual_amount']))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
                <small id="hint" class="form-text text-danger">اترك هذا الحقل فارغ لدفع كامل المبلغ</small>
                <input type="hidden" name="max_amount" value="<?php echo e($transaction->residual_amount - $transaction_info['coupon_discount'] - $transaction_info['new_period_discount']); ?>">
            </div>
        </div>

        <div class="row mb-1 justify-content-center">

            <div class="col-md-6">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['name' => 'method_id','label' => 'طريقة الدفع','options' => App\Models\PaymentMethod::paymentMethods(1,[1,2,4])] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['select2' => '','onchange' => 'checkPaymentMethod()']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>
        </div>

        <div class="row mb-1 justify-content-center">
            <div class="col-md-3">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['name' => 'bank_id','label' => 'البنك','options' => ['' => 'اختر البنك'] + GetBanks()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['select2' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>
            <div class="col-md-3">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['name' => 'payment_network_id','label' => 'الشبكة','options' => ['' => 'اختر الشبكة'] + GetNetworks()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['select2' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>
        </div>

        <div class="row mb-1 justify-content-center">
            <div class="col-md-3">
                <label class="form-label mb-1" for="is_confirmed"> دفعة مؤكدة </label>
                <?php if (isset($component)) { $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Checkbox::class, ['name' => 'is_confirmed'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Checkbox::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>خصم الدفعة مباشرة من حساب الطالب <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543)): ?>
<?php $component = $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543; ?>
<?php unset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543); ?>
<?php endif; ?>
            </div>

            <div class="col-md-3">
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

        <div class="row mb-1 justify-content-center">
            <div class="col-md-6">
                <label for="receipt" class="form-label mb-1" for="receipt">صوره الايصال </label>
                <input required type="file" class="form-control" id="receipt" name="receipt" accept="image/png, image/jpeg ,application/pdf">
            </div>
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
<?php $component->withAttributes([]); ?>تسجيل الدفعة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a)): ?>
<?php $component = $__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a; ?>
<?php unset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.link','data' => ['route' => 'students.contracts.index','params' => [$student,$contract]]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'students.contracts.index','params' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([$student,$contract])]); ?>عودة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>

        <?php echo Form::close(); ?>

        <?php endif; ?>
        <?php echo $__env->renderComponent(); ?>


        <div class="modal fade add_back" id="refuseCoupon" tabindex="-1" aria-labelledby="AddCouponLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="res">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddCoupon">اضافة قسيمة خصم</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form role="form" method="GET" name="transactionsrefuse" action="<?php echo e(url()->current()); ?>">
                        <div class="modal-body">
                            <div class="col-md">
                                <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'قسيمة الخصم','icon' => 'file-text','name' => 'coupon_code'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                عوده
                            </button>
                            <?php if (isset($component)) { $__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Submit::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Submit::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'btn btn-warning  me-1']); ?>تطبيق القسيمة <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a)): ?>
<?php $component = $__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a; ?>
<?php unset($__componentOriginal0d75fdd1ee12f34e798ece0533de749fd4d3d96a); ?>
<?php endif; ?>

                        </div>

                    </form>
                </div>
            </div>
        </div>
        <?php $__env->stopSection(); ?>

        <?php $__env->startSection('vendor-script'); ?>
        <!-- vendor files -->
        <script src="<?php echo e(asset(mix('vendors/js/forms/wizard/bs-stepper.min.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('vendors/js/forms/select/select2.full.min.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('vendors/js/forms/cleave/cleave.min.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))); ?>"></script>
        <?php $__env->stopSection(); ?>
        <?php $__env->startSection('page-script'); ?>
        <!-- Page js files -->
        <script src="<?php echo e(asset(mix('js/scripts/pages/modal-add-new-cc.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('js/scripts/pages/page-pricing.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('js/scripts/pages/modal-add-new-address.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('js/scripts/pages/modal-create-app.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('js/scripts/pages/modal-two-factor-auth.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('js/scripts/pages/modal-edit-user.js'))); ?>"></script>
        <script src="<?php echo e(asset(mix('js/scripts/pages/modal-share-project.js'))); ?>"></script>

        <script>
            function checkPaymentMethod() {
                let method_id = document.getElementById('method_id')
                let bank_id = document.getElementById('bank_id')
                let payment_network_id = document.getElementById('payment_network_id')
                bank_id.value = ''
                payment_network_id.value = ''
                method_id.value == 1 ? bank_id.removeAttribute('disabled') : bank_id.setAttribute('disabled', 1)
                method_id.value == 4 ? payment_network_id.removeAttribute('disabled') : payment_network_id.setAttribute('disabled', 1)
            }

            checkPaymentMethod()
        </script>
        <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/student/contract/transaction/attempt/create.blade.php ENDPATH**/ ?>