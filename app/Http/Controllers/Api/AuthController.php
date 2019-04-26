<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\SmsController;
use App\SmsCode;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;


/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="localhost",
 *     basePath="/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Livelove API",
 *         description="Livelove API",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email=""
 *         ),
 *     ),
 * )
 */
class AuthController extends Controller
{

    /**
     * @SWG\Post(
     *     path="/api/register",
     *     summary="Register new user",
     *     tags={"Register"},
     *     description="Register new user",
     *     @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="Post user name",
     *         required=true,
     *         type="string",
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="phone",
     *         in="body",
     *         description="Post user phone",
     *         required=true,
     *         type="string",
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="return token",
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="User with this phone has already been registered",
     *     ),
     * )
     */

    /** Register user
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:9',
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

    /**
     * @SWG\Post(
     *     path="/api/user/smsverify",
     *     summary="Compare sms",
     *     tags={"SmsVerify"},
     *     description="Compare sms wich was recived from Nexmo service and compare with code in DB.
     * if code is equal to recived sms and time diference between them not more then 5 minutes response user data",
     *     @SWG\Parameter(
     *         name="code",
     *         in="body",
     *         description="Post sms code",
     *         required=true,
     *         type="string",
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Bearer <token>",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="return user data",
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="sms code is not valid",
     *     ),
     * )
     */

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

    /**
     * @SWG\Post(
     *     path="/api/login",
     *     summary="Login user",
     *     tags={"Login"},
     *     description="Login user",
     *     @SWG\Parameter(
     *         name="phone",
     *         in="path",
     *         description="Post user phone",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="return user token",
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="User with this phone doesn't exist",
     *     ),
     * )
     */

    /**Login user
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:9',
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
            $response = 'User does not exist';
            return response($response, 422);
        }
    }
}
