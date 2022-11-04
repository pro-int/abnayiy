

<?php
$breadcrumbs = [[['link' => route('students.index'), 'name' => "الطلاب"],['name'=> 'ادارة الطلاب' ]],['title'=> 'ادارة الطلاب']];
?>

<?php $__env->startSection('title', 'ادارة الطلاب'); ?>

<?php $__env->startSection('vendor-style'); ?>
<!-- Vendor css files -->
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-style'); ?>
<!-- Page css files -->
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css'))); ?>">
<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/form-validation.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.forms.search','data' => ['route' => 'students.index']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'students.index']); ?>
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
    </div>

    <div class="row mb-1">
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'حالة المزامنة','name' => 'noor_status','options' => ['' => 'جميع الطلاب' , '0' => 'لام تتم المزامنة' , '1' =>'تم المزامنة']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>
        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'جنسية الطالب','name' => 'nationality_id','options' => ['' => 'جميع الجنسيات'] + App\Models\nationality::nationalities()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-placeholder' => 'اختر جنسية الطالب']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>

        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'فئة ولي الأمر','name' => 'category_id','options' => ['' => 'جميع الفئات'] + App\Models\Category::categories()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-placeholder' => 'اختر لبفئة']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>

        <div class="col-md">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'الطلاب بالسنة الدراسية','name' => 'academic_year_id','options' => ['' => 'جميع الطلاب'] + App\Models\AcademicYear::years()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-placeholder' => 'الطلاب بالسنة الدراسية','onchange' => 'toggleSearchInputs()']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>
    </div>

    <div id="search-inputs">
        <div class="row mb-1">
            <div class="col-md">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'المدرسة','name' => 'school_id','options' => ['' => 'اختر المدرسة'] +schools()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'select2' => '','onLoad' => ''.e(request('school_id') ? null : 'change').'','data-placeholder' => 'اختر المدرسة','data-msg' => 'رجاء اختيار المدرسة']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>

            <div class="col-md">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'النوع','name' => 'gender_id','options' => request('school_id') ? ['' => 'اختر النوع'] + App\Models\Gender::genders(true,request('school_id')) : []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'select2' => '','data-placeholder' => 'اختر النوع','data-msg' => 'رجاء اختيار النوع']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>

            <div class="col-md">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'المرحلة','name' => 'grade_id','options' => request('gender_id') ? ['' => 'اختر المرحلة'] + App\Models\Grade::grades(true,request('gender_id')) : []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'select2' => '','data-placeholder' => 'اختر المرحلة','data-msg' => 'رجاء اختيار المرحلة']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>

            <div class="col-md">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'الصف الدراسي','name' => 'level_id','options' => request('grade_id') ?  ['' => 'اختر الصف'] + App\Models\Level::levels(true,request('grade_id')) : []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'select2' => '','data-placeholder' => 'اختر الصف الدراسي','data-msg' => 'رجاء اختيار الصف الدراسي']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>

            <div class="col-md">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'حالة التجديد','name' => 'new_contract_status','options' => ['' => 'جميع الطلاب'] + getRenewStatus()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'نتيجة الطالب','name' => 'exam_result','options' => ['' => 'اختر نتيجة الطالب', 'null' => 'غير محدد' ] + App\Models\Contract::EXAM_RESULT] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-placeholder' => 'اختر نتيجة الطالب']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>

            <div class="col-md">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'حالة التعاقد','name' => 'status','options' => ['' => 'اختر حالة التعاقد'] + App\Models\Contract::STATUS] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-placeholder' => 'اختر حالة التعاقد']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>

            <div class="col-md-3">
                <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'حالة الطالب','name' => 'student_status','options' => ['' => 'جميع الطلاب'] + getStudentStatus()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
            </div>

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
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->has('transportation'))]); ?>مشترك في خدمة النقل <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543)): ?>
<?php $component = $__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543; ?>
<?php unset($__componentOriginal8f36610f94c677fdc0d1e42564c9aa2e74651543); ?>
<?php endif; ?>
            </div>
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
     <?php $__env->slot('title', null, []); ?> الطلاب المسجلين بالمدرسة <?php if(! is_null($year)): ?><span class="text-danger"> للعام الدراسي(<?php echo e($year->year_name); ?>)</span><?php endif; ?> <?php $__env->endSlot(); ?>
     <?php $__env->slot('cardbody', null, []); ?> قائمة الطلاب المسجلين بالمدرسة .. <?php echo e(sprintf('معروض %s طالب من اصل %s طالب مسجل بالنظام مطابق لمعطيات البحث ',$students->count(),$students->total())); ?> <?php $__env->endSlot(); ?>

     <?php $__env->slot('thead', null, []); ?> 
        <tr>
            <th scope="col">الاجراءات</th>
            <th scope="col">كود</th>
            <th scope="col">اسم الطالب</th>
            <th scope="col">النوع</th>
            <th scope="col">رقم الهوية</th>
            <th scope="col">الجنسية</th>
            <th scope="col">الفئة</th>
            <?php if(request('academic_year_id')): ?>
            <th scope="col">حالة الطالب</th>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <th scope="col">الخطة</th>
            <th scope="col">السداد</th>
            <?php endif; ?>
            <th scope="col">الصف</th>
            <th scope="col">النتيجة</th>
            <th scope="col">حالة التعاقد</th>
            <th scope="col">مقدم الطلب</th>
            <?php endif; ?>
            <th scope="col">الرعاية</th>
            <th scope="col">مزامنة نور</th>
            <th scope="col">اخر تعديل</th>
        </tr>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('tbody', null, []); ?> 
        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('students-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.view','data' => ['route' => route('students.show', [$student->id])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.show', [$student->id]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('students-edit')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.edit','data' => ['route' => route('students.edit', [$student->id])]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.edit', [$student->id]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.generic','data' => ['colorClass' => 'warning btn-icon round','icon' => 'list','route' => route('students.contracts.index', [$student->id]),'title' => 'قائمة التعاقدات']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colorClass' => 'warning btn-icon round','icon' => 'list','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.index', [$student->id])),'title' => 'قائمة التعاقدات']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if($student->contract_id): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inputs.btn.generic','data' => ['colorClass' => 'primary btn-icon round','icon' => 'dollar-sign','route' => route('students.contracts.transactions.index', [$student->id,$student->contract_id]),'title' => 'تفاصيل تعاقد عام '.e($year->year_name).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.btn.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colorClass' => 'primary btn-icon round','icon' => 'dollar-sign','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('students.contracts.transactions.index', [$student->id,$student->contract_id])),'title' => 'تفاصيل تعاقد عام '.e($year->year_name).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>

        </td>

        <th scope="row"> <?php echo e($student->id); ?> </th>
        <td><abbr title="<?php echo e($student->student_name_en); ?>"><?php echo e($student->student_name); ?></abbr></td>
        <td><?php echo e($student->gender ? 'ذكر' : 'انثي'); ?></td>
        <td><?php echo e($student->national_id); ?></td>
        <td><?php echo e($student->nationality_name); ?></td>
        <td><span class="badge bg-<?php echo e($student->color); ?>"><?php echo e($student->category_name); ?></span></td>
        <?php if($student->contract_id): ?>
        <td><?php echo $student->contract->getStudentStatus($student->graduated); ?></td>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accuonts-list')): ?>
        <td><?php echo e($student->plan_name); ?></td>
        <td><?php echo $student->contract->GetContractSpan(); ?></td>
        <?php endif; ?>
        <td><abbr title="<?php echo e(sprintf('%s - %s - %s - %s',$student->school_name , $student->gender_name, $student->grade_name, $student->level_name)); ?>"><?php echo e($student->level_name); ?></abbr></td>
        <td><?php echo $student->contract->getExamResult(); ?></td>
        <td><?php echo $student->contract->getStatus(); ?></td>
        <td><?php echo e($student->sales_admin_name); ?></td>
        <?php endif; ?>
        <td><?php echo e($student->student_care ? 'نعم' : 'لا'); ?></td>
        <td><?php if(null !== $student->last_noor_sync): ?> <abbr title="<?php echo e($student->last_noor_sync); ?>"><em data-feather='check-circle' class="text-success"></em></abbr><?php else: ?> <em class="text-danger" data-feather='x-circle'></em> <?php endif; ?></td>
        <td><abbr title="<?php echo e($student->created_at->format('Y-m-d h:m:s')); ?>"><?php echo e($student->updated_at->format('Y-m-d h:m:s')); ?></abbr></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('pagination', null, []); ?> 
        <?php echo e($students->appends(request()->except('page'))->links()); ?>

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

<?php $__env->startSection('page-modal'); ?>
<div class="offcanvas offcanvas-start" tabindex="-1" id="AssignAdminModal" aria-labelledby="AssignAdminModalLabel">
    <div class="offcanvas-header">
        <h5 id="AssignAdminModalLabel" class="offcanvas-title">اضافة ولي امر كمدير</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <div class="text-center mb-2 text-danger">
            <me data-feather="user-plus" class="font-large-3"></me>
        </div>
        <h3 class="text-center text-dark" id="slot">
            جاري تحميل المعلومات
        </h3>
        <?php echo Form::open(['route' => 'admins.assignAdminRole','method'=>'POST' , 'onsubmit' => 'showLoader()']); ?>


        <input type="hidden" name="user_id" id="user_id">

        <div class="col-lg mb-1">
            <?php if (isset($component)) { $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Text\Input::class, ['label' => 'المسمي الوظيفي','icon' => 'user','name' => 'job_title'] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.text.Input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Text\Input::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'ادخل المسمي الوظيفي','data-msg' => 'ادخل المسمي الوظيفي بشكل صحيح']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6)): ?>
