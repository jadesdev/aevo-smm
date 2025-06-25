<?php

use App\Http\Controllers\Back\AdminController;
use App\Http\Controllers\Back\BillsController;
use App\Http\Controllers\Back\DealController;
use App\Http\Controllers\Back\OrderController;
use App\Http\Controllers\Back\SalesController;
use App\Http\Controllers\Back\ServiceController;
use App\Http\Controllers\Back\SettingController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SupportController;
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

Route::middleware('admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/statistics', 'statistics')->name('stats');
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile', 'update_profile')->name('profile');
        Route::get('/logout', 'logout')->name('logout');

        // Payment Bonus
        Route::get('/payment-bonus', 'payment_bonus')->name('bonus');
        Route::post('/payment-bonus', 'create_payment_bonus')->name('bonus.create');
        Route::post('/payment-bonus/edit/{id}', 'edit_payment_bonus')->name('bonus.edit');
        Route::get('/payment-bonus/destroy/{id}', 'delete_payment_bonus')->name('bonus.delete');

        // Withdrawals
        Route::get('/withdrawals', 'withdrawal')->name('withdrawal');
        Route::get('/withdraw/pay/{id}', 'approve_withdrawal')->name('withdraw.pay');
        Route::get('/withdraw/rej/{id}', 'reject_withdrawal')->name('withdraw.reject');

        // Panel Status
        Route::get('/panel-status', 'panel_status')->name('panel.status');
        // point system
        Route::get('/point-system', 'pointSystem')->name('point-system');
    });
    
    // Currency
    Route::controller(CurrencyController::class)->prefix('currency')->as('currency.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/update', 'update')->name('update');
        Route::post('/store', 'store')->name('store');
        Route::post('/update-status', 'updateStatus')->name('update_status');
        Route::post('/update-default', 'updateDefault')->name('update_default');
    });
    // Newsletter
    Route::controller(EmailController::class)->group(function () {
        Route::get('/newsletter', 'newsletter')->name('newsletter');
        Route::post('/newsletter', 'send_newsletter')->name('newsletter');
        Route::get('/newsletter/add', 'add_newsletter')->name('newsletter.add');
        Route::get('/newsletter/edit/{id}', 'edit_newsletter')->name('newsletter.edit');
        Route::post('/newsletter/edit/{id}', 'update_newsletter')->name('newsletter.edit');
        Route::get('/newsletter/delete/{id}', 'delete_newsletter')->name('newsletter.delete');
        Route::get('/newsletter/q', 'queue_emails');
    });
    // Categories
    Route::controller(ServiceController::class)->name('category.')->prefix('category')->group(function () {
        Route::get('/', 'all_categories')->name('index');
        Route::post('store', 'store_category')->name('store');
        Route::get('services/{id}', 'category_services')->name('services');
        Route::get('delete/{id}', 'delete_category')->name('delete');
        Route::get('multiple-activate', 'category_multiple_activate')->name('multiple-activate');
        Route::get('multiple-deactivate', 'category_multiple_deactivate')->name('multiple-deactivate');
        Route::get('multiple-delete', 'category_multiple_delete')->name('multiple-delete');
    });
    Route::controller(ServiceController::class)->name('service.')->prefix('service')->group(function () {
        Route::get('/', 'all_services')->name('index');
        Route::get('add', 'add_service')->name('add');
        Route::get('edit/{id}', 'edit_service')->name('edit');
        Route::post('store', 'store_service')->name('store');
        Route::post('update/{id}', 'update_service')->name('update');
        Route::post('service/store', 'apiServicesStore')->name('api.store');
        Route::post('add', 'addService')->name('add');
        Route::get('status/{id}', 'service_status')->name('status');
        Route::get('api-services/{id}', 'apiServices')->name('api');
        Route::get('get-api-services', 'get_apiServices')->name('get-apiservice');
        Route::get('multiple-activate', 'service_multiple_activate')->name('multiple-activate');
        Route::get('multiple-deactivate', 'service_multiple_deactivate')->name('multiple-deactivate');
        Route::get('multiple-delete', 'service_multiple_delete')->name('multiple-delete');
    });
    // API Providers
    Route::controller(ServiceController::class)->name('provider.')->prefix('api-provider')->group(function () {
        Route::get('index', 'api_providers')->name('index');
        Route::post('store', 'store_provider')->name('store');
        Route::post('edit/{id}', 'edit_provider')->name('edit');
        Route::post('import/{id}', 'import_provider_services')->name('import');
        Route::post('price/{id}', 'provider_price')->name('priceUpdate');
        Route::get('balance/{id}', 'provider_balance')->name('balanceUpdate');
        Route::get('status/{id}', 'provider_status')->name('status');
        Route::get('services/{id}', 'provider_services')->name('services');
        Route::post('service', 'store_provider_service')->name('service.store');
        Route::get('bulk-import', 'provider_bulkimport')->name('bulkimport');
        Route::get('delete/{id}', 'delete_provider')->name('delete');
    });
    // Manage Orders
    Route::controller(OrderController::class)->as('orders.')->prefix('orders')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pending')->name('pending');
        Route::get('/processing', 'processing')->name('processing');
        Route::get('/in-progress', 'inprogress')->name('inprogress');
        Route::get('/completed', 'completed')->name('completed');
        Route::get('/partial', 'partial')->name('partial');
        Route::get('/canceled', 'canceled')->name('canceled');
        Route::get('/error', 'error_orders')->name('error');

        Route::get('/status', 'update_order_status')->name('status');
        Route::get('/details/{id}', 'order_details')->name('details');
        Route::get('/delete/{id}', 'delete_order')->name('delete');
        Route::post('/update/{id}', 'update_order')->name('update');
        Route::post('/balance/{id}', 'update_user_balance')->name('balance');
        Route::get('/settings', 'user_settings')->name('settings');
        Route::get('/resend/{id}', 'resend_order')->name('resend'); // resend orders
    });
    // Users
    Route::controller(UserController::class)->as('users.')->prefix('users')->group(function () {
        Route::get('/', 'users')->name('index');
        Route::get('/downlines', 'user_downlines')->name('downline');
        Route::get('/downline/{id}', 'view_user_downline')->name('viewdown');
        Route::get('/view/{id}', 'view_user')->name('view');
        Route::get('/detail/{id}', 'view_user')->name('detail');
        Route::get('/edit/{id}', 'edit_user')->name('edit');
        Route::get('/verify/{id}', 'verify_user')->name('verify');
        Route::get('/orders/{id}', 'user_withdraw')->name('withdrawals');
        Route::get('/deposits/{id}', 'user_deposit')->name('deposits');
        Route::post('/sendemail/{id}', 'user_sendemail')->name('sendmail');
        Route::get('/login-user/{id}', 'user_login')->name('login');
        Route::get('/transactions/{id}', 'user_trx')->name('transactions');
        Route::get('/delete/{id}', 'delete_user')->name('delete');
        Route::get('/ban/{id}/{status}', 'ban_user')->name('ban');
        Route::post('/edit/{id}', 'update_user')->name('update');
        Route::post('/balance/{id}', 'update_user_balance')->name('balance');
        Route::get('/settings', 'user_settings')->name('settings');
    });
    // Support
    Route::controller(SupportController::class)->as('support.')->prefix('support')->group(function () {
        Route::get('/tickets', 'tickets')->name('tickets');
        Route::get('/tickets/unread', 'unread_tickets')->name('unread_tickets');
        Route::get('/reply/{slug}', 'reply_ticket')->name('reply');
        Route::post('/comment/{id}', 'comment')->name('comment');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/comment/delete/{id}', 'delete_comment')->name('delete_comment');

    });
    // Bills Payment
    Route::controller(BillsController::class)->prefix('bills')->as('bills.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/settings', 'bills_setting')->name('settings');
        Route::get('/api-selection', 'api_selection')->name('api.selection');
        Route::get('/airtime/s/{id}/{status}', 'airtime_status')->name('airtime.status');  // Enable/disable airtime
        Route::post('/airtime/{id}', 'update_airtime')->name('airtime.update');    // Edit Airtime
        Route::get('/airtime', 'airtime')->name('airtime');
        // data
        Route::get('/data', 'internet_data')->name('data');
        Route::get('/data/s/{id}/{status}', 'datasub_status')->name('data.status');
        Route::get('/data/plans/{id}', 'manage_dataplans')->name('data.plans');
        Route::post('/data/plan', 'create_dataplan')->name('dataplan.create');
        Route::post('/data/plan/e/{id}', 'edit_dataplan')->name('dataplan.edit');
        Route::get('/dataplan/s/{id}/{status}', 'dataplan_status')->name('dataplan.status');
        Route::get('/dataplan/destroy/{id}/', 'delete_dataplan')->name('dataplan.delete');
        // cabletv
        Route::get('/cabletv', 'cabletv')->name('cabletv');
        Route::get('/cabletv/s/{id}/{status}', 'cabletv_status')->name('cabletv.status');
        Route::get('/cabletv/plans/{id}', 'manage_cabletvplans')->name('cabletv.plans');
        Route::post('/cabletv/plan', 'create_cabletvplan')->name('cabletv.create');
        Route::post('/cabletv/plan/e/{id}', 'edit_cabletvplan')->name('cabletv.edit');
        Route::get('/cableplan/s/{id}/{status}', 'cableplan_status')->name('cableplan.status');
        Route::get('/cableplan/del/{id}', 'delete_cableplan')->name('cableplan.delete');
        // electricity
        Route::get('/electricity', 'electricity')->name('power');
        Route::get('/power/s/{id}/{status}', 'electricity_status')->name('power.status');
        Route::post('/power/plan', 'create_electricity')->name('power.create');
        Route::post('/power/plan/e/{id}', 'edit_electricity')->name('power.edit');
        Route::get('/power/plan/del/{id}', 'delete_electricity')->name('power.delete');
        // betting
        Route::get('/betting', 'betting')->name('bet');
        Route::get('/betting/s/{id}/{status}', 'bet_status')->name('bet.status');
        Route::post('/betting/plan', 'create_bet')->name('bet.create');
        Route::post('/betting/plan/e/{id}', 'edit_bet')->name('bet.edit');
        Route::get('/betting/plan/del/{id}', 'delete_bet')->name('bet.delete');
    });
    // Pages
    Route::controller(AdminController::class)->as('pages.')->prefix('pages')->group(function () {
        Route::get('/', 'pages')->name('index');
        Route::get('/edit/{id}', 'edit_page')->name('edit');
        Route::post('/edit/{id}', 'update_page')->name('update');
    });
    // FAQs
    Route::controller(AdminController::class)->as('faqs.')->prefix('faqs')->group(function () {
        Route::get('/', 'faqs')->name('index');
        Route::post('/store', 'store_faq')->name('store');
    });
    // Deals
    Route::controller(DealController::class)->as('listing.')->prefix('listing')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pending')->name('pending');
        Route::get('/sold', 'sold')->name('sold');
        Route::get('/details/{id}', 'details')->name('details');
        Route::get('/approve/{id}', 'approve')->name('approve');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/edit/{id}', 'update')->name('update');
    });
    // Reports
    Route::controller(SalesController::class)->group(function () {
        Route::get('/transactions', 'transactions')->name('transactions');
        Route::post('/transaction/{id}', 'update_transaction')->name('transactions.edit');
        Route::get('/deposits', 'deposits')->name('deposit');
        Route::get('/manual-deposits', 'manual_deposits')->name('mdeposit');
        Route::post('/deposits/{id}', 'update_deposit')->name('deposit.edit');
        Route::get('deposit/status', 'deposit_status')->name('deposit.status');
    });
    // Settings
    Route::controller(SettingController::class)->as('setting.')->prefix('settings')->group(function () {
        Route::get('/payment', 'payment')->name('payment');
        Route::get('/features', 'features')->name('features');
        Route::get('/email', 'email')->name('email');
        Route::get('/custom-styles', 'custom_styles')->name('custom');
        Route::get('/', 'index')->name('index');

        Route::post('/update', 'update')->name('update');
        Route::post('/system', 'systemUpdate')->name('sys_settings');
        Route::post('/system/store', 'store_settings')->name('store_settings');
        Route::post('/api-settings', 'api_settings')->name('api_settings');
        Route::post('env_key', 'envkeyUpdate')->name('env_key');
        // News section
        Route::get('/news-section', 'news_setting')->name('news');
        Route::post('/news-section/create', 'news_setting_create')->name('news.create');
        Route::post('/news-section/update/{id}', 'news_setting_update')->name('news.update');
        Route::get('/news-section/delete/{id}', 'news_setting_delete')->name('news.delete');
    });

    Route::get('/some-profit-processes', [AdminController::class, 'some_profit_process']);
    Route::get('/cache-clear', [AdminController::class, 'clearCache'])->name('clear.cache');
});
