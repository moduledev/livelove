<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProgramController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth:admin');

    }

    public function removeProgram(Request $request)
    {
        $userId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $program = filter_var($request->program, FILTER_SANITIZE_SPECIAL_CHARS);
        $user = User::findOrFail($userId)->programs()->detach($program);
        return redirect()->back()->with('success', 'Программа была успешно удалена!');
    }
    
}
