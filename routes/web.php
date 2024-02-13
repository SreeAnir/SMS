<?php

use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\LoginSecurityController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeecheckController;

use App\Http\Controllers\EmailChecksController;
// use App\Http\Controllers\StudentApplicationController;
use App\Http\Controllers\{StudentLoginController,EsslController,StudentApplicationController,
    HomeController, TestController };
use App\Http\Controllers\Student\EventController;
use App\Http\Controllers\Student\NotificationController;
use App\Http\Controllers\Student\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/login', function () {
//     return view('login');
// })->name('login');

// Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
 

include 'admin.php';

Route::post('student/login',[StudentLoginController::class ,'authenticate'])->name('student.login');
Route::get('student/logout',[StudentLoginController::class ,'studentLogout'])->name('student.logout');
Route::get('update/attendance', [ EsslController::class, 'fetchLog'])->name('attendance.update');



Auth::routes();

Route::get('new/application',[StudentApplicationController::class ,'newApplication'])->name('application.new');
Route::get('testspeed',[TestController::class ,'testspeed']);

Route::post('application/save', [ StudentApplicationController::class, 'store'])->name('application.store');

Route::get('application/success', [ StudentApplicationController::class, 'success'])->name('application.success');

// // test middleware
// Route::get('/test_middleware', function () {
//     return "2FA middleware work!";
// })->middleware(['auth', '2fa']);
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('web.dashboard');
    Route::get('events', [ EventController::class, 'index'])->name('event.list');
    Route::resource('user-notifications', NotificationController::class)->only(['index']) ;
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/update/dp', [ProfileController::class, 'updateProfilePhoto'] )->name('update.dp');
    Route::get('/check-payment/{enc_fee_log}', [FeecheckController::class, 'checkIfPaymentAvailable'] )->name('checkpay.log');
    Route::get('payment-summary/{enc_fee_log}', [FeecheckController::class, 'paymentSummary'] )->name('payment.summary');

    Route::get('order-create/{enc_fee_log}', [PaymentController::class, 'paymentOrderCreateforLog'] )->name('payment.order-create');
    Route::post('payment-order-create', [PaymentController::class, 'paymentOrderCreateFromForm'] )->name('payment.create.order');
});
Route::get('/event-summary', [HomeController::class, 'eventSummary'])->name('event-summary');
Route::get('/test-email', [TestController::class, 'testEmail']);



Route::get('/payment', [PaymentController::class,'payment'])->name('payment');
Route::get('/payment-curl', [PaymentController::class,'paymentWithCurl'])->name('payment-curl');
Route::get('/handle-payment/success',[PaymentController::class,'paymentSuccess'])->name('payment-success');
Route::get('/handle-payment/cancel',[PaymentController::class,'paymentCancel'])->name('payment-cancel');
Route::get('/handle-payment/declined',[PaymentController::class,'paymentDeclined'])->name('payment-declined');
Route::get('/payment-status/{status}/{order_id?}', [PaymentController::class,'paymentStatus'])->name('payment-status');

