<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;


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
        $userId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $userData = User::with('programs')->find($userId);
        if ($userData) {
            return response($userData, 200);
        } else {
            return response('Unregistered user', 401);
        }
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
     */

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'phone' => 'string|min:9',
            'biography' => 'string|max:1000',
            'position' => 'string|max:255',
            'image' => 'file'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 422);

        $userId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $userData = User::with('programs')->find($userId);

        if ($userData) {
            $request->name ? $userData->name = filter_var($request->name, FILTER_SANITIZE_SPECIAL_CHARS) : $userData->name;
            $request->phone ? $userData->phone = filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT) : $userData->phone;
            $request->biography ? $userData->biography = filter_var($request->biography, FILTER_SANITIZE_SPECIAL_CHARS) : $userData->biography;
            $request->position ? $userData->position = filter_var($request->position, FILTER_SANITIZE_SPECIAL_CHARS) : $userData->position;

            if ($request->hasFile('image')) {
                if ($userData->image) unlink(storage_path('app/public/'.$userData->image));
                $path = $request->file('image')->store('users', 'public');
                $userData->image = $path;
            }

            $userData->save();
            return response('Users date has been updated', 200);
        } else {
            return response('Unregistered user', 401);
        }
    }

    public function delete($id)
    {
        $userId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $user = User::findOrFail($userId)->first();
        if ($user) {
            if ($user->image) unlink(storage_path('app/public/'.$user->image));
            $user->delete();
            return response('User ' . $user->name . ' has been deleted', 200);
        } else {
            return response('Unregistered user', 401);
        }
    }

}
