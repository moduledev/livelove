<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @SWG\Get(
     *     path="/api/users/id",
     *     summary="Show users profile",
     *     tags={"User Profile"},
     *     description="Show users profile",
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Get user id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Bearer token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="return user data",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unregistered user",
     *     ),
     * )
     */
    public function index($id)
    {
        $userId = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
        $user = User::where('id',$userId)->first();
        if($user){
            return response($user, 200);
        } else {
            return response('Unregistered user', 401);
        }
    }
}
