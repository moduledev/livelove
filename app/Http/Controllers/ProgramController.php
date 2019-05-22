<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ProfileUpdateRequest;
use App\Http\Requests\ProgramStoreRequest;
use App\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Requests\ProgramUpdateRequest;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:program-edit', ['only' => ['editProgram', 'updateProgram']]);
        $this->middleware('permission:program-delete', ['only' => ['delete']]);
        $this->middleware('permission:program-create', ['only' => ['storeProgram']]);
        $this->middleware('permission:program-create', ['only' => ['createProgram']]);
        $this->middleware('permission:program-list', ['only' => ['showProgram']]);
    }


    public function createProgram()
    {
        return view('admin.programs.create');
    }

    /**
     * Store program
     * @param ProgramStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProgram(ProgramStoreRequest $request)
    {
        $request->validated();
        $program = new Program;
        $program->title = $request->title;
        $program->description = $request->description;
        $started = Carbon::parse($request->started);
        $finished = Carbon::parse($request->finished);

        if ($started->isPast() !== false) {
            return redirect()->back()->with('started_error', 'Программа не была создана, нельзя установить прошедшую дату!');
        } else if ($started->gt($finished) === true) {
            return redirect()->back()->with('finished_error', 'Программа не была создана, дата завершения не должна быть раньше начальной!');
        } else {
            $program->started = $started;
            $program->finished = $finished;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('program', 'public');
            $program->image = $path;
        }
        $program->save();
        return redirect()->back()->with('success', 'Программа ' . $program->name . ' была успешно создана!');
    }

    /**
     * Show editing page
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProgram($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $program = Program::findOrFail($id);
        return view('admin.programs.edit', compact('program'));
    }

    public function updateProgram(ProgramUpdateRequest $request, $id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $programData = Program::findOrFail($id);
        $programData->fill($request->validated());
        if ($request->hasFile('image')) {
            if (is_null($programData->image)) unlink(storage_path(Program::PHOTOPATH . $programData->image));
            $path = $request->file('image')->store('program', 'public');
            $programData->image = $path;
        }
        $programData->save();
        return redirect()->back()->with('success', 'Программа ' . $programData->name . ' была успешно обновлена!');
    }

    /**
     * Show progran page
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProgram($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $program = Program::with('users')->findOrFail($id);
        return view('admin.programs.show', compact('program'));

    }

    /**
     * Delete program
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = filter_var($request->id, FILTER_SANITIZE_NUMBER_INT);
        Program::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Программа была успешно удалена!');
    }
}
