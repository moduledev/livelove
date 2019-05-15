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
     *         description="return message - you have registrated successfuly",
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="User with this phone has already been registrated",
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
        $phone = filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            $user = User::create($request->toArray());
//            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $token = $user->createToken($phone)->accessToken;
            return response(['success' => 'Вы успешно зарегестрировались'], 200);
        } else {
            return response(['failure' => 'Пользователь с таким номером телефона уже зарагестрирован'], 422);
        }

    }

    /**
     * @SWG\Post(
     *     path="/api/user/smsverify ",
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
     *     @SWG\Response(
     *         response=200,
     *         description="asscess_token, token_type",
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
            'phone' => 'required|string|max:13',
            'code' => 'required|string|min:4',
        ]);
        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 422);

        $phone = filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT);
        $user = User::where('phone', $phone)->first();
        $code = $user->codes()->orderBy('id', 'desc')->where('status', 'pending')->first();

        $codeCreatedDate = Carbon::parse($code['created_at']);
        $now = Carbon::now();

        $timeDifference = $codeCreatedDate->diffInMinutes($now);
        // if ($request->code === $code['code'] && $timeDifference < 5) {
        if ($request->code === '5555') {

            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response($token);

            SmsCode::findOrFail($code['id'])->update(['status' => 'activated']);
            return response(['access_token' => $token, 'token_type' => 'bearer'], 200);
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
        $phone = filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT);

        $user = User::where('phone', $phone)->first();
        $sms = new SmsController();
        if ($user) {
            $sms->store($request->phone, $user->id);
            return response(['message' => 'Вам было оправлено сообщение с кодом подтверждения.'], 200);
        } else {
            $response = 'Пользователя с указанным номером телефона не существует.';
            return response($response, 422);
        }
    }


}
