<?php

namespace App\Http\Controllers;

use App\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;

class ProgramController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth:admin');

    }

    public function createProgram(Request $request)
    {
        // validate the data
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'started' => 'required',
            'finished' => 'required',

        ]);
        // store in the database

        $program = new Program;
        $program->name = filter_var($request->name, FILTER_SANITIZE_SPECIAL_CHARS);
        $program->description = filter_var($request->description, FILTER_SANITIZE_SPECIAL_CHARS);
        $program->started = Carbon::parse(filter_var($request->started, FILTER_SANITIZE_SPECIAL_CHARS));
        $program->finished = Carbon::parse(filter_var($request->finished, FILTER_SANITIZE_SPECIAL_CHARS));
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('program', 'public');
            $program->image = $path;

        }
        $program->save();
        return redirect()->back()->with('success', 'Программа ' . $program->name . ' была успешно создана!');
    }

    public function removeProgram(Request $request)
    {
        $userId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $program = filter_var($request->program, FILTER_SANITIZE_SPECIAL_CHARS);
        $user = User::findOrFail($userId)->programs()->detach($program);
        return redirect()->back()->with('success', 'Программа была успешно удалена!');
    }

}
