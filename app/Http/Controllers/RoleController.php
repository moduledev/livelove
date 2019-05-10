<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
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
        $this->validate($request, [
            'role' => 'required',
        ]);
        $name = filter_var($request->role,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // store in the database

        $role = Role::create(['name' => $name,'guard_name' => 'web']);
        return redirect()->back()->with('success', 'Роль ' . $role . ' была успешно добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $role = Role::findOrFail($id);
        $userPermissions = $role->permissions;
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role','permissions','userPermissions'));

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function assignRole(Request $request)
    {
        $adminId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $role = filter_var($request->role, FILTER_SANITIZE_SPECIAL_CHARS);
        $admin = Admin::findOrFail($adminId);
        if($admin->hasRole($role)) return redirect()->back()->with('warning', 'Роль ' . $role . ' уже была добавлена!');
        $admin->assignRole($role);
        return redirect()->back()->with('success', 'Роль ' . $role . ' была успешно добавлена!');
    }

    public function removeRole(Request $request)
    {
        $adminId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $role = filter_var($request->role, FILTER_SANITIZE_SPECIAL_CHARS);
        $admin = Admin::findOrFail($adminId);
        $admin->removeRole($role);
        return redirect()->back()->with('success', 'Роль ' . $role . ' была успешно удалена!');

    }
}
