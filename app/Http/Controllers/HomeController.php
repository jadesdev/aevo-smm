<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Faq;
use App\Models\GeneralUser;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Str;

class HomeController extends Controller
{
    protected $theme;

    public function __construct()
    {
        switch (sys_setting('homepage_theme')) {
            case 'theme1':
                $this->theme = 'front.';
                break;
            case 'theme2':
                $this->theme = 'front2.';
                break;
            case 'theme3':
                $this->theme = 'front3.';
                break;
            case 'theme4':
                $this->theme = 'front4.';
                break;
            default:
                $this->theme = 'front.';
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $faqs = Faq::whereStatus(1)->get();

        return view($this->theme.'index', compact('faqs'));
    }

    public function services(Request $request)
    {
        $categoriz = Category::has('services')->whereStatus(1)->orderBy('name', 'asc')->get();
        $categories = Category::has('services')->whereStatus(1)->orderBy('name', 'asc')->paginate(100);
        if ($request->has('category')) {
            $categories = Category::has('services')->whereStatus(1)->orderBy('name', 'asc')->whereId($request->category)->get();
            if ($request->category == '') {
                $categories = Category::has('services')->whereStatus(1)->orderBy('name', 'asc')->get();
            }
        }

        // $categories = Category::has('services')->whereStatus(1)->orderBy('name','asc')->paginate(500);
        $search = null;
        // if($request->has('search')){

        // }

        return view($this->theme.'services', compact('search', 'categories', 'categoriz'));
    }

    public function api_docs()
    {
        return view($this->theme.'apidocs');
    }

    public function faq()
    {
        $faqs = Faq::whereStatus(1)->get();

        return view($this->theme.'faq', compact('faqs'));
    }

    public function terms()
    {
        return view($this->theme.'terms');
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }

    public function old_user_function(Request $request)
    {
        $oldusers = GeneralUser::all();
        foreach ($oldusers as $item) {
            // check user
            $checkuser = User::whereEmail($item['email'])->first();
            if ($checkuser) {
                continue;
            }
            $user = new User;
            $user->lname = $item['last_name'];
            $user->fname = $item['first_name'];
            $user->name = $user->fname.' '.$user->lname;
            $user->username = formatAndValidateUsername($item->first_name).Str::random(4);
            $user->email = $item->email;
            $user->balance = $item->balance;
            $user->user_role = 'user';
            $user->password = Hash::make($item['email']);
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->api_token = $item['api_key'];
            $user->save();

            // return $user;
        }

        return redirect()->route('index')->withSuccess('Users Imported Successfully');
    }

    // PAYMENT PAGE
    public function paymentSuccess()
    {
        return view('pay.success');
    }

    public function paymentError()
    {
        return view('pay.error');
    }

    public function maintenance()
    {
        if (sys_setting('is_maintenance') != 1) {
            return to_route('index');
        }

        return view('maintenance');
    }
}
