<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\SmsController;
use App\SmsCode;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{

    /** Register user
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
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

        if (!$user) {
            $user = User::create($request->toArray());
            $sms->store($request->phone, $user->id);
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['token' => $token];
            return response($response, 200);
        } else {
            return response('User with this phone is already exists', 422);
        }

    }

    /**Check is sms code exist in table
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:9',
        ]);

        $user = $request->user();
        $code = User::findOrFail($user->id)->codes()->orderBy('id', 'desc')->where('status', 'pending')->first();

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 422);
        $codeCreatedDate = Carbon::parse($code['created_at']);
        $now = Carbon::now();
        $timeDifference = $codeCreatedDate->diffInMinutes($now);
        if ($request->code === $code['code'] && $timeDifference < 5) {
            SmsCode::findOrFail($code['id'])->update(['status' => 'activated']);
            return response($user, 200);
        } else {
            return response('Error check sms code', 422);
        }
    }

    /**Login user
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        $sms = new SmsController();

        if ($user) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $sms->store($request->phone, $user->id);
            $response = ['token' => $token];
            return response($response, 200);
        } else {
            $response = 'User does not exist';
            return response($response, 422);
        }
    }
}
