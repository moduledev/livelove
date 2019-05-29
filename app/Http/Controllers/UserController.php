<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\User;
use App\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show user data
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->hasPermissionTo('user-show')) {
            $user = User::findOrFail($id);
            return view('admin.users.show', compact('user'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }


    /**Users edit page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        if (Auth::user()->hasPermissionTo('user-edit')) {
            $id = $request->id;
            $user = User::findOrFail($id);
            $userPrograms = $user->programs()->get();
            $programs = Program::all();
            return view('admin.users.edit', compact('user', 'programs', 'userPrograms'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    /**
     * Update users data
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $userData = User::findOrFail($id);
        $userData->fill($request->validated());

        if ($request->hasFile('image')) {
            if ($userData->image) unlink(storage_path(User::PHOTOPATH . $userData->image));
            $path = $request->file('image')->store('users', 'public');
            $userData->image = $path;
        }
        $userData->save();
        return redirect()->back()->with('success', 'Данные пользователя ' . $userData->name . ' были успешно обновлены!');
    }


    /**Delete user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if (Auth::user()->hasPermissionTo('user-delete')) {
            $validator = Validator::make($request->all(), [
                'id' => 'integer',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator);
            }

            $user = User::findOrFail($request->id);
            if ($user->image) unlink(storage_path('app/public/' . $user->image));
            $user->delete();
            return redirect()->back()->with('success', 'Пользователь ' . $user->name . ' был успешно удален!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    /**Assign program to user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignProgram(Request $request)
    {
        if (Auth::user()->hasPermissionTo('program-assign')) {

            if ($request->program === 'Выберите программу') return redirect()->back();

            $validator = Validator::make($request->all(), [
                'user' => 'integer',
                'program' => 'string',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator);
            }

            $programs = User::findOrFail($request->user)->programs()->get();
            $programExist = $programs->where('id', $request->program);
            if (!count($programExist) > 0) {
                User::findOrFail($request->user)->programs()->attach($request->program);
                return redirect()->back()->with('success', 'Программа была успешно добавлена!');
            } else {
                return redirect()->back()->with('error', 'Пользователью уже была добавлена программа!');
            }

        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    /**
     * Revoke program from user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeProgram(Request $request)
    {
        if (Auth::user()->hasPermissionTo('program-revoke')) {
            $validator = Validator::make($request->all(), [
                'user' => 'integer',
                'program' => 'string',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator);
            }

            User::findOrFail($request->user)->programs()->detach($request->program);
            return redirect()->back()->with('success', 'Программа была успешно удалена!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }
}
