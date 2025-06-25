<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Back\AdminController;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/blocked', [App\Http\Controllers\ResellController::class, 'panelBlocked'])->name('blocked');
Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return \Illuminate\Support\Facades\Artisan::call('queue:retry all');
});
// quework
Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

// Cron job
Route::get('/cron-job', [App\Http\Controllers\CronController::class, 'initCronjob'])->name('cron');

Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login')->middleware('guest');
Route::get('admin-panel-login/{code}', [AdminController::class, 'loginFromPanel'])->name('admin.panel.login')->middleware('guest');

Route::get('/maintenance', [App\Http\Controllers\HomeController::class, 'maintenance'])->name('maintenance');
// Maintenence mode

Route::middleware('maintenance')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'user_login'])->name('login');
    Route::prefix('auth')->group(function () {
        Auth::routes(['verify' => true]);
    });
    Route::get('auth/login', [App\Http\Controllers\Auth\LoginController::class, 'user_login']);
    Route::post('/auth/login', [App\Http\Controllers\Auth\LoginController::class, 'submit_login'])->name('signin');
    // Register
    Route::controller(RegisterController::class)->middleware('reseller')->group(function () {
        Route::get('/signup', 'user_signup')->name('signup');
        Route::get('auth/register', 'user_signup')->name('register');
        Route::post('/signup', 'register')->name('signup');
    });

    Route::post('/currency-change', [App\Http\Controllers\CurrencyController::class, 'currency_change'])->name('currency');

    Route::controller(HomeController::class)->middleware('reseller')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/home', 'index')->name('home');
        Route::get('/logout', 'logout')->name('logout');
        // front pages
        Route::get('/api', 'api_docs')->name('api_docs');
        Route::get('/faq', 'faq')->name('faq');
        Route::get('/services', 'services')->name('services');
        Route::get('/terms', 'terms')->name('terms');
        Route::get('/old-users', 'old_user_function')->name('olduser');
    });

    Route::middleware('auth', 'user', 'verified','reseller')->prefix('user')->as('user.')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/dashboard', 'index')->name('dashboard');
            Route::get('/profile', 'profile')->name('profile');
            Route::post('/profile', 'update_profile')->name('profile');
            Route::get('generate-apikey', 'generate_apikey')->name('apikey');
            Route::post('password', 'update_password')->name('password');
            Route::get('/logout', 'logout')->name('logout');
            Route::get('/close-message', 'close_message')->name('close-message');
            Route::post('/verify-kyc', 'verify_kyc')->name('verify-kyc');

            Route::get('/services', 'services')->name('services');
            Route::get('/generate-account', 'generate_account')->name('generate_acc');
            Route::any('/addfunds', 'deposit')->name('deposit');
            Route::post('/deposit-bank', 'manual_deposit')->name('deposit.bank');
            Route::post('/deposit-confirm', 'deposit_money')->name('deposit.confirm');
            Route::get('/api', 'api_docs')->name('api');
            Route::get('/affiliates', 'affiliate')->name('affiliate');
            Route::post('/add-bank-account', 'bank_account')->name('withdraw.bank');
            Route::post('/withdraw', 'affiliate_withdraw')->name('withdraw');
            Route::post('/point-withdraw', 'point_withdraw')->name('withdraw.point');
            Route::get('/faq', 'faq')->name('faq');
            Route::get('/terms', 'terms')->name('terms');
            Route::get('/transaction', 'transactions')->name('transaction');
            Route::get('/transactions', 'transactions')->name('transactions');
            // delete account
            Route::post('/delete-account', 'deleteAccount')->name('delete-account');
        });
        // Orders
        Route::controller(OrderController::class)->prefix('orders')->as('orders.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/pending', 'pending')->name('pending');
            Route::get('/processing', 'processing')->name('processing');
            Route::get('/in-progress', 'inprogress')->name('inprogress');
            Route::get('/completed', 'completed')->name('completed');
            Route::get('/partial', 'partial')->name('partial');
            Route::get('/canceled', 'canceled')->name('canceled');
            Route::post('/', 'place_order')->name('store');

            // Ajax requests
            Route::get('/get-services', 'get_services')->name('get-services');
            Route::get('/service-form', 'show_service_form')->name('service-form');
        });
        // support system
        Route::controller(SupportController::class)->prefix('tickets')->group(function () {
            Route::get('/', 'user_tickets')->name('tickets');
            Route::post('/create', 'create_ticket')->name('ticket.create');
            Route::get('/viewticket/{slug}', 'ticket_detail')->name('ticket.detail');
            Route::post('/comment/{id}', 'user_comment')->name('ticket.comment');
            Route::post('/close/{id}', 'close_ticket')->name('ticket.close');
        });
        // Bills Payment
        Route::controller(BillsController::class)->prefix('bills')->as('bills.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/airtime', 'airtime')->name('airtime');
            Route::post('/airtime', 'buy_airtime')->name('airtime');
            Route::get('/data', 'data')->name('data');
            Route::post('/data', 'buy_data')->name('data');
            Route::get('/data/plans', 'data_plans')->name('data.plans');
            Route::get('/cable', 'cable')->name('cable');
            Route::get('/cable/plans', 'cable_plans')->name('cable.plans');
            Route::get('/cable/discount', 'cable_discount')->name('cable.discount');
            Route::post('/cable/validation', 'cable_validation')->name('cable.validation');
            Route::post('/cable', 'buy_cable')->name('cable.buy');
            Route::get('/electricity', 'electricity')->name('power');
            Route::post('/electricity', 'buy_electricity')->name('power.buy');
            Route::get('/power/plans', 'power_plans')->name('power.plans');
            Route::get('/power/discount', 'power_discount')->name('power.discount');
            Route::post('/power/validation', 'power_validation')->name('power.validation');
            // betting
            Route::get('/betting', 'betting')->name('bet');
            Route::post('/betting', 'buy_bet')->name('bet.buy');
            Route::post('/bet/validation', 'bet_validation')->name('bet.validation');
        });
        // listings
        Route::controller(DealController::class)->prefix('listings')->as('listings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/product/{slug}', 'view')->name('view');
            Route::get('/add', 'add')->name('add');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/edit/{id}', 'update')->name('edit');
            Route::post('/add', 'create')->name('add');
            Route::post('/buy', 'buy_now')->name('buy');
            Route::post('/make-offer', 'make_offer')->name('offer');
            Route::get('/deals', 'my_deals')->name('deals');
            Route::get('/wallet', 'wallet')->name('wallet');
            Route::get('/details/{id}', 'account_details')->name('details');
            Route::get('/deals/offers/{id}', 'deals_offer')->name('deals.offer');
            Route::get('/my-offers', 'my_offers')->name('my_offers');
            Route::get('/bought-accounts', 'my_accounts')->name('my_account');
            Route::get('/accounts/view/{id}', 'view_account')->name('account.view');
            Route::get('/offers/view/{id}', 'seller_view_offer')->name('offers.view');
            Route::get('/offer/view/{id}', 'view_offer')->name('offer.view');
            Route::get('/offer/accept/{id}', 'accept_offer')->name('offer.accept');
            Route::get('/offer/reject/{id}', 'reject_offer')->name('offer.reject');

            Route::post('/withdraw', 'withdraw')->name('withdraw');
            Route::post('/offer/payment/{id}', 'offer_payment')->name('offer.payment');
            Route::post('/offer/comment/s/{id}', 'seller_offer_comment')->name('offer.s.comment');
            Route::post('/offer/comment/b/{id}', 'buyer_offer_comment')->name('offer.b.comment');
            Route::post('/offer/confirm/s/{id}', 'seller_offer_confirmation')->name('offer.s.confirm');
            Route::post('/offer/confirm/b/{id}', 'buyer_offer_confirmation')->name('offer.b.confirm');
        });
    });
});

