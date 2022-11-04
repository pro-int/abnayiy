
const BASEURL = '/admin_dashboard'

async function postData(url = '', data = {}) {
    // Default options are marked with *
    data._token = document.getElementsByName('_token')[0].value
    const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data) // body data type must match "Content-Type" header
    });

    return response.json(); // parses JSON response into native JavaScript objects
}


const is_admin = document.getElementById('is_admin')
const is_teacher = document.getElementById('is_teacher')
const is_guardian = document.getElementById('is_guardian')
let dataArray = [];
let eventsArray = [];
let event = new Event('change');

if (is_admin) {
    is_admin.addEventListener('change', (event) => {
        let roles = document.getElementById("roles[]")
        job_title.required = event.currentTarget.checked
        roles.required = event.currentTarget.checked
    })
    is_admin.dispatchEvent(event);
}

if (is_teacher) {
    is_teacher.addEventListener('change', (event) => {
        let clases = document.getElementById("clases[]")
        clases.required = event.currentTarget.checked
    })
    is_teacher.dispatchEvent(event);
}

if (is_guardian) {
    is_guardian.addEventListener('change', (event) => {
        let nationality_id = document.getElementById("nationality_id")
        let national_id = document.getElementById("national_id")

        is_guardian.required = event.currentTarget.checked
        nationality_id.required = event.currentTarget.checked
        national_id.required = event.currentTarget.checked
    })
    is_guardian.dispatchEvent(event);
}

const school_id = document.getElementById('school_id')

if (school_id) {
    school_id.addEventListener('change', (event) => {
        LoadDataToSelect('gender_id', 'genders', school_id)
    })
    if (school_id.getAttribute('onLoad') === 'change') {
        school_id.dispatchEvent(event)
    }
}


const gender_id = document.getElementById('gender_id')

if (gender_id) {
    gender_id.addEventListener('change', (event) => {
        LoadDataToSelect('grade_id', 'grades', gender_id)
    })
}

const grade_id = document.getElementById('grade_id')

if (grade_id) {
    grade_id.addEventListener('change', (event) => {
        LoadDataToSelect('level_id', 'levels', grade_id)

        const period_id = document.getElementById('period_id')
        if (period_id && school_id.value && gender_id.value && grade_id.value) {
            GetDiscounts(BASEURL + '/json/discounts', { 'school_id': school_id.value, 'gender_id': gender_id.value, 'grade_id': grade_id.value, 'period_id': period_id.value }, setData)
        }
    })
}

function LoadDataToSelect(t, a, f) {
    if (!f || !f.options[0] || undefined === f.options[0].text || f.options[0].text === 'لا يوجد اختيارات') {
        return
    }
    const resp = document.getElementById('resp_dev')
    if (resp) resp.innerHTML = ''

    if (!Object.keys(dataArray).length) {
        main_data(LoadDataToSelect, t, a, f)
        return
    }

    let t_input = document.getElementById(t);
    if (t_input && Object.keys(dataArray[a]).length) {

        removeOptions(t_input);

        let is_first_option = true

        for (let key in dataArray[a]) {

            // skip loop if the property is from prototype
            // if (!dataArray.genders.hasOwnProperty(key)) continue;

            let obj = dataArray[a][key];


            if (obj[f.name] === parseInt(f.value)) {
                if (is_first_option) {
                    let opt = document.createElement('option');
                    opt.value = ''
                    opt.innerHTML = 'اختر'
                    t_input.appendChild(opt);
                    is_first_option = false
                }
                let opt = document.createElement('option');

                opt.value = obj.id;
                opt.innerHTML = obj[t_input.name.replace('id', 'name')]
                t_input.appendChild(opt);
            }
        }
    }
    CheckIFEmpty(t_input)
}

function removeOptions(t_input, fireChange = true) {
    let i, L = t_input.options.length - 1;
    for (i = L; i >= 0; i--) {
        t_input.remove(i);
    }
    fireChange && t_input.dispatchEvent(new Event('change'))
}

