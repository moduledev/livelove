<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\SmsController;
use App\SmsCode;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:9',
            'policy' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $user = User::where('phone', $request->phone)->first();
        $sms = new SmsController();

        if ($user) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $sms->store($request->phone, $user->id);
            $response = ['token' => $token];
            return response($response, 200);
        } else {
            $user = User::create($request->toArray());
            $sms->store($request->phone, $user->id);
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['token' => $token];
            return response($response, 200);
        }

    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:9',
        ]);

        $user = $request->user();


        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        if($request->code === '3333'){
            $user = User::where('phone', $request->phone)->first();
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response('code is true', 200);
        }

    }

//    public function login(Request $request)
//    {
//
//        $user = User::where('phone', $request->phone)->first();
//
//        if ($user) {
//            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
//            $response = ['token' => $token];
//            return response($response, 200);
//
//
//        } else {
//            $response = 'User does not exist';
//            return response($response, 422);
//        }
//
//    }


}
