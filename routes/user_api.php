<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillsController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ResellController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// User Auth
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('reset-password', [ResetPasswordController::class, 'reset_password']);
});

// User Profile
Route::prefix('user')->controller(UserController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/profile', 'profile');
    Route::get('generate-account', 'generate_account');
    Route::get('logout', 'logout');
    Route::post('/profile-image', 'update_profile_image');
    Route::put('/profile', 'update_profile');
    Route::put('/update-password', 'update_password');
    Route::get('referrals', 'referrals');
    Route::get('banks', 'banks');
    Route::post('verify-kyc', 'verify_kyc');
    // deposit
    Route::post('deposit', 'makeDeposit');
    Route::get('deposits', 'deposits');
    // Transactions
    Route::get('transactions', 'transactions');

});

// Support Tickets
Route::controller(SupportController::class)->middleware('auth:sanctum')->prefix('tickets')->group(function () {
    Route::get('/{slug?}', 'user_tickets');
    Route::post('/create', 'create_ticket');
    Route::get('/viewticket/{slug}', 'ticket_details');
    Route::post('/comment/{id}', 'user_comment');
});

// Services
Route::controller(OrderController::class)->middleware('auth:sanctum')->prefix('services')->group(function () {
    Route::get('/categories', 'all_categories');
    Route::get('/category/{id}', 'category_services');
    Route::get('/{id?}', 'services');
});
// Orders
Route::controller(OrderController::class)->middleware('auth:sanctum')->prefix('orders')->group(function () {
    Route::get('/', 'get_orders');
    Route::get('/{id}', 'get_order');
    Route::get('/type/{type?}', 'get_orders');
    Route::post('/create', 'create_order');
});
// Settings
Route::controller(SettingController::class)->prefix('settings')->group(function () {
    Route::get('/', 'settings');
});
// Bills Payment
Route::controller(BillsController::class)->middleware('auth:sanctum')->prefix('bills')->as('bills.')->group(function () {
    Route::get('/networks', 'networks')->name('networks');
    Route::post('/airtime', 'buy_airtime')->name('airtime');

    Route::post('/data', 'buy_data')->name('data');
    Route::get('/data/plans', 'data_plans')->name('data.plans');

    Route::get('/cables', 'cables')->name('cable');
    Route::get('/cable/plans', 'cable_plans')->name('cable.plans');
    Route::post('/cable/validation', 'cable_validation')->name('cable.validation');
    Route::post('/cable', 'buy_cable')->name('cable.buy');

    Route::get('/powers', 'powers')->name('powers');
    Route::post('/power', 'buy_electricity')->name('power.buy');
    Route::post('/power/validation', 'power_validation')->name('power.validation');

    Route::get('/betplans', 'betplans')->name('betting');
    Route::post('/bet', 'buy_bet')->name('bet.buy');
    Route::post('/bet/validation', 'bet_validation')->name('bet.validation');
});

// Panel  APis
Route::controller(ResellController::class)->prefix('resell-api')->group(function () {
    Route::post('/admin-login', 'adminLogin');
    Route::get('/stats', 'panelStats');
});