function CheckIFEmpty(t_input) {
    if (t_input && !t_input.options.length) {

        let opt = document.createElement('option');
        opt.value = ''
        opt.innerHTML = 'لا يوجد اختيارات'
        t_input.appendChild(opt);
    }
    t_input && t_input.dispatchEvent(new Event('change'))

}

function main_data(callback, a, t, f) {

    const ipAPI = BASEURL + '/json/main_data'

    postData(ipAPI, {})
        .then(response => {
            if (response && response.done) {
                dataArray = response.data;
                callback(a, t, f);

            }
        });
}

function GetDiscounts(theUrl, prams, callback) {
    let xmlHttp = new XMLHttpRequest();
    showLoader();

    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            let res = JSON.parse(xmlHttp.responseText);
            callback(res);
        }
    }

    const token = document.getElementById('csrf-token');
    xmlHttp.open("POST", theUrl, true);
    xmlHttp.setRequestHeader('Content-Type', 'application/json');
    xmlHttp.setRequestHeader('X-CSRF-TOKEN', token.value);
    xmlHttp.send(JSON.stringify(
        prams
    ));
    hideLoader();
}

function setData(res) {
    showLoader();

    const resp_dev = document.getElementById('resp_dev')
    resp_dev.innerHTML = res.data
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
    hideLoader();
}



/********************* get meeting slots start ***********************/

async function getMeetingSlots(e) {
    $('#selected_time').empty().trigger("change");

    let data = { selected_date: new Date(e.value) };
    if (grade_id && grade_id.value) {
        data.grade_id = grade_id.value
    } else {
        const grade_input = document.getElementById('grade_id')
        if (grade_input) {
            data.grade_id = grade_input.value
        }
    }
    if (!data.grade_id) {
        showAlert('رجاء اختيار المسار الدراسي اولا لتتمكن من اختيار موعد المقابلة', 'error')
        return
    }
    const selected_date = e.value;
    const ipAPI = BASEURL + '/json/getMeetingSlots'
    selected_date && postData(ipAPI, data)
        .then(response => {
            if (response && response.success) {

                if (response.data.success) {
                    response.data.slots.forEach(slot => {
                        let newOption = new Option(slot.time, slot.id, false, false);
                        $('#selected_time').append(newOption);
                    });
                } else {
                    showAlert(response.data.message, 'warning')
                    let newOption = new Option(response.data.message, null, false, false);
                    $('#selected_time').append(newOption);
                }
            }
        });
}

function toggleMeetingType(e) {
    let div = document.getElementById('meeting_info_div');
    div.style.display = e.checked ? 'flex' : 'none';
    e.checked ? document.getElementById('online_url').setAttribute('required', true) : document.getElementById('online_url').removeAttribute('required');

}

function toggleAppointmentDate(e) {
    let div = document.getElementById('reschedule_appointment');

    if (e.checked) {
        div.style.display = 'flex';
        document.getElementById('selected_date').setAttribute('required', true)
        document.getElementById('selected_time').setAttribute('required', true)
    } else {
        div.style.display = 'none';
        document.getElementById('selected_date').removeAttribute('required')
        document.getElementById('selected_time').removeAttribute('required')
    }

}
/*********************get meeting slots end *************************/

/******************** Export  file start  *******************/

function exportresult(type) {
    showLoader();
    const urlSearchParams = new URLSearchParams(window.location.search);
    let params = Object.fromEntries(urlSearchParams.entries());
    params.export_to = type
    console.log(params);

    let xmlHttp = new XMLHttpRequest();

    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            let res = JSON.parse(xmlHttp.responseType);
            callback(res);
        }
    }

    xmlHttp.responseType = 'blob';
    xmlHttp.open("GET", window.location.href + '&export_to=' + type, true);

    xmlHttp.setRequestHeader('Content-Type', 'application/json');
    xmlHttp.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('_token')[0].value);
    xmlHttp.send();
    hideLoader()
}


