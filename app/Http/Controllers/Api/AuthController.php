<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelpers;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'credential' => 'required|string|max:100',
            'password' => 'required|min:6',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'error' => $validator->errors()->all()
            ]);
        }

        $user = User::where('email',$request->credential)->orWhere('username', $request->credential)->first();
        if(!$user){
            $error = 'User does not exist';
            return ApiHelpers::validation($error);
        }
        if (Hash::check($request->password, $user->password)) {
            if($user->status != 1){
                $error = 'Account Has been Suspended or Disbaled';
                return ApiHelpers::validation($error);
            }
            $user->save();
            $user['first_name'] = ($user->fname);
            $user['last_name'] = ($user->lname);
            $token = $user->createToken('User App Token')->plainTextToken;
            $user['kyc_status'] = ($user->kyc_status);
            $user['virtual_banks'] = json_decode($user->virtual_banks);
            $user['profile_picture'] = my_asset($user->image);
            return response()->json([
                'status' => 'success',
                'message' => "User Login Successful",
                'token' => $token,
                'user' => $user
            ]);

        } else {
            $error = 'Incorrect Password. Please Check and try again';
            return ApiHelpers::error($error);
        }

    }
    
    public function signup(Request $request){
        $request->validate([
            'first_name' => 'string|required|max:100',
            'last_name' => 'string|required|max:100',
            'email' => 'email|unique:users|string|required',
            'username' => 'string|unique:users|min:5|max:20|required|regex:/\w*$/|alpha_dash',
            'phone' => 'required|string|numeric|min:10|unique:users,phone',
            'password' =>'required|string|min:8',
        ]);
        $username = formatAndValidateUsername($request->username);
        if (!$username) {
            return response()->json([
                'status' => "error",
                "message" => 'Invalid Username. Please change and try again'
            ]);
        }

        if($request->referral_code){
            $refer = User::whereUsername($request->referral_code)->first();
            if($refer == null){
                return response()->json([
                    "status"=>"error",
                    "message" =>'Invalid referral link. Please check and try again.'
                ]);
            }
        }
        // Create user
        $user = new User();
        $user->lname = $request->last_name;
        $user->fname = $request->first_name;
        $user->name = $request->first_name .' '.$request->last_name;
        $user->username = $username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_role = 'user';
        $user->wm = 0;
        $user->password = Hash::make($request['password']);
        $user->ref_id = isset($request->referral_code) ?  $refer->id : 0;
        $user->email_verified_at = date('Y-m-d H:m:s');
        $user->api_token = generateToken();
        $user->save();
        // welcome boonus
        if(\sys_setting('is_welcome_bonus') == 1){
            give_welcomet_bonus($user->id);
        }

        auth()->login($user);
        event(new Registered($user));

        $token = $user->createToken('User App Token')->plainTextToken;
        $user['first_name'] = ($user->fname);
        $user['last_name'] = ($user->lname);
        $user['virtual_banks'] = json_decode($user->virtual_banks);
        $user['profile_picture'] = my_asset($user->image);
        return response()->json([
            'status' => 'success',
            'message' => "User Registered Successful",
            'token' => $token,
            'user' => $user
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => "success",
            'user' => Auth::user(),
            'token' => Auth::refresh(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
