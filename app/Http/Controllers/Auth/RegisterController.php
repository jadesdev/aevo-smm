<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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

    protected $theme;

    public function user_signup(Request $request)
    {
        // check if user exists
        if ($request->ref) {
            $user = User::where('username', $request->ref)->first();
            if ($user == null) {
                return redirect()->route('index')->withError('Invalid referral link');
            }
            $refer = $user->username;

            return view($this->theme.'signup', compact('refer'));
        }
        $refer = null;

        return view($this->theme.'signup', compact('refer'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'string|required|max:100',
            'lname' => 'string|required|max:100',
            'email' => 'email|unique:users|string|required',
            'username' => 'string|unique:users|max:20|required|regex:/\w*$/|alpha_dash',
            'phone' => 'required|string|numeric|min:10|unique:users,phone',
            'password' => 'required|string|min:8',
        ]);
        $username = formatAndValidateUsername($request->username);
        if (! $username) {
            return back()->withInput()->withError('Invalid Username. Please change');
        }
        if ($request->referral) {
            $refer = User::whereUsername($request->referral)->first();
            if ($refer == null || $refer->username == null) {
                return back()->withError('Invalid referral link')->withInput();
            }
        }
        $user = new User;
        $user->lname = $request->lname;
        $user->fname = $request->fname;
        $user->name = $request->fname.' '.$request->lname;
        $user->username = $username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_role = 'user';
        $user->wm = 0;
        $user->password = Hash::make($request['password']);
        $user->ref_id = isset($request->referral) ? $refer->id : 0;
        if (sys_setting('verify_email') != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
        }
        $user->api_token = generateToken();
        $user->save();
        auth()->login($user);
        event(new Registered($user));
        // welcome boonus
        if (\sys_setting('is_welcome_bonus') == 1) {
            give_welcomet_bonus($user->id);
        }

        return redirect()->route('user.index')->withSucess('Account Created Successful');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
