<?php

namespace App\Http\Controllers\Api\v1;

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
        $this->middleware('api-version');
        $this->middleware('auth:api');
    }

    /**
     * @SWG\Get(
     *     path="/api/users",
     *     summary="Show users profile",
     *     tags={"User Profile"},
     *     description="Show users profile",
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Bearer token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="application/json",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="return user data",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthenticated",
     *     ),
     * )
     */


    /**Return auth user data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $userData = User::with('programs')->findOrFail($user);
        return response()->json(['success' => $userData], 200);
    }

    /**
     * @SWG\Put(
     *     path="/api/users",
     *     summary="Edit users profile",
     *     tags={"Edit users Profile"},
     *     description="Show users profile",
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
     *     @SWG\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="application/json",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="return user data",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthenticated",
     *     ),
     * )
     *
     * Update users date
     * @param ProfileUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    protected function update(ProfileUpdateRequest $request)
    {
//        $userData = User::with('programs')->findOrFail($id);
        $userData = Auth::user();
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