/********************** Export  file End  ****************** */
function UpdateLevel(identifier) {
    showLoader();
    const level_id = identifier.getAttribute('data-level_id')
    const category_id = identifier.getAttribute('dtat-category_id')

    let class_name = '.level-' + level_id + '-category-' + category_id
    let inputs = document.querySelectorAll(class_name);
    const plans = []
    for (const key in inputs) {
        if (Object.hasOwnProperty.call(inputs, key)) {
            const element = inputs[key];
            if (element.value < 0 || element.value > 100) {
                showAlert('قيمة الخصم يجب ان تكون ما بين 0 و 100 %', 'error');
                hideLoader()
                return
            }

            plans.push({ 'plan_id': element.getAttribute('data-plan_id'), 'value': element.value })
        }
    }
    const period_id = document.getElementById('period_id').value

    UpdateDiscount(BASEURL + '/json/UpdateDiscount', { 'period_id': period_id, 'level_id': level_id, 'category_id': category_id, 'plans': plans }, UpdateLeveldone, identifier)
    hideLoader();
}

function UpdateDiscount(theUrl, prams, callback, identifier) {
    showLoader();

    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4) {
            let res = JSON.parse(xmlHttp.responseText);
            if (xmlHttp.status == 200) {
                identifier.style.visibility = 'hidden';
                callback(res);
                showAlert(res.message)
            } else {
                showAlert(res.message, 'error')
            }
        }

    }

    const token = document.getElementById('csrf-token');
    xmlHttp.open("POST", theUrl, true);
    xmlHttp.setRequestHeader('Content-Type', 'application/json');
    xmlHttp.setRequestHeader('X-CSRF-TOKEN', token.value);
    xmlHttp.send(JSON.stringify(
        prams
    ));

}

function handelButton(e) {
    const el = e.parentElement.parentElement.parentElement.parentElement
    const closestBtn = el.lastElementChild.children
    closestBtn[0].style.visibility = 'visible';
}

function UpdateLeveldone(res) {
    hideLoader();
    showAlert(res.message);

}

function showAlert(message, icon = 'success', position = 'bottom') {
    Swal.fire({
        position: position,
        icon: icon,
        title: message,
        showConfirmButton: false,
        toast: true,
        timer: 2500,
        width: '500px',
        type: icon,
        timerProgressBar: true,
    })
}

function DeleteForm(route) {
    let form = document.createElement("form");
    let _method = document.createElement("INPUT");
    let _token = document.createElement("INPUT");

    form.method = "POST";
    form.action = route;

    _method.value = 'DELETE';
    _method.name = '_method';
    _method.type = 'hidden';
    form.appendChild(_method);

    _token.value = document.getElementsByName('_token')[0].value;
    _token.name = '_token';
    _token.type = 'hidden';
    form.appendChild(_token);

    document.body.appendChild(form);
    form.submit();
}

function DeleteRecord(btn) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success m-1',
            cancelButton: 'btn btn-danger m-1',
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'هل تريد تأكيد الحذف',
        text: "في حالة حذف احد العناصر - يتم حذف جميع المعلومات المرتبطة بة",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم , تأكيد الحذف',
        cancelButtonText: 'لا, الغاء عملية الحذف!',
        reverseButtons: false
    }).then((result) => {
        if (result.isConfirmed) {
            DeleteForm(btn.getAttribute('data-href'))
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: 'تاكيد',
                text: 'تم الغاء علمية الحذف :)',
                confirmButtonText: 'تم',
                icon: 'success'
            })
        }
    })
}

function updatePermissionStatus(btn) {
    document.updatePermissionForm.action = btn.getAttribute('data-href')
    $('#updatePermissionModal').modal('show');

}

async function GetMettingInfo(btn) {
    const ipAPI = BASEURL + '/applications/meetingInfo'

    postData(ipAPI, { appointment_id: btn.getAttribute('data-id') })
        .then(data => {
            let modal = document.getElementById('meetingModal')
            modal.innerHTML = data.html
            let bsOffcanvas = new bootstrap.Offcanvas(modal)
            let basicPickr = $('.flatpickr-basic'),
                timePickr = $('.flatpickr-time');
            if (timePickr.length) {
                timePickr.flatpickr({
                    enableTime: true,
                    noCalendar: true
                });
            }
            if (basicPickr.length) {
                basicPickr.flatpickr();
            }
            feather.replace({
                width: 14,
                height: 14
            });
            bsOffcanvas.show()
        });

}

async function updateMettingresult(btn) {
    const ipAPI = BASEURL + '/applications/meetingresult'

    postData(ipAPI, { appointment_id: btn.getAttribute('data-id') })
        .then(data => {
            let modal = document.getElementById('meetingModal')
            modal.innerHTML = data.html
            let bsOffcanvas = new bootstrap.Offcanvas(modal)
            let basicPickr = $('.flatpickr-basic'),
                timePickr = $('.flatpickr-time');
            if (timePickr.length) {
                timePickr.flatpickr({
                    enableTime: true,
                    noCalendar: true
                });
            }
            if (basicPickr.length) {
                basicPickr.flatpickr();
            }
            feather.replace({
                width: 14,
                height: 14
            });
            bsOffcanvas.show()
        });


}

async function ChangeStatus(btn) {

    const changeTo = btn.getAttribute('data-changeTo');
    let title, text, confirmButtonText, cancelButtonText;

    switch (changeTo) {
        case 'noor':
            title = 'هل تم اضافة الطلب الي نور ؟'
            text = 'رجاء التاكد من اضافة بيانات الطالب اولا الي نظام نور'
            confirmButtonText = 'نعم ,تم الاضافة الي نور'
            cancelButtonText = 'لا, لم يتم الاضافة!'
            break;

        case 'pending':
            title = 'اضافة الطالب الي قائمة الانتظار ؟'
            text = 'سيتم تحويل الطلب الي قائمة الانتظار لحين اتمام القبول النهائي'
            confirmButtonText = 'نعم , تحويل الطلب'
            cancelButtonText = 'لا, الغاء التحويل!'
            break;

        case 'confirm':
            title = 'اضافة الطالب الي قائمة الطلاب ؟'
            text = 'سيتم اضافة الطالب الي قائمة الطلاب المسجلين بالمدرسة'
            confirmButtonText = 'نعم , تسجيل الطلب'
            cancelButtonText = 'لا, الغاء التسجيل!'
            break;

        case 'reopen':
            title = 'اعادة فتح الطلب ؟'
            text = 'سيتم اعادة حالة الطلب الي طلب جديد'
            confirmButtonText = 'نعم , فتح الطلب'
            cancelButtonText = 'لا, الغاء!'
            break;
        default:
            return
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success m-1',
            cancelButton: 'btn btn-danger m-1',
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        reverseButtons: false
    }).then((result) => {
        if (result.isConfirmed) {
            const ipAPI = BASEURL + '/applications/updateapplicationstatus'

            postData(ipAPI, { application_id: btn.getAttribute('data-id'), changeTo: changeTo })
                .then(data => {
                    if (data.done) {
                        swalWithBootstrapButtons.fire({
                            title: 'تاكيد',
                            text: data.message,
                            confirmButtonText: 'تم',
                            icon: 'success'
                        })
                        location.reload()
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: 'فشل',
                            text: data.message,
                            confirmButtonText: 'موافق',
                            icon: 'error'
                        })
                    }
                })
        }
    })
}


function handelModelId(btn) {
    document.transactionsrefuse.paymentAttempt_id.value = btn.getAttribute('data-id')
    $('#refuseTransactionModal').modal('show');

}

function handelModelIdConfirmTrans(btn) {
    document.transactionsconfirm.paymentAttempt_id.value = btn.getAttribute('data-id')
    $('#confirmTransactionModal').modal('show');

}

const sections = document.getElementById('section_id')

sections && sections.addEventListener('change', (event) => {

    getSectionEvents(sections.value)
})

