<?php

namespace App\Http\Controllers;

use App\User;
use App\Program;
use Illuminate\Http\Request;
use Validator;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-list', ['only' => ['show']]);
        $this->middleware('permission:program-edit', ['only' => ['assignProgram']]);
        $this->middleware('permission:program-delete', ['only' => ['removeProgram']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }


    public function edit(Request $request)
    {
        //
        $id = filter_var($request->id, FILTER_SANITIZE_NUMBER_INT);
        $user = User::findOrFail($id);
        $userPrograms = $user->programs()->get();
        $programs = Program::all();
        return view('admin.users.edit', compact('user','programs','userPrograms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());  
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'phone' => 'string|min:9',
            'biography' => 'max:1000',
            'position' => 'max:255',
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 422);

        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $userData = User::findOrFail($id);
        if($userData){
            $request->name ? $userData->name = filter_var($request->name, FILTER_SANITIZE_SPECIAL_CHARS) : $userData->name;
            $request->phone ? $userData->phone = filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT) : $userData->phone;
            $request->biography ? $userData->biography = htmlspecialchars($request->biography ): $userData->biography;
            $request->position ? $userData->position = filter_var($request->position, FILTER_SANITIZE_SPECIAL_CHARS) : $userData->position;
            if ($request->hasFile('image')) {
                if ($userData->image) unlink(storage_path('app/public/'.$userData->image));
                $path = $request->file('image')->store('users', 'public');
                $userData->image = $path;
            }
            $userData->save();
            return redirect()->back()->with('success','Данные пользователя ' . $userData->name . ' были успешно обновлены!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $userId = filter_var($request->id, FILTER_SANITIZE_NUMBER_INT);
        $user = User::findOrFail($userId);
        if($user->image) unlink(storage_path('app/public/'.$user->image));
        $user->delete();
        return redirect()->back()->with('success','Пользователь ' . $user->name . ' был успешно удален!');
    }

    public function assignProgram(Request $request)
    {
        $userId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $program = filter_var($request->program, FILTER_SANITIZE_SPECIAL_CHARS);
        $programs = User::findOrFail($userId)->programs()->get();
        $programExist = $programs->where('id',$program);
        if(!count($programExist) > 0){
            User::findOrFail($userId)->programs()->attach($program);
            return redirect()->back()->with('success', 'Программа была успешно добавлена!');
        } else {
            return redirect()->back()->with('error', 'Пользователью уже была добавлена программа!');
        }

    }

    public function removeProgram(Request $request)
    {
        $userId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $program = filter_var($request->program, FILTER_SANITIZE_SPECIAL_CHARS);
        $user = User::findOrFail($userId)->programs()->detach($program);
        return redirect()->back()->with('success', 'Программа была успешно удалена!');
    }
}
