<?php
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\HomeController;
// use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\Admin\RoleController;
// use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\EmailChecksController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\StatusController;


use App\Http\Controllers\Admin\{AttendanceController,
    StudentBatchController , StudentKachaController  ,StudentController  ,StaffPaymentController ,
    EventController  , NotificationController , StudentFeeController, AccountingController ,AccountingCategoryController ,
    StudentExportController , FeeExportController ,ProfileController ,BatchController ,RoleController ,UserController,HomeController,AccountExportController
} ;
// use App\Http\Controllers\Admin\StudentBatchController;
// use App\Http\Controllers\Admin\StudentKachaController;
// use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\LoginSecurityController;
// use App\Http\Controllers\Admin\StaffPaymentController;
// use App\Http\Controllers\Admin\EventController;
// use App\Http\Controllers\Admin\NotificationController;
// use App\Http\Controllers\Admin\StudentFeeController;
// use App\Http\Controllers\Admin\AccountingController;
// use App\Http\Controllers\Admin\AccountingCategoryController;
// use App\Http\Controllers\Admin\StudentExportController;
// use App\Http\Controllers\Admin\FeeExportController;
// use App\Http\Controllers\Admin\ProfileController;




// Route::prefix('admin')->group(function () {
//     Route::get('/', 'AdminController@index')->name('admin.dashboard');
//     Route::get('/users', 'AdminController@users')->name('admin.users');
//     // Add more admin routes here
// });
 
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');




// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix'=>'2fa-authenticate'], function(){
    Route::get('/',[LoginSecurityController::class ,'show2faForm'])->name('enable2FaForm');
    Route::post('/generateSecret',[LoginSecurityController::class ,'generate2faSecret'])->name('generate2faSecret');
    Route::post('/enable2fa',[LoginSecurityController::class ,'enable2fa'] )->name('enable2fa');
    Route::post('/disable2fa',[LoginSecurityController::class ,'disable2fa'] )->name('disable2fa');

    // 2fa middleware
    Route::post('/verifyRedirect-redirect',[LoginSecurityController::class ,'verifyRedirect2Fa'] 

    // Route::post('/2faVerify', function () {
    //     return redirect(URL()->previous());
    )->name('2faVerify')->middleware('2fa');
});

Route::get('drop2fa/{email}',[LoginSecurityController::class ,'drop2fa']);
Route::get('new-authentication/{user}',[LoginSecurityController::class ,'sendMailToNew2F'])->name('new-2fa');
Route::get('new-authentication/{id}/confirm',[LoginSecurityController::class ,'sendMailToNew2Fconfirm'])->name('new-2fa-confrm');
Route::post('check-email',[EmailChecksController::class ,'emailCheckExists'])->name('email.exists');
Route::post('load-batches',[GeneralController::class ,'loadBatches'])->name('load.batches');


Route::middleware(['auth:admin','admin','2fa'])->group(function () {

Route::prefix('admin')->group(function () {
Route::get('/profile', [ProfileController::class, 'viewProfile'])->name('admin.profile');

    
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
// Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('home');
Route::resource('users', UserController::class);

Route::get('/student-fees/manage', [StudentFeeController::class, 'manage'])->name('admin.student-fees.manage');
Route::post('/get-student-info', [StudentFeeController::class, 'studentInfo'])->name('admin.get-student-info');
// Route::post('/preview-installment-info', [StudentFeeController::class, 'previewInstallmentInfo'])->name('admin.preview-installment-info');
Route::post('/get-next-payment', [StudentFeeController::class, 'nextPayment'])->name('admin.nextpayment');
Route::post('/save-fee-payment', [StudentFeeController::class, 'saveFeePayment'])->name('admin.save-fee-payment');



Route::resource('student-fees', StudentFeeController::class)->except(['create']);
// Route::resource('staff-attendance',AttendanceController::class)->only(['index']);
Route::get('student-attendance', [AttendanceController::class, 'index'])->name('student.attendance.index');
Route::get('staff-attendance', [AttendanceController::class, 'index'])->name('staff.attendance.index');

Route::resource('roles', RoleController::class);
Route::resource('staff-payments', StaffPaymentController::class);
Route::post('get-staff-payment',[StaffPaymentController::class, 'staffPaymentInfo'] )->name('admin.get-staff-payment');
Route::get('events/calendar', [EventController::class, 'showCalendar'])->name('events.calendar');
Route::post('get-event-info', [EventController::class, 'getEventInfo'])->name('get-event-info');
Route::resource('events', EventController::class);
Route::resource('notifications', NotificationController::class);
Route::resource('accounting', AccountingController::class) ;
Route::any('accounting/{accounting}/restore', [AccountingController::class, 'restore'])->name('accounting.restore');

Route::any('accounting-categories/{accountingCategory}/restore', [AccountingCategoryController::class, 'restore'])->name('accounting-categories.restore');
Route::resource('accounting-categories', AccountingCategoryController::class) ;



// Route::get('users/data', 'UserController@data')->name('users.data');
Route::get('users/data', [UserController::class, 'data'])->name('users.data');
Route::post('users/manange-auth', [UserController::class, 'manage2FaAuth'])->name('admin.change_authentication');


Route::get('/staffs', [UserController::class, 'staffListing'])->name('staffs.index');
Route::get('/staffs/create', [UserController::class, 'staffCreate'])->name('staffs.create');
Route::post('/staffs/store', [UserController::class, 'staffStore'])->name('staffs.store');
Route::get('/staffs/{user}', [UserController::class, 'staffShow'])->name('staffs.show');
Route::get('/staffs/edit/{staff_id}', [UserController::class, 'staffEdit'])->name('staffs.edit');
Route::put('/staffs/{staff}', [UserController::class, 'staffUpdate'])->name('staffs.update');
Route::get('/staffs/staffs', [UserController::class, 'data'])->name('staffs.data');

Route::put('/staffs/destroy', [UserController::class, 'staffDestroy'])->name('staffs.destroy');

//Route::resource('batches', BatchController::class);
Route::post('batches/store', [BatchController::class,'store'])->name('batches.store');
Route::resource('batches', BatchController::class)->except(['edit','update','store']);


Route::get('batches/{batch}/edit', [BatchController::class, 'edit'])->name('batches.edit');
Route::any('batches/update/{batch}', [BatchController::class, 'update'])->name('batches.update');


Route::post('status/update', [StatusController::class, 'update'])->name('status.update');

Route::resource('students', StudentController::class)->except(['show','edit','update']);
Route::get('students/{user}', [StudentController::class, 'show'])->name('students.show');
Route::get('students/{user}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('students/{user}', [StudentController::class, 'update'])->name('students.update');


Route::get('students/data', [StudentController::class, 'data'])->name('students.data');
Route::post('save-student-rfid/{user}', [StudentBatchController::class, 'saveStudentRFID'])->name('save.student.rfid');
Route::post('save-student-batch', [StudentBatchController::class, 'saveStudentBatch'])->name('save.student.batch');
Route::post('save-student-kacha', [StudentKachaController::class, 'saveStudentKatcha'])->name('save.student.kacha');

Route::get('/student-export', [StudentExportController::class, 'export'])->name('export.student');
Route::get('/fee-export', [FeeExportController::class, 'export'])->name('export.fee');
Route::get('/accounting-export', [AccountExportController::class, 'export'])->name('export.accounting');
});
Route::get('/change-password', function () {
    return view('change-password');
})->name('change-password');

Route::post('users/update-password', [UserController::class, 'updatePassword'])->name('update-password');
});
