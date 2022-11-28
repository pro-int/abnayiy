<div class="offcanvas-header">
    <h5 id="AssignAdminModalLabel" class="offcanvas-title">نتيجة مقابلة الطلب رقم : # {{ $meeting->application_id }}</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body my-auto mx-0 flex-grow-0">
    <div class="text-center mb-2 text-danger">
        <me data-feather="headphones" class="font-large-3"></me>
    </div>
    <h3 class="text-center text-dark" id="slot">
        نتيجة المقابلة
    </h3>
    {!! Form::model($meeting,['route' => 'applications.meeting_result','method'=>'PUT' , 'onsubmit' => 'showLoader()'])  !!}

    <input type="hidden" name="appointment_id" value="{{ $meeting->id }}">
    <input type="hidden" name="application_id" value="{{ $meeting->application_id }}">

    <div class="col-lg mb-1">
        <x-inputs.text.Input label="ملخص الاجتماع" icon="file-text" name="summary" placeholder="ادخل ملخص الاجتماع" data-msg="ادخل ملخص الاجتماع بشكل صحيح" />
    </div>

    <div class="col-lg mb-1">
        <label class="form-label">حضر الي المقابلة </label>
        <div class="col-md  mb-1">
            <x-inputs.radio id="attended" value="1" name="attended"> نعم</x-inputs.checkbox>
                <x-inputs.radio id="attended2" value="0" name="attended"> لم يحضر</x-inputs.checkbox>
        </div>
    </div>

    <div class="col-lg mb-1">
        <label class="form-label">نتيجة المقابلة </label>
        <div class="col-md  mb-1">
            <x-inputs.radio id="approved" value="1" name="approved"> طالب مقبول</x-inputs.checkbox>
                <x-inputs.radio id="approved2" value="0" name="approved"> طالب مرفوض</x-inputs.checkbox>
        </div>
    </div>


    <button type="submit" class="btn btn-success  mb-1 d-grid w-100">حفظ النتيجة</button>
    {!! Form::close() !!}
    <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
        تراجع
    </button>
</div>