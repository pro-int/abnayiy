<?php

use App\Http\Controllers\admin\AdminAcademicYearController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminApplicationController;
use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminClassRoomController;
use App\Http\Controllers\admin\AdminTypeController;
use App\Http\Controllers\admin\AdminGenderController;
use App\Http\Controllers\admin\AdminGradeController;
use App\Http\Controllers\admin\AdminLevelController;
use App\Http\Controllers\admin\AdminRoleController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AdminCountryController;
use App\Http\Controllers\admin\AdminDiscountController;
use App\Http\Controllers\admin\AdminGuardianController;
use App\Http\Controllers\admin\AdminJsonController;
use App\Http\Controllers\admin\AdminApplicationManageController;
use App\Http\Controllers\admin\AdminOfficeScheduleController;
use App\Http\Controllers\admin\AdminAttendanceManageController;
use App\Http\Controllers\admin\AdminBankController;
use App\Http\Controllers\admin\AdminContractController;
use App\Http\Controllers\admin\AdminContractTermsController;
use App\Http\Controllers\admin\AdminCouponsController;
use App\Http\Controllers\admin\AdminNationalityController;
use App\Http\Controllers\admin\AdminPaymentAttemptController;
use App\Http\Controllers\admin\AdminPeriodController;
use App\Http\Controllers\admin\AdminPlanController;
use App\Http\Controllers\admin\AdminReportsController;
use App\Http\Controllers\admin\AdminResetPassword;
use App\Http\Controllers\admin\AdminSemesterController;
use App\Http\Controllers\admin\AdminStudentAttendanceController;
use App\Http\Controllers\admin\AdminStudentController;
use App\Http\Controllers\admin\AdminStudentParticipationController;
use App\Http\Controllers\admin\AdminStudentPermissionController;
use App\Http\Controllers\admin\AdminStudentTransportationController;
use App\Http\Controllers\admin\AdminTeacherController;
use App\Http\Controllers\admin\AdminTransactionController;
use App\Http\Controllers\admin\AdminTransportationController;
use App\Http\Controllers\guardian\GuardianApplicationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\admin\AdminSubjectController;
use App\Http\Controllers\admin\AdminAppointmentOfficeController;
use App\Http\Controllers\admin\AdminReservedAppointmentsController;
use App\Http\Controllers\admin\AdminAppointmentSectionController;
use App\Exports\TestExports;
use App\Http\Controllers\admin\AdminAccountsController;
use App\Http\Controllers\admin\AdminContractFileController;
use App\Http\Controllers\admin\AdminContractTemplateController;
use App\Http\Controllers\admin\AdminCorporateController;
use App\Http\Controllers\admin\AdminCouponClassificationController;
use App\Http\Controllers\admin\AdminGuardianDebtController;
use App\Http\Controllers\admin\AdminGuardianPointsController;
use App\Http\Controllers\admin\AdminGuardianWalletController;
use App\Http\Controllers\admin\AdminPaymentNetworkController;
use App\Http\Controllers\admin\AdminNoorAccountsController;
use App\Http\Controllers\admin\AdminNoorQueueController;
use App\Http\Controllers\admin\AdminSchoolController;
use App\Http\Controllers\admin\AdminTransferRequestController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\AdminWithdrawalApplicationController;
use App\Http\Controllers\admin\AdminWithdrawalPeriodController;
use App\Http\Controllers\guardian\GuardianChildrenController;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('reset-password', [AdminResetPassword::class, 'resetPasswordSendSmsCode'])->name('reset_password');
Route::post('reset-password', [AdminResetPassword::class, 'resetPasswordBySmsCode'])->name('change_password');
Route::get('confirm-code', [AdminResetPassword::class, 'confirmCodeChangePasswordPage'])->name('get.confirm_code');
Route::post('confirm-code', [AdminResetPassword::class, 'confirmCodeChangePassword'])->name('confirm_code');

