<?php

namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\ProfileUpdateRequest;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @SWG\Get(
     *     path="/api/users/phone",
     *     summary="Show users profile",
     *     tags={"User Profile"},
     *     description="Show users profile",
     *     @SWG\Parameter(
     *         name="phone",
     *         in="path",
     *         description="User phone",
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


    /**
     * Show users date
     * @param $phone
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); 
        return response()->json(['success' => $user], 200);
        // $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        // $userData = User::with('programs')->where('phone', $phone)->first();
        // if(Auth::loginUsingId($userData->id)){ 
        //     $user = Auth::user(); 
        //     return response()->json('user', 200); 
        // } 
        // if ($userData) {
        //     return response()->json($userData);
        // } else {
        //     return response('Unregistered user', 401);
        // }
    }

    /**
     * @SWG\Post(
     *     path="/api/users/edit/id",
     *     summary="Edit users profile",
     *     tags={"Edit users Profile"},
     *     description="Show users profile",
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Get user id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="Users name",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="phone",
     *         in="body",
     *         description="Users phone",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="biography",
     *         in="body",
     *         description="Users biography",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="position",
     *         in="body",
     *         description="Users position",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="image",
     *         in="body",
     *         description="Users image",
     *         required=false,
     *         type="file",
     *         @SWG\Schema(type="file")
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
     *
     * Update users date
     * @param ProfileUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    protected function update(ProfileUpdateRequest $request, $id)
    {
        $userData = User::with('programs')->findOrFail($id);
        $userData->fill($request->validated());

        if ($request->hasFile('image')) {
            if (is_null($userData->image)) unlink(storage_path(User::PHOTOPATH . $userData->image));
            $path = $request->file('image')->store('users', 'public');
            $userData->image = $path;
        }

        $userData->save();
        return response()->json($userData);
    }

//    public function delete($id)
//    {
//        $userId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
//        $user = User::findOrFail($userId)->first();
//        if ($user) {
//            if ($user->image) unlink(storage_path('app/public/' . $user->image));
//            $user->delete();
//            return response('User ' . $user->name . ' has been deleted', 200);
//        } else {
//            return response('Unregistered user', 401);
//        }
//    }

}
