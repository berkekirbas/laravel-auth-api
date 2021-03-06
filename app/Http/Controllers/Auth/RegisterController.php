<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    /**
    * Create a User
    *
    * @param [string] name
    * @param [string] email
    * @param [string] password
    * @return [string] message
    */

    public function register(Request $request){
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'code'=>400]);
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'isTrader' => false,
            'token' => Str::random(60),
        ]);

        $user->save();

        $user->sendApiConfirmAccount();

        $message['success'] = 'The User Has Been Created Successfully Check Your Email For Login To The System.';

        return response()->json(['message' => $message, 'code' => 201]);
    }
}