// Payment Page
Route::controller(HomeController::class)->group(function () {
    Route::get('/payment-error', 'paymentError')->name('pay.error');
    Route::get('/payment-success', 'paymentSuccess')->name('pay.success');
});
// Payment routes
Route::controller(PaymentController::class)->group(function () {
    Route::any('/paystack/success/', 'paystack_success')->name('paystack.success');
    Route::any('/flutter/success/', 'flutter_success')->name('flutter.success');
    Route::any('/monnify/success/', 'monnify_success')->name('monnify.success');
    Route::any('/paypal/success/', 'paypal_success')->name('paypal.success');
    Route::any('/perfectmoney-success', 'perfect_success')->name('perfect.success');
    Route::any('/coinbase-success', 'coinbase_success')->name('coinbase.success');
    Route::any('/monnify/listings/', 'monnify_listings')->name('monnify.listings');
    Route::any('/webhook/binance-notification/', 'binance_webhook')->name('binance.webhook');
    Route::any('/monnify/success/listings', 'listing_monnify_success')->name('monnify.success.listing');
    Route::any('/heleket-success', 'heleket_success')->name('heleket.success');
    Route::any('moorle-success', 'moorle_success')->name('moorle.success');
    Route::any('moorle-webhook', 'moorle_webhook')->name('moorle.webhook');
});
// Monify webhook
Route::any('/webhook/monnify-transact/', [App\Http\Controllers\PaymentController::class, 'monnify_webhook'])->name('monnify.webhook');
// API Payment IPN
