<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DelhiveryController;
use App\Http\Controllers\RemittanceController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EcomeController;
use App\Http\Controllers\WebhookController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/demo', function () {
    return view('welcome');
});

Route::get('term-conditions', function () {
    return view('termconditions');
})->name('term-conditions');

Route::get('policy', function () {
    return view('policy');
})->name('policy');

Route::get('shipingPolicy', function () {
    return view('shipingPolicy');
})->name('shipingPolicy');

Route::get('refundPolicy', function () {
    return view('refundPolicy');
})->name('refundPolicy');

Route::get('/', function () {
    return view('welcome_live');
});

Route::post('query', [FrontendController::class, 'query'])->name('query');
Route::post('contact/{id}', [HomeController::class, 'query_delete']);

Auth::routes();

Route::resource('remittance',RemittanceController::class);
/* home */
Route::get('/home', [HomeController::class, 'index'])->name('home');
/* order */
Route::resource('order',OrderController::class);

Route::post('updateOrdersStatus', [DelhiveryController::class, 'updateOrdersStatus'])->name('updateOrdersStatus');
/* role */
Route::resource('role',RoleController::class);
Route::resource('permission',PermissionController::class);
Route::resource('pincode',PincodeController::class);
/* user */
Route::get('customer', [UserController::class, 'customer'])->name('user.customer');

Route::post('orderstatus/{id}', [DelhiveryController::class, 'orderstatus']);
Route::get('orderprint/{id}', [DelhiveryController::class, 'orderprint'])->name('orderprint');
Route::get('delhivery/get_status/{awb}',[WebhookController::class,'getStatusDV']);
Route::get('ecom_express/get_status/{awb}',[WebhookController::class,'getStatusEC']);
//======= create whare house
Route::post('createWharehouse', [DelhiveryController::class, 'createWharehouse'])->name('createWharehouse');

Route::get('calculate', [DelhiveryController::class, 'calculate'])->name('calculate');

/* ======== user profile ===== */
Route::resource('user',UserController::class);
Route::get('profile/{id}', [UserController::class, 'profile']);
Route::post('updateupdate', [UserController::class, 'updateupdate'])->name('updateupdate');
Route::post('changepassword', [UserController::class, 'changepassword'])->name('user.changepassword');
Route::post('shppingcharge', [UserController::class, 'shppingcharge'])->name('shppingcharge');

//====payment=========
Route::resource('payment',TransactionController::class);

Route::resource('setPayment',PaymentController::class);

//================= setting ==================
Route::match(['get', 'post'],'setting', [SettingController::class, 'index'])->name('setting');

//================= ecome   =================
Route::get('calculationEcome', [EcomeController::class, 'calculationEcome'])->name('calculationEcome');
Route::post('updateEcomePincode', [EcomeController::class, 'updateEcomePincode'])->name('updateEcomePincode');

//========== auto update======
Route::post('/delhivery/track_order',[WebhookController::class,'updateDelhiveryOrder']);
Route::post('/ecom_express/track_order',[WebhookController::class,'updateEcomOrder']);

Route::post('/delhivery/cancel/{awb}',[WebhookController::class,'cancelDelhiveryOrder']);
Route::post('/ecom_express/cancel/{awb}',[WebhookController::class,'cancelEcomOrder']);
