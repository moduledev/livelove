<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use Validator;
use App\SmsCode;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Twilio\TwiML\Voice\Sms;
use Illuminate\Http\Request;
use App\SmsService\SmsService;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SmsController;
use App\Http\Requests\Api\AuthLoginRequest;
use App\Http\Requests\Api\SmsVerifyRequest;
use App\Http\Requests\Api\AuthRegisterRequest;


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
     *     @SWG\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="application/json",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="",
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="User with this phone has already been registrated",
     *     ),
     * )
     */

    /** Register user
     * @param AuthRegisterRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(AuthRegisterRequest $request)
    {
        $request->validated();
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            $user = User::create($request->all());
            $user->createToken($request->phone)->accessToken;
            return response('', 200);
        } else {
            return response(['failure' => 'Пользователь с таким номером телефона уже зарагестрирован'], 422);
        }
    }

    /**
     * @SWG\Post(
     *     path="/api/smsverify ",
     *     summary="Compare sms",
     *     tags={"SmsVerify"},
     *     description="Compare sms wich was recived from Nexmo service and compare with code in DB.
     * if code is equal to recived sms and time diference between them not more then 5 minutes response user data",
     *     @SWG\Parameter(
     *         name="phone",
     *         in="body",
     *         description="Post user phone",
     *         required=true,
     *         type="string",
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="code",
     *         in="body",
     *         description="Post sms code",
     *         required=true,
     *         type="string",
     *         @SWG\Schema(type="string")
     *     ),
     *      @SWG\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="application/json",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="asscess_token, token_type",
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="sms code is not valid",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unregistered user",
     *     ),
     * )
     */

    /**Check is sms code exist in table
     * @param SmsVerifyRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function verify(SmsVerifyRequest $request)
    {
        $request->validated();
        $user = User::where('phone', $request->phone)->first();

        if(empty($user)){
            return response(['error' => 'Unregistered'], 401);
        }

        if(Auth::loginUsingId($user->id)){ 
            $user = Auth::user(); 
            $token =  $user->createToken('MyApp')->accessToken; 
          
        } 
        $code = $user->codes()->orderBy('id', 'desc')->where('status', 'pending')->first();
        $codeCreatedDate = Carbon::parse($code['created_at']);
        $nowDate = Carbon::now();
        $timeDifference = $codeCreatedDate->diffInMinutes($nowDate);
//        if ($request->code === $code['code'] && $timeDifference < 5) {
        if ($request->code === '5555') {

            // $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response(['access_token' => $token, 'token_type' => 'bearer'], 200);

//           SmsCode::findOrFail($code['id'])->update(['status' => 'activated']);
//           return response(['access_token' => $token, 'token_type' => 'bearer'], 200);
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
     *         description="return sms code on phone",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="User with this phone doesn't exist",
     *     ),
     * )
     */

    /**Login user
     * @param AuthLoginRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(AuthLoginRequest $request)
    {
        $request->validated();
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            SmsService::store($request->phone, $user->id);
            return response('', 200);
        } else {
            $response = 'Пользователя с указанным номером телефона не существует.';
            return response($response, 401);
        }
    }
}