<?php $component = $__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6; ?>
<?php unset($__componentOriginalb4161b09f52c676e9e9dc4699d32a898e5671fa6); ?>
<?php endif; ?>
        </div>

        <div class="col-lg mb-1">
            <?php if (isset($component)) { $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Inputs\Select\Generic::class, ['label' => 'الدور الأداري','name' => 'roles[]','options' => Spatie\Permission\Models\Role::pluck('display_name', 'name')->toArray()] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('inputs.select.generic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\Inputs\Select\Generic::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-placeholder' => 'اختر الدور الأداري','data-msg' => 'رجاء اختيار الدور الأجاري','multiple' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41)): ?>
<?php $component = $__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41; ?>
<?php unset($__componentOriginal8df174c804aecaa46b79b852fb1fa4117c8e2c41); ?>
<?php endif; ?>
        </div>


        <button type="submit" class="btn btn-danger mb-1 d-grid w-100">تأكيد</button>
        <?php echo Form::close(); ?>

        <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
            تراجع
        </button>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script>
    toggleSearchInputs();
    var AssignAdminModal = document.getElementById('AssignAdminModal')
    AssignAdminModal.addEventListener('show.bs.offcanvas', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget

        // Extract info from data-bs-* attributes
        var user_id = button.getAttribute('data-bs-user_id')
        var user_name = button.getAttribute('data-bs-user_name')

        // Update the modal's content.
        var modalTitle = AssignAdminModal.querySelector('#slot')
        var user_id_input = AssignAdminModal.querySelector('#AssignAdminModal #user_id')

        modalTitle.textContent = 'تعيين ولي الامر : ' + user_name + ' #(' + user_id + ') - كمدير'
        user_id_input.value = user_id
    })

    function toggleSearchInputs() {
        input = document.getElementById('academic_year_id')
        let div = document.getElementById('search-inputs');
        div.style = !input.value ? 'pointer-events: none;opacity: 0.4;' : '';
    }
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
<!-- vendor files -->
<script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/picker.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/picker.date.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/picker.time.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/legacy.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js'))); ?>"></script>
<script src="<?php echo e(asset(mix('vendors/js/extensions/sweetalert2.all.min.js'))); ?>"></script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
<!-- Page js files -->

<script src="<?php echo e(asset(mix('js/scripts/forms/pickers/form-pickers.js'))); ?>"></script>
<script src="<?php echo e(asset('js/scripts/components/components-dropdowns.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH I:\wamp64\www\AbnayiyOnVuexsy\resources\views/admin/student/index.blade.php ENDPATH**/ ?>