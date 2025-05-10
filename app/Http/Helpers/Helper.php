<?php

use App\Mail\MainEmail;
use App\Models\Currency;
use App\Models\Order;
use App\Models\PaymentBonus;
use App\Models\PointLog;
use App\Models\Setting;
use App\Models\SystemSetting;
use App\Models\Transaction;
use App\Models\User;

if (! function_exists('static_asset')) {
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/assets/'.$path, $secure);
    }
}
// return file uploaded via uploader
if (! function_exists('my_asset')) {
    function my_asset($path, $secure = null)
    {
        return app('url')->asset('public/uploads/'.$path, $secure);
    }
}

if (! function_exists('get_setting')) {
    function get_setting($key = null)
    {
        $settings = Cache::get('Settings');

        if (! $settings) {
            $settings = Setting::first();
            Cache::put('Settings', $settings, 300);
        }

        if ($key) {
            return @$settings->$key;
        }

        return $settings;
    }
}

if (! function_exists('sys_setting')) {
    function sys_setting($key, $default = null)
    {
        $settings = Cache::get('SystemSettings');

        if (! $settings) {
            $settings = SystemSetting::all();
            Cache::put('SystemSettings', $settings, 30);
        }
        $setting = $settings->where('name', $key)->first();

        return $setting == null ? $default : $setting->value;
    }
}

function text_trim($string, $length = null)
{
    if (empty($length)) {
        $length = 100;
    }

    return Str::limit($string, $length, '...');
}
function text_trim2($string, $length = null)
{
    if (empty($length)) {
        $length = 8;
    }

    return Str::limit($string, $length, '');
}

function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}
// Create slug
function uniqueSlug($name, $model)
{
    $slug = Str::slug($name);
    $allSlugs = checkRelatedSlugs($slug, $model);
    if (! $allSlugs->contains('slug', $slug)) {
        return $slug;
    }

    $i = 1;
    $is_contain = true;
    do {
        $newSlug = $slug.'-'.$i;
        if (! $allSlugs->contains('slug', $newSlug)) {
            $is_contain = false;

            return $newSlug;
        }
        $i++;
    } while ($is_contain);
}
function checkRelatedSlugs($slug, $model)
{
    return DB::table($model)->where('slug', 'LIKE', $slug.'%')->get();
}

function get_trx_type($status)
{
    switch ($status) {
        case 1:
            return '<span class="badge bg-success">credit</span>';
            break;
        case 2:
            return '<span class="badge bg-warning">debit</span>';
            break;
        default:
            return '<span class="order-status os-pending">credit</span>';
    }

}

function get_status($status)
{
    switch ($status) {
        case 1:
            return '<span class="badge bg-success">Enabled</span>';
            break;
        case 0:
            return '<span class="badge bg-danger">Disabled</span>';
            break;
        case 2:
            return '<span class="badge bg-danger">Disabled</span>';
            break;
        default:
            return '<span class="badge bg-warning">unknown</span>';
    }

}
function get_trx_status($status)
{
    switch ($status) {
        case 1:
            return '<span class="badge bg-success">successful</span>';
            break;
        case 2:
            return '<span class="badge bg-warning">pending</span>';
            break;
        case 3:
            return '<span class="badge bg-danger">cancelled</span>';
            break;
        case 4:
            return '<span class="badge bg-info">refunded</span>';
            break;
        default:
            return '<span class="badge bg-secondary">unknown</span>';
    }

}
function payment_gateway($name)
{
    if ($name == 'perfect') {
        return 'perfect money';
    }

    return $name;
}
function get_ticket_status($status)
{
    switch ($status) {
        case 1:
            return '<span class="order-status">Answered</span>';
            break;
        case 2:
            return '<span class="order-status os-pending">Pending</span>';
            break;
        case 3:
            return '<span class="order-status os-cancel">Solved</span>';
            break;
        case 4:
            return '<span class="badge bg-info">refunded</span>';
            break;
        default:
            return '<span class="badge bg-secondary">unknown</span>';
    }

}

function list_status($status)
{
    switch ($status) {
        case 1:
            return '<span class="bg-success badge">Sold</span>';
            break;
        case 2:
            return '<span class="badge bg-primary">available</span>';
            break;
        case 3:
            return '<span class="badge bg-warning">processing</span>';
            break;
        default:
            return '<span class="badge bg-secondary">unknown</span>';
    }

}

function publish_status($status)
{
    switch ($status) {
        case 1:
            return '<span class="bg-success badge">published</span>';
            break;
        case 2:
            return '<span class="badge bg-warning">pending</span>';
            break;
        case 3:
            return '<span class="badge bg-danger">draft</span>';
            break;
        default:
            return '<span class="badge bg-secondary">unknown</span>';
    }

}

function listoffer_status($status)
{
    switch ($status) {
        case 'accepted':
            return '<span class="bg-success badge">Accepted</span>';
            break;
        case 'pending':
            return '<span class="badge bg-warning">pending</span>';
            break;
        case 'rejected':
            return '<span class="badge bg-danger">rejected</span>';
            break;
        default:
            return "<span class='badge bg-secondary'>{$status}</span>";
    }

}
function get_order_status($status)
{

    switch ($status) {
        case 'pending':
            $result = '<span class="order-status os-pending">Pending</span>';
            break;
        case 'processing':
            $result = '<span class="order-status os-processing">Processing</span>';
            break;
        case 'inprogress':
            $result = '<span class="order-status os-iprogress">In Progress</span>';
            break;
        case 'completed':
            $result = '<span class="order-status">Completed</span>';
            break;
        case 'partial':
            $result = '<span class="order-status os-partial">Partial</span>';
            break;
        case 'canceled':
            $result = '<span class="order-status os-cancel">Canceled</span>';
            break;
        case 'refunded':
            $result = '<span class="order-status">Refunded</span>';
            break;
        default:
            $result = '<span class="badge bg-info">'.$status.'</span>';
            break;
    }

    return $result;

}
function get_payout_status($status)
{
    switch ($status) {
        case 1:
            return '<span class="order-status">PAID</span>';
            break;
        case 2:
            return '<span class="order-status os-pending">Pending</span>';
            break;
        case 3:
            return '<span class="order-status os-cancel">Rejected</span>';
            break;
        case 4:
            return '<span class="badge bg-info">refunded</span>';
            break;
        default:
            return '<span class="badge bg-secondary">unknown</span>';
    }

}

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function getAmount($amount, $length = 2)
{
    $amount = round($amount, $length);

    return $amount + 0;
}

function show_datetime($date, $format = 'd M, Y h:i:s a')
{
    return \Carbon\Carbon::parse($date)->format($format);
}
function show_datetime1($date, $format = 'd M, Y h:ia')
{
    return \Carbon\Carbon::parse($date)->format($format);
}
function show_datetime2($date, $format = 'Y-m-d, h:ia')
{
    return \Carbon\Carbon::parse($date)->format($format);
}
function show_date($date, $format = 'd M, Y')
{
    return \Carbon\Carbon::parse($date)->format($format);
}

function news_date($date, $format = 'd.m.Y')
{
    return \Carbon\Carbon::parse($date)->format($format);
}
function show_time($date, $format = 'h:ia')
{
    return \Carbon\Carbon::parse($date)->format($format);
}

// formats currency
if (! function_exists('format_price')) {
    function format_price($price)
    {
        $fomated_price = number_format($price, 2);
        $currency = get_setting('currency');

        return $currency.$fomated_price;
    }
}
function sym_price($price)
{
    $fomated_price = number_format($price, 2);
    $currency = get_setting('currency_code');

    return $currency.$fomated_price;
}
function format_number($price)
{
    $fomated_price = number_format($price, 2);

    return $fomated_price;
}
function generateToken()
{
    $token = bin2hex(random_bytes(16));

    return $token;
}

function send_post_request($url, $postdata = null)
{

    try {
        $response = Http::asMultipart()->post($url, $postdata)->json();

        return $response;
    } catch (\Exception $e) {
        return [
            'status' => 'failed',
            'message' => $e->getMessage(),
        ];
    }

}

// short code replacer
function shortCodeReplacer($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}

// send Email
function general_email($email, $sub, $mes)
{
    // return $email;
    $data['subject'] = $sub;
    $data['message'] = $mes;
    try {
        Mail::to($email)->send(new MainEmail($data));
    } catch (\Exception $e) {
        // dd($e);
    }
}

function send_emails($email, $sub, $mess, $id = null)
{

    $data['subject'] = $sub;
    $data['message'] = $mess;
    try {
        Mail::to($email)->queue(new MainEmail($data));
    } catch (\Exception $e) {
        // dd($e);
    }

}

function formatAndValidateUsername($username)
{
    // Remove leading and trailing spaces
    $username = trim($username);

    // Replace consecutive spaces with a single space
    $username = preg_replace('/\s+/', ' ', $username);

    // Remove any special characters except underscores and dashes
    $username = preg_replace('/[^a-zA-Z0-9_-]/', '', $username);

    // Convert spaces to underscores
    $username = str_replace(' ', '_', $username);

    // Validate the username length
    if (strlen($username) < 3 || strlen($username) > 20) {
        return false;
    }

    // Validate the username format using a regular expression
    $pattern = '/^[a-zA-Z][a-zA-Z0-9_-]*$/';
    if (! preg_match($pattern, $username)) {
        return false;
    }

    return $username;
}

if (! function_exists('convert_string_number_list_to_array')) {
    function convert_str_number_list_to_array($str)
    {
        $ar = [];
        if (! is_string($str)) {
            return $ar;
        }
        $str = rtrim($str, ',');
        $str = ltrim($str, ',');

        return $ar = explode(',', $str);
    }
}

if (! function_exists('group_by_criteria')) {
    function group_by_criteria($arr, $criteria)
    {
        return array_reduce($arr, function ($accumulator, $item) use ($criteria) {
            $key = (is_callable($criteria)) ? $criteria($item) : $item[$criteria];
            if (! array_key_exists($key, $accumulator)) {
                $accumulator[$key] = [];
            }
            array_push($accumulator[$key], $item);

            return $accumulator;
        }, []);
    }
}

if (! function_exists('array_sort_by_new_key')) {
    function array_sort_by_new_key($array, $new_key)
    {
        $result = [];
        if (is_array($array) && $array) {
            $array_new_keys = array_column($array, $new_key);
            $result = array_combine(array_values($array_new_keys), array_values($array));
        }

        return $result;
    }
}

function percentageIncrease($percentage, $number)
{
    $increase = ($percentage / 100) * ($number * get_setting('currency_rate'));
    $newValue = $number + $increase;

    return $newValue;
}
if (! function_exists('service_type_format')) {
    function service_type_format($type)
    {
        $type = strtolower(str_replace(' ', '_', $type));

        return $type;
    }
}

function error_orders()
{
    return $orders = Order::whereError(1)->count();
}

function give_deposit_bonus($id, $method, $amount)
{
    $user = User::find($id);
    if (! $user) {
        return false;
    }
    $payment_bonus = PaymentBonus::whereMethod($method)->where('amount', '>=', $amount)->whereStatus(1)->first();
    if (! $payment_bonus) {
        return false;
    }
    // calculate bonus and give
    $bonus = ($payment_bonus->percentage / 100) * $amount;

    // create transaction
    $trans = new Transaction;
    $trans->user_id = $user->id;
    $trans->type = 1; // 1- credit, 2- debit, 3-others
    $trans->code = getTrx();
    $trans->message = "Deposit Bonus for funding {$amount}";
    $trans->amount = $bonus;
    $trans->status = 1;
    $trans->charge = 0;
    $trans->service = 'deposit';
    $trans->old_balance = $user->balance;
    $trans->new_balance = $user->balance + $bonus;
    $trans->save();
    // Add User Balance
    $user->balance += $bonus;
    $user->save();
    // send email
    $e_mess = "Hi {$user->username}, <br> A credit transaction of <b>".format_price($trans->amount).'</b> occured on your Account.
    <br> <p> See Below for details of Transactions. </p>
        Amount : '.format_price($trans->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
    general_email($user->email, 'Credit Alert', $e_mess);
    sendUserNotification(
        $user,
        'Deposit Bonus ',
        "You eared {$trans->message}"
    );
    return true;
}

function give_affiliate_bonus($id, $amount)
{
    $user = User::find($id);
    $refer = User::find($user->ref_id);
    $commission = sys_setting('referral_commission') * $amount / 100;
    $trxcode = getTrx(12);
    if ($refer) {
        $refer->bonus = $commission + $refer->bonus;
        $refer->save();
        $refer->transactions()->create([
            'amount' => $commission,
            'user_id' => $refer->id,
            'charge' => 0,
            'old_balance' => $refer->bonus - $commission,
            'new_balance' => $refer->bonus,
            'type' => 1,
            'status' => 1,
            'service' => 'referral',
            'message' => 'Referral Bonus from '.$user->username,
            'code' => $trxcode,
        ]);
        // send email
        $e_mess = "Hi {$refer->username}, <br> A credit Transaction of <b>".format_price($commission).'</b> occured on your Account.
        <br> <p> See Below for details of Transactions. </p>
            Amount : '.format_price($commission)."<br> Details: Referral Bonus from {$user->username} <br> Reference : {$trxcode} <br> Balance: ".format_price($refer->bonus).'<br> Date : '.show_datetime(now());
        general_email($refer->email, 'Credit Alert', $e_mess);

        sendUserNotification(
            $user,
            'Referral Bonus Earned',
            "You earned a referral bonus from {$user->username}"
        );
    }

}

function get_bank_name($code)
{
    $banks = file_get_contents(static_asset('banks.json'));
    $banks = json_decode($banks, true);

    foreach ($banks as $bank) {
        // return $code;
        if ($bank['code'] == $code) {
            return $bank['name'];
        }
    }

    return 'Select Bank';
}