Route::group(['middleware' => ['auth']], function () {


    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('home');

    Route::get('/students/participation', function () {
        return view('admin.participation.index');
    })->name('participation');

    Route::get('/setting/mainData', function () {
        return view('admin.settings.mainData');
    })->name('setting.mainData');

    Route::get('/setting/main', function () {
        return view('admin.settings.general');
    })->name('setting.users');

    Route::post('/json/{methodName}', [AdminJsonController::class, 'index']);

    Route::prefix('users')->group(function () {
        Route::post('admins/assignAdminRole', [AdminController::class, 'assignAdminRole'])->name('admins.assignAdminRole');
        Route::resource('users', AdminUserController::class);
        Route::resource('admins', AdminController::class)->only('index','destroy');
        Route::resource('AttendanceManagers', AdminAttendanceManageController::class);
        Route::resource('ApplicationManagers', AdminApplicationManageController::class);
        Route::resource('teachers', AdminTeacherController::class)->only('index','destroy');
        Route::resource('guardians', AdminGuardianController::class)->only('index','destroy');
        Route::get('resendToOdoo', [AdminGuardianController::class, 'storeParentInOdoo'])->name('users.resendToOdoo');
        Route::resource('guardians.wallets', AdminGuardianWalletController::class);
        Route::resource('guardians.points', AdminGuardianPointsController::class)->only('index');
    });

    Route::prefix('setting')->group(function () {

        Route::post('corporates/switch', [AdminCorporateController::class,'switch'])->name('corporates.switch');
        Route::resource('corporates', AdminCorporateController::class);
        Route::resource('schools', AdminSchoolController::class);
        Route::resource('roles', AdminRoleController::class);
        Route::resource('years', AdminAcademicYearController::class);
        Route::resource('years.semesters', AdminSemesterController::class);
        Route::resource('years.periods', AdminPeriodController::class);
        Route::resource('years.withdrawalPeriods', AdminWithdrawalPeriodController::class);
        Route::resource('years.periods.discounts', AdminDiscountController::class);
        Route::get('years/{year}/classrooms/{classroom}/students', [AdminClassRoomController::class,'students'])->name('years.classrooms.students.view');
        Route::post('years/{year}/classrooms/{classroom}/store_students', [AdminClassRoomController::class,'StoreStudents'])->name('years.classrooms.students.store');
        Route::resource('years.classrooms', AdminClassRoomController::class);

        Route::get('coupons/report', [AdminCouponsController::class, 'discount_report'])->name('coupons.discount_report');
        Route::resource('coupons/classifications', AdminCouponClassificationController::class);
        Route::resource('coupons', AdminCouponsController::class);
        Route::resource('transportations', AdminTransportationController::class);
        Route::resource('types', AdminTypeController::class);
        Route::resource('genders', AdminGenderController::class);
        Route::resource('grades', AdminGradeController::class);
        Route::match(['get', 'post'],'levels/{level}/nextLevel', [AdminLevelController::class,'nextLevel'])->name('levels.nextLevel');
        Route::resource('levels', AdminLevelController::class);
        Route::resource('levels.subjects', AdminSubjectController::class);
        Route::resource('countries', AdminCountryController::class);
        Route::resource('nationalities', AdminNationalityController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('plans', AdminPlanController::class);
        Route::resource('noorAccounts', AdminNoorAccountsController::class);
        Route::resource('banks', AdminBankController::class);
        Route::resource('payment_networks', AdminPaymentNetworkController::class);
        Route::resource('contract_terms', AdminContractTermsController::class);
        Route::get('contract_design', [AdminContractTemplateController::class,'edit'])->name('contract_design.edit');
        Route::post('contract_design', [AdminContractTemplateController::class,'update'])->name('contract_design.update');
    });

    // Withdrawals routes
    Route::resource('withdrawals', AdminWithdrawalApplicationController::class);

    // applications routes
    Route::match(['post', 'put'], 'applications/meetingInfo', [AdminApplicationController::class, 'meeting_info'])->name('applications.meeting');
    Route::match(['post', 'put'], 'applications/meetingresult', [AdminApplicationController::class, 'meeting_result'])->name('applications.meeting_result');
    Route::post('applications/updateapplicationstatus', [AdminApplicationController::class, 'updateapplicationstatus'])->name('applications.updateapplicationstatus');
    Route::match(['post', 'get'], 'applications/{id}/confirm_application', [AdminApplicationController::class, 'confirm_application'])->name('applications.confirm_application');
    Route::get('transactions/unconfirmedpayment', [AdminPaymentAttemptController::class, 'UnConfirmedPayment'])->name('attempts.unconfirmed');

    Route::get('accounts/cash_flow', [AdminAccountsController::class,'index'])->name('accounts.index');
    Route::resource('accounts/debts', AdminGuardianDebtController::class)->except(['edit','update','destroy']);
    Route::resource('applications', AdminApplicationController::class);
    Route::get('students/exam_results', [AdminContractController::class, 'showStudentExsamResutls'])->name('students.show_exam_result');
    Route::post('students/exam_results', [AdminContractController::class, 'storeStudentExsamResutls'])->name('students.store_exam_result');
    Route::get('students/resendToOdoo', [AdminStudentController::class, 'storeStudentInOdoo'])->name('students.resendToOdoo');
    Route::resource('students', AdminStudentController::class)->except('create','store');
    Route::get('students.contracts.all', [AdminContractController::class, 'getAllContracts'])->name('contracts.all');
    Route::get('contracts.resendToOdoo', [AdminContractController::class, 'storeInvoiceInOdoo'])->name('contracts.resendToOdoo');
    Route::resource('students/noor', AdminNoorQueueController::class)->only('create','store');
    Route::resource('students.contracts', AdminContractController::class);
    Route::resource('students.contracts.files', AdminContractFileController::class)->only('index', 'create', 'store', 'destroy');
    Route::resource('students/contracts/transfers', AdminTransferRequestController::class);
    Route::resource('students.contracts.transactions', AdminTransactionController::class);
    Route::resource('students.contracts.transportations', AdminStudentTransportationController::class);
    Route::resource('students.contracts.transactions.attempts', AdminPaymentAttemptController::class);
    Route::get('attempts/resendToOdoo', [AdminPaymentAttemptController::class, 'storePaymentInOdoo'])->name('attempts.resendToOdoo');
    Route::get('attempts/resendInversePaymentToOdoo', [AdminPaymentAttemptController::class, 'storeInversePaymentInOdoo'])->name('attempts.resendInversePaymentToOdoo');
    Route::get('reports/students', [AdminContractController::class,'show_student_report']);
    Route::resource('student/permissions', AdminStudentPermissionController::class)->only(['index', 'destroy', 'update']);
    Route::get('student/StudentAttendances/report/{class_id}', [AdminStudentAttendanceController::class, 'getStudentAttendanceReports'])->name('StudentAttendances.reports');

    Route::get('student/StudentAttendances/details/{report_id}', [AdminStudentAttendanceController::class, 'getStudentAttendanceDetails'])->name('StudentAttendances.details');
    Route::resource('student/StudentAttendances', AdminStudentAttendanceController::class);

    Route::get('student/StudentParticipations/reports/{class_id}', [AdminStudentParticipationController::class, 'getStudentClassRoomParticipationReports'])->name('StudentParticipations.reports');

    Route::get('student/StudentParticipations/details/{report_id}/{class_id}', [AdminStudentParticipationController::class, 'getStudentParticipationDetails'])->name('StudentParticipations.details');

    Route::post('student/StudentParticipations/details/update', [AdminStudentParticipationController::class, 'updateStudentParticipationDetails'])->name('StudentParticipations.details.update');

    Route::resource('student/StudentParticipations', AdminStudentParticipationController::class);


    // reports
    Route::get('reports/application_report', [AdminReportsController::class, 'application_report'])->name('reports.applications');
    Route::get('reports/permissions_report', [AdminReportsController::class, 'permissions_report'])->name('reports.permissions');
    Route::get('reports/attandance_report', [AdminReportsController::class, 'attandance_report'])->name('reports.attandance');

    Route::get('/test', [HomeController::class, 'test_discount']);
    Route::get('/testpaymrnt', [TransactionController::class, 'test_discount']);


    //Transaction
    Route::match(['post', 'put'], 'payment_attempt/confirm-transaction', [AdminPaymentAttemptController::class, 'confirmTransaction'])->name('paymentattempt.confirm');
    Route::match(['post', 'put'], 'payment_attempt/refuse-transaction', [AdminPaymentAttemptController::class, 'refuseTransaction'])->name('paymentattempt.refuse');


    Route::get('/profile', [AdminController::class, 'getAdminProfile'])->name('admin.profile');

    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::resource('sections', AdminAppointmentSectionController::class);
        Route::resource('offices', AdminAppointmentOfficeController::class);
        Route::resource('offices.days', AdminOfficeScheduleController::class);
        Route::resource('reserved', AdminReservedAppointmentsController::class);
    });

    Route::prefix('parent')->name('parent.')->group(function () {
        Route::get('showChildrens', [GuardianChildrenController::class, "showChildrens"])->name("showChildrens");
        Route::get('childrenDetails', [GuardianChildrenController::class, "getChildrenDetails"])->name("childrenDetails");
        Route::get('contractTransaction', [GuardianChildrenController::class, "getContractTransaction"])->name("contractTransaction");
        Route::post('transactionPaymentAttempt', [GuardianChildrenController::class, "transactionPaymentAttempt"])->name("transactionPaymentAttempt");
        Route::post('sendPayfortRequest', [GuardianChildrenController::class, "sendPayfortRequest"])->name("sendPayfortRequest");
    });

    Route::post('parent/student/{student_id}/transaction/{transaction_id}', [TransactionController::class, 'update_transactions']);

});

