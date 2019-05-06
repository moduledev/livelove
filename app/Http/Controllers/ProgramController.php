<?php

namespace App\Http\Controllers;

use App\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Validator;

class ProgramController extends Controller
{
    public function __construct()
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

    public function editProgram($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $program = Program::findOrFail($id);
//        dd($program);
        return view('admin.programs.edit', compact('program'));
    }

    public function updateProgram(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'string|max:1000',
            'image' => 'file',
            'started' => 'required',
            'finished' => 'required',
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 422);

        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $programData = Program::findOrFail($id);
        if ($programData) {
            $request->name ? $programData->name = filter_var($request->name, FILTER_SANITIZE_SPECIAL_CHARS) : $programData->name;
            $request->started ? $programData->started = filter_var($request->started, FILTER_SANITIZE_NUMBER_INT) : $programData->started;
            $request->finished ? $programData->finished = filter_var($request->finished, FILTER_SANITIZE_SPECIAL_CHARS) : $programData->finished;
            $request->description ? $programData->description = filter_var($request->description, FILTER_SANITIZE_SPECIAL_CHARS) : $programData->description;
            if ($request->hasFile('image')) {
                if ($programData->image) unlink(storage_path('app/public/' . $programData->image));
                $path = $request->file('image')->store('program', 'public');
                $programData->image = $path;
            }
            $programData->save();
            return redirect()->back()->with('success', 'Программа ' . $programData->name . ' была успешно обновлена!');

        }
    }

}
