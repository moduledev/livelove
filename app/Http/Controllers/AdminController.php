<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except('create');
        $this->middleware('permission:admin-edit', ['only' => ['edit', 'update']]);
    }


    /**
     * Show the form for creating a new admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreRequest $request)
    {
        if (Auth::user()->hasPermissionTo('admin-create')) {
            $admins = new Admin;
            $admins->fill($request->validated());
            $admins->save();
            return redirect()->back()->with('success', 'Администратор ' . $admins->name . ' был успешно добавлен!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    /**
     * Display Admins Data.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->hasPermissionTo('admin-show')) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $admin = Admin::findOrFail($id);
            $adminsDermissions = $admin->getAllPermissions();
            return view('admin.admins.show', compact('admin', 'adminsDermissions'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    /**
     * Show the form for editing the Admins data.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->hasPermissionTo('admin-edit')) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $admin = Admin::findOrFail($id);
            $roles = Role::all();
            $adminsRoles = $admin->roles;
            return view('admin.admins.edit', compact('admin', 'adminsRoles', 'roles'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }


    /**
     * @param AdminUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(AdminUpdateRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->fill($request->validated());
        $admin->save();
        return redirect()->back()->with('success', 'Администратор ' . $admin->name . ' был успешно изменен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->hasPermissionTo('admin-delete')) {
            $adminId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $admin = Admin::findOrFail($adminId);
            if ($admin->id !== auth()->id()) {
                $admin->delete();
                return redirect()->back()->with('success', 'Пользователь ' . $admin->name . ' был успешно удален!');
            } else {
                return redirect()->back()->with('error', 'Администратор не может удалить сам себя!');
            }
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

}
