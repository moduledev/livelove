<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ProfileUpdateRequest;
use App\Http\Requests\ProgramStoreRequest;
use App\Program;
use App\Traits\StoreImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Http\Requests\ProgramUpdateRequest;

class ProgramController extends Controller
{
    use StoreImageTrait;

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
        $program = new Program;
        $program->fill($request->validated());
        $program->image = $this->storeImage($request, 'image');
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
        $program = Program::findOrFail($id);
        return view('admin.programs.edit', compact('program'));
    }

    public function updateProgram(ProgramUpdateRequest $request, $id)
    {
        $programData = Program::findOrFail($id);
        if(!is_null($programData->image)) unlink(storage_path(Program::PHOTOPATH . $programData->image));
        $programData->fill($request->validated());
        $programData->image = $this->storeImage($request, 'image');
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
        $validator = Validator::make($request->all(), [
            'id' => 'integer',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back();
        }
        $id = $request->id;

        Program::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Программа была успешно удалена!');
    }
}