function LoadSectionEvents(callback, section_id) {
    const ipAPI = BASEURL + '/notifications/events/getSectionEvents'

    postData(ipAPI, {})
        .then(response => {
            if (response && response.done) {
                eventsArray = response.data;
                callback(section_id)
            }
        });
}

async function getSectionEvents(section_id) {
    if (!Object.keys(eventsArray).length) {
        LoadSectionEvents(getSectionEvents, section_id)
        return
    }
    const events = document.getElementById('event_id')
    removeOptions(events, false)

    for (let key in eventsArray) {

        const item = eventsArray[key]
        if (item.section_id == section_id) {
            let opt = document.createElement('option');
            opt.value = item.id;
            opt.innerHTML = item.event_name
            events.appendChild(opt);
        }
    }
}

function GetDynamicContent(value) {
    if (!value) {
        alert('اختر مناسبة الاشعار اولا')
        return;
    }
    if (!Object.keys(eventsArray).length) {
        LoadSectionEvents(GetDynamicContent, value)
        return
    }

    const item = eventsArray.filter(item => item.id == value)

    const body = document.getElementById('res')
    body.innerHTML = ''
    for (let key in item[0].content_vars) {
        body.insertAdjacentHTML("beforeend", '<div class="row mb-1"> <label class="col-md-4 col-form-label text-md-start">' + item[0].content_vars[key].replace('_', ' ') + '</label><div class="col-md-6 text-md-start""><label for="target_user" class="form-control ">%' + item[0].content_vars[key] + '</label></div></div>')
    }
    $('#contentModal').modal('show');
}

const frequent = document.getElementById('frequent');

frequent && frequent.addEventListener('change', () => {
    const content_id = document.getElementById('content_id');
    content_id && frequent.value == 'frequent' ? content_id.setAttribute('disabled', 1) : content_id.removeAttribute('disabled')

})

const target_user = document.getElementById('target_user');

target_user && target_user.addEventListener('change', () => {
    const to_notify = document.getElementById('to_notify');
    to_notify && target_user.value == 'user' ? to_notify.setAttribute('disabled', 1) : to_notify.removeAttribute('disabled')
})

target_user && target_user.dispatchEvent(event);
frequent && frequent.dispatchEvent(event);





// handel transportation 
const payment_type = document.getElementById('payment_type')
const transportation_id = document.getElementById('transportation_id')
let transportationArray = []

payment_type && payment_type.addEventListener('change', (event) => {
    getTransportationFees(transportation_id.value, payment_type.value)
})

payment_type && transportation_id && transportation_id.addEventListener('change', (event) => {
    getTransportationFees(transportation_id.value, payment_type.value)
})

transportation_id && transportation_id.dispatchEvent(event)

function LoadTransportationFees(callback, transportation_id, payment_type) {
    const ipAPI = BASEURL + '/json/getTransportationFees'
    payment_type && transportation_id ?
        postData(ipAPI, {})
            .then(response => {
                if (response && response.done) {
                    transportationArray = response.data;
                    callback(transportation_id, payment_type)
                }
            })
        :
        alert('اختر خطة النقل و طريقة الدفع اولا')
}

async function getTransportationFees(transportation_id, payment_type) {

    if (!Object.keys(transportationArray).length) {
        LoadTransportationFees(getTransportationFees, transportation_id, payment_type)
        return
    }
    const fees = document.getElementById('base_fees')
    const vat = document.getElementById('vat_amount')
    const total = document.getElementById('total_fees')

    const item = transportationArray.filter(item => item.id == transportation_id)[0]
    let feesValue = 0
    let vatValue = 0
    switch (parseInt(payment_type)) {
        case 1:
            feesValue = item.annual_fees
            break;
        case 2:
            feesValue = item.semester_fees
            break;
        case 3:
            feesValue = item.monthly_fees
            break;
        default:
            break;
    }
    vatValue = feesValue * .15

    fees.value = feesValue
    vat.value = vatValue
    total.value = feesValue + vatValue
}


