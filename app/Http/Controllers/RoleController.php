<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
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
        if (Auth::user()->hasPermissionTo('role-create')) {
            $this->validate($request, [
                'role' => 'required',
            ]);
            $name = filter_var($request->role,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // store in the database

            $role = Role::create(['name' => $name,'guard_name' => 'web']);
            return redirect()->back()->with('success', 'Роль была успешно добавлена!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->hasPermissionTo('role-show')) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $role = Role::findOrFail($id);
            $permissions = $role->permissions;
            return view('admin.roles.show',compact('role','permissions'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->hasPermissionTo('role-edit')) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $role = Role::findOrFail($id);
            $userPermissions = $role->permissions;
            $permissions = Permission::all();
            return view('admin.roles.edit', compact('role','permissions','userPermissions'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
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
        // store in the database
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $admins = Admin::findOrFail($id);
        $admins->name = filter_var($request->name, FILTER_SANITIZE_SPECIAL_CHARS);
        $admins->email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $admins->password = bcrypt($request->password);
        $admins->save();
        return redirect()->back()->with('success', 'Администратор ' . $admins->name . ' был успешно изменен!');
    }


    public function destroy(Request $request)
    {
        if (Auth::user()->hasPermissionTo('role-delete')) {
            $role = filter_var($request->id, FILTER_SANITIZE_SPECIAL_CHARS);
            Role::findOrFail($role)->delete();
            return redirect()->back()->with('success', 'Роль ' . $role . ' была успешно удалена!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    public function assignRole(Request $request)
    {
        if (Auth::user()->hasPermissionTo('role-assign')) {
            if($request->role === 'Выберите роль') return redirect()->back();
            $adminId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
            $role = filter_var($request->role, FILTER_SANITIZE_SPECIAL_CHARS);
            $admin = Admin::findOrFail($adminId);
            if($admin->hasRole($role)) return redirect()->back()->with('warning', 'Роль ' . $role . ' уже была добавлена!');
            $admin->assignRole($role);
            return redirect()->back()->with('success', 'Роль  была успешно добавлена!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    public function removeRole(Request $request)
    {
        if (Auth::user()->hasPermissionTo('role-revoke')) {
            $adminId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
            $role = filter_var($request->role, FILTER_SANITIZE_SPECIAL_CHARS);
            $admin = Admin::findOrFail($adminId);
            $admin->removeRole($role);
            return redirect()->back()->with('success', 'Роль ' . $role . ' была успешно удалена!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }
}
