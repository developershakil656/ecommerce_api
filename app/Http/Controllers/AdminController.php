<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) 
            return send_response(false,'validation error!',$validator->errors());

        $credentials = $request->only('email','password');
        if (Auth::guard('admin')->attempt($credentials)) {
            
            // config(['auth.current.provider' => 'admin']);

            $admin          = Auth::guard('admin')->user();
            $data['admin']  = $admin;
            $data['token'] = $admin->createToken('AccessToken',['admin'])->accessToken;

            return send_response(true, 'You are successfully logged in.',$data);
        } else {
            return send_response(false, 'email or password are incorrect!',[], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return send_response(true, 'You are successfully logged out Admin.');
    }



    #creator management
    public function creators()
    {
        $creators = User::all();
        return send_response(true,'',$creators);
    }
}