// notifaction bell
let bellStu = false;
$(document).ready(function () {
    $('#bell').hover(function (e) {
        if (bellStu) {
            $('#box').css('height', '0px');
            $('#box').css('opacity', '0');
            $('#box').css('display', 'none');
            bellStu = false;
        } else {

            $('#box').css('height', 'auto');
            $('#box').css('opacity', '1');
            $('#box').css('display', 'block');

            bellStu = true;
        }

    });

});

let pageBlockCustom = $('.btn-page-block-custom');

// Custom Message

pageBlockCustom.length && pageBlockCustom.on('click', function () {
    showLoader();
});

function showLoader(timeout = 2000) {
    $.blockUI({
        message:
            '<div class="d-flex justify-content-center align-items-center"> <p class="me-50 mb-0">رجاء الانتظار...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
        css: {
            backgroundColor: 'transparent',
            color: '#fff',
            border: '0'
        },
        overlayCSS: {
            opacity: 0.5
        },
        timeout: timeout

    });
}
function hideLoader() {
    $.unblockUI();
}


let deleteModal = document.getElementById('deleteModal')
deleteModal && deleteModal.addEventListener('show.bs.offcanvas', function (event) {
    // Button that triggered the modal
    let button = event.relatedTarget

    // Extract info from data-bs-* attributes
    let href = button.getAttribute('data-href')

    // Update the modal's content.
    let deleteFrom = deleteModal.querySelector('#deleteFrom')
    deleteFrom.action = href

})

$('.only-english').keypress(function (ev) {
    let ew = ev.key;
    if (/[A-Za-z]/.test(ew)) {
        return true;
    }
    return false;
});

function toUpperCase(e) {
    e.value = e.value.toUpperCase();
}
async function get_discount_values() {
    const academic_year_id = document.getElementById('academic_year_id')
    const classification_id = document.getElementById('classification_id')

    let total_discount = document.getElementById('total_discount');
    let used_discount = document.getElementById('used_discount');
    let unused_discount = document.getElementById('unused_discount');
    let remain_discount = document.getElementById('remain_discount');

    let total_discount_span = document.getElementById('total_discount_span');
    let used_discount_span = document.getElementById('used_discount_span');
    let unused_discount_span = document.getElementById('unused_discount_span');
    let remain_discount_span = document.getElementById('remain_discount_span');

    if (academic_year_id.value && (classification_id.value || level_id.value)) {
        showLoader();

        let special_span = document.getElementById('special_span');
        if (classification_id.value) {
            special_span.setAttribute('style', '')
        } else {
            special_span.setAttribute('style', 'display:none;')
        }

        const ipAPI = BASEURL + '/json/getdiscountLimits'

        postData(ipAPI, { academic_year_id: academic_year_id.value, level_id: level_id.value, classification_id: classification_id.value })
            .then(response => {
                if (response && response.done) {

                    let total_discount_text = Math.round(response.data.max_coupon_discounts, 2) + ' ر.س - ( ' + response.data.max_coupon_discounts_percent + ' %)'

                    total_discount.setAttribute("style", "width:" + response.data.max_coupon_discounts_percent + "%");
                    total_discount.setAttribute('aria-valuenow', response.data.max_coupon_discounts_percent)
                    total_discount_span.innerText = total_discount_text


                    let unused_percent = response.data.unused_coupon_discounts > 0 ? Math.round(response.data.unused_coupon_discounts / response.data.max_coupon_discounts * 100) : 0;

                    let unused_percent_text = Math.round(response.data.unused_coupon_discounts, 2) + ' ر.س - ( ' + unused_percent + ' %)';

                    unused_discount.setAttribute("style", "width:" + unused_percent + "%");
                    unused_discount.setAttribute('aria-valuenow', 100)

                    unused_discount_span.innerText = unused_percent_text

                    let used_percent = response.data.max_coupon_discounts > 0 ? Math.round(response.data.coupon_discounts / response.data.max_coupon_discounts * 100) : 0;

                    let used_percent_text = Math.round(response.data.coupon_discounts, 2) + ' ر.س - ( ' + used_percent + ' %)';

                    used_discount.setAttribute("style", "width:" + used_percent + "%");
                    used_discount.setAttribute('aria-valuenow', 100)

                    used_discount_span.innerText = used_percent_text

                    let remain_percent = response.data.max_coupon_discounts > 0 ? Math.round(response.data.remain_coupon_discounts / response.data.max_coupon_discounts * 100) : 0;
                    let remain_discount_text = Math.round(response.data.remain_coupon_discounts, 2) + ' ر.س - ( ' + remain_percent + ' %)';
                    remain_discount.setAttribute("style", "width:" + remain_percent + "%");
                    remain_discount.setAttribute('aria-valuenow', 100)

                    remain_discount_span.innerText = remain_discount_text
                }
            }).finally(() => {
                hideLoader()
            })
    } else {
        total_discount.setAttribute("style", "width:0%");
        total_discount.setAttribute('aria-valuenow', 0)
        total_discount_span.innerText = ''

        unused_discount.setAttribute("style", "width:0%");
        unused_discount.setAttribute('aria-valuenow', 0)
        unused_discount_span.innerText = ''

        used_discount.setAttribute("style", "width:0%");
        used_discount.setAttribute('aria-valuenow', 0)
        used_discount_span.innerText = ''

        remain_discount.setAttribute("style", "width:0%");
        remain_discount.setAttribute('aria-valuenow', 0)
        remain_discount_span.innerText = ''
    }
    classification_id && toggleLevelSelection(classification_id)

}