function shortNumber($number)
{
    $abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => ''];
    $display = '0';
    foreach ($abbrevs as $exponent => $abbrev) {
        if (abs($number) >= pow(10, $exponent)) {
            $display = $number / pow(10, $exponent);
            $decimals = ($exponent >= 3 && round($display) < 100) ? 1 : 0;
            $display = number_format($display, $decimals).$abbrev;
            break;
        }
    }

    return $display;
}

function give_welcomet_bonus($id)
{
    $user = User::find($id);
    if (! $user) {
        return false;
    }
    if (sys_setting('is_welcome_bonus') != 1) {
        return false;
    }
    $amount = sys_setting('welcome_bonus') ?? 0;
    if ($amount == 0) {
        return false;
    }
    // create transaction
    $trans = new Transaction;
    $trans->user_id = $user->id;
    $trans->type = 1; // 1- credit, 2- debit, 3-others
    $trans->code = getTrx();
    $trans->message = 'Welcome bonus of '.format_price($amount);
    $trans->amount = $amount;
    $trans->status = 1;
    $trans->charge = 0;
    $trans->service = 'deposit';
    $trans->old_balance = $user->balance;
    $trans->new_balance = $user->balance + $amount;
    $trans->save();
    // Add User Balance
    $user->balance += $amount;
    $user->save();
    // send email
    $e_mess = "Hi {$user->username}, <br> A credit transaction of <b>".format_price($trans->amount).'</b> occured on your Account. <br> Yoou got a boonus for registering with us.
    <br> <p> See Below for details of Transactions. </p>
        Amount : '.format_price($trans->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
    general_email($user->email, 'Credit Alert', $e_mess);

    sendUserNotification(
        $user,
        'Welcome Bonus Earned',
        "You earned a {$trans->message}"
    );
    return true;
}

function giveUserPoint($id, $amount)
{
    $user = User::find($id);
    $pvalue = sys_setting('point_value');
    $prate = sys_setting('point_rate');
    $pcode = sys_setting('point_code');
    // check if point system is enabled
    if (sys_setting('point_system') != 1) {
        return false;
    }
    // check if amount is more than point calue
    if ($amount >= $pvalue) {
        $point = round($amount / $pvalue, 1);
        $user->points += $point;
        $user->save();
        // save point logs
        $log = new PointLog;
        $log->user_id = $id;
        $log->point = $point;
        $log->type = 'credit';
        $log->amount = $amount;
        $log->code = getTrx(14);
        $log->status = 1;
        $log->message = "{$point} {$pcode} earned for spending ".format_price($amount);
        $log->save();

        sendUserNotification(
            $user,
            'New Bonus Earned',
            $log->message
        );
        return true;
    }

}
// currency
function get_all_active_currency()
{
    $key = 'active_currencies';

    return Cache::remember($key, 20, function () {
        return Currency::where('status', 1)->get();
    });
}
function get_default_currency()
{
    return Cache::remember('default_currency', 86400, function () {
        return Currency::where('code', get_setting('currency_code'))->first();
    });
}
function get_system_currency()
{
    if (sys_setting('multi_currency') == 1) {
        if (Session::has('currency')) {
            $code = Session::get('currency');
        } else {
            $code = get_setting('currency_code');
        }
        $currency = Currency::where('code', $code)->first();

        return $currency;
    } else {
        return $currency = Currency::where('code', get_setting('currency_code'))->first();
    }
}

// Convert price to user currency
function convert_price($price)
{
    if (Session::has('currency')) {
        $code = Session::get('currency');
    } else {
        $code = get_setting('currency_code');
    }
    $currency = Currency::where('code', $code)->first();

    // $price = floatval($price) / floatval(get_default_currency()->rate);
    $price = floatval($price) * floatval($currency->rate);

    return $price;
}

function format_amount($price)
{
    if (sys_setting('multi_currency') == 1) {
        $fomated_price = number_format(convert_price($price), 2);
        if (Session::has('currency')) {
            $code = Session::get('currency');
        } else {
            $code = get_setting('currency_code');
        }
        $currency = Currency::where('code', $code)->first();

        return $currency->symbol.$fomated_price;
    } else {
        return format_price($price);
    }
}

// User Notification
function sendUserNotification($user, $title, $message, $link = null)
{
    $user->notify()->create([
        'title' => $title,
        'type' => 'user',
        'message' => $message,
        'url' => $link ?? null,
    ]);
}

function userUnreadNotifications()
{
    $user = Auth::user();
    $key = $user->id . '_notify_count';

    $ticketCount = Cache::remember($key, 30, function () use ($user) {
        return $user->notifys()
            ->where('view', 0)
            ->where('created_at', '>=', now()->subHours(4))
            ->count();
    });

    return $ticketCount ?? 0;
}
