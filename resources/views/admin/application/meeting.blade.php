<div class="offcanvas-header">
    <h5 id="AssignAdminModalLabel" class="offcanvas-title">تفاصيل المقابلة الطلب رقم : # {{ $meeting->application_id }}</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body my-auto mx-0 flex-grow-0">
    <div class="text-center mb-2 text-success ">
        <me data-feather="calendar" class="font-large-2"></me>
    </div>
    <h3 class="text-center text-dark" id="slot">
        معلومات الموعد
    </h3>

    {!! Form::model($meeting,['route' => 'applications.meeting','method'=>'PUT' , 'onsubmit' => 'showLoader()'])  !!}

    <input type="hidden" name="appointment_id" value="{{ $meeting->id }}">
    <input type="hidden" name="application_id" value="{{ $meeting->application_id }}">
    <input type="hidden" id="gender_id" name="gender_id" value="{{$meeting->gender_id}}">

    <x-ui.divider>الموعد الحالي</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <x-inputs.text.Input disabled label="تاريخ المقابلة الحالي" class="form-control flatpickr-basic" icon="calendar" name="old_selected_date" :value="$meeting->selected_date" />
        </div>

        <div class="col-md">
            <x-inputs.text.Input disabled label="موهد الأجتماع الحالي" name="current_selected_time" icon="watch" :value="$meeting->appointment_time" />
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <x-inputs.text.Input disabled label="المكتب" icon="flag" name="office_name" />
        </div>
        <div class="col-md">
            <x-inputs.text.Input disabled label="الموظف" icon="flag" name="employee_name" />
        </div>
    </div>


    <div class="row">
        <div class="col-md">
            <label class="form-label mb-1">تغيير موعد المقابلة</label>
            <x-inputs.checkbox name="change_appointment" onclick="toggleAppointmentDate(this)">
                جدولة اجتماع في موعد اخر
            </x-inputs.checkbox>
        </div>
    </div>

    <div class="row mb-1" id="reschedule_appointment" style="display: none;">
        <div class="col-md">
            <x-inputs.text.Input :required="false" label="تاريخ المقابلة" class="form-control flatpickr-basic" icon="calendar" name="selected_date" value="" onchange="getMeetingSlots(this)" placeholder="ادخل متاح ابتداء من" />
        </div>

        <div class="col-md">
            <x-inputs.select.generic :required="false" label="موهد الأجتماع" name="selected_time" data-placeholder="اختر موهد الأجتماع" data-msg="رجاء اختيار موهد الأجتماع" :options="[]" />
        </div>
    </div>
    <x-ui.divider>موقع الاجتماع</x-ui-divider>

    <div class="row mb-1">
        <div class="col-md">
            <label class="form-label mb-1">موقع الأجتماع</label>
            <x-inputs.checkbox name="online" onclick="toggleMeetingType(this)">
            اجتماع عن بعد ؟
            </x-inputs.checkbox>
        </div>
    </div>

    <div class="row mb-1" id="meeting_info_div" style="{{ $meeting->online ? '' : 'display: none;' }}">
        <div class="col-md-12">
            <x-inputs.text.Input :required="$meeting->online ? true : false" label="رايط الأجتماع" icon="link" name="online_url" placeholder="ادخل رايط الأجتماع بالصيغة الدولية" data-msg="ادخل رايط الأجتماع بشكل صحيح" />
        </div>

        <div class="col-md-12">
            <label class="form-label mb-1">اجتماع جديد ؟</label>
            <div>
                <a type="button" class="btn btn-sm btn-outline-danger waves-effect me-1" href="https://meet.google.com/" target="_blank" data-bs-toggle="popover" data-bs-content="اسم المستخدم: meet@nobala.edu.sa -  كلمة السر : rWD6y<4W  - بعد أن تقوم بإنشاء الاجتماع قم بنسخ رابط الاجتماع ولصقه في مربع رايط الأجتماع  " data-bs-trigger="hover" title="ستخدم بيانات الدخول التالية "> <em data-feather='external-link'></em> انشاء اجتماع جديد</a>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success  mb-1 d-grid w-100">تأكيد</button>
    {!! Form::close() !!}
    <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
        تراجع
    </button>
</div>