async function get_CouponClassification(fireChange = true, id = 'id') {
    const academic_year_id = document.getElementById('academic_year_id')

    if (academic_year_id) {
        showLoader();
        const ipAPI = BASEURL + '/json/getYearCouponClassification'


        postData(ipAPI, { academic_year_id: academic_year_id.value, id: id })
            .then(response => {
                if (response && response.done) {
                    const classification_id = document.getElementById('classification_id')
                    removeOptions(classification_id, false)

                    let opt = document.createElement('option');
                    opt.value = '';
                    opt.innerHTML = 'قسائم عامة'
                    classification_id.appendChild(opt);

                    const Classifications = response.data.Classifications
                    for (let key in Classifications) {

                        let ele = document.createElement('option');
                        ele.value = key;
                        ele.innerHTML = Classifications[key]
                        classification_id.appendChild(ele);

                    }

                }
            }).finally(() => {
                hideLoader()

                if (fireChange) get_discount_values()
            })
    }
}

function toggleLevelSelection(e) {
    let div = document.getElementById('selection');
    div.style = e.value ? 'pointer-events: none;opacity: 0.4;' : '';
    school_id.required = !e.value
    gender_id.required = !e.value
    grade_id.required = !e.value
    level_id.required = !e.value
    if (e.value) level_id.value = '';
}

let schools = []

async function loadSchools() {

    if (!Object.keys(schools).length) {
        showLoader();
        const ipAPI = BASEURL + '/json/getSchools'

        await postData(ipAPI, { corporate_id: null, returnArray: true })
            .then(response => {
                if (response && response.done) {
                    schools = response.data.schools;
                }
            }).finally(() => {
                hideLoader()
            })
    }
}

function getSchools(e) {
    const schools_inputs = document.getElementById('school_id');
    removeOptions(schools_inputs, false)
    if (e.value) {
        loadSchools().then(() => {
            for (let key in schools) {
                const item = schools[key]
                if (item.corporate_id == e.value) {
                    let opt = document.createElement('option');
                    opt.value = item.id;
                    opt.innerHTML = item.school_name
                    schools_inputs.appendChild(opt);
                }
            }
        })
    }
}

function changeCorporate() {
    showLoader();

    document.getElementsByName('corporate_switch_form')[0].submit()
  
}