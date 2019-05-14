<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function removePermission(Request $request)
    {
        if (Auth::user()->hasPermissionTo('permission-revoke')) {
            $roleId = filter_var($request->role, FILTER_SANITIZE_NUMBER_INT);
            $permission = filter_var($request->permission, FILTER_SANITIZE_SPECIAL_CHARS);
            $role = Role::findOrFail($roleId);
            $role->revokePermissionTo($permission);
            return redirect()->back()->with('success', 'Роль ' . $permission . ' была успешно удалена!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    public function assignPermission(Request $request)
    {
        if (Auth::user()->hasPermissionTo('permission-assign')) {
            if($request->permission === 'Выберите permission') return redirect()->back();

            $roleId = filter_var($request->role, FILTER_SANITIZE_NUMBER_INT);
            $permission = filter_var($request->permission, FILTER_SANITIZE_SPECIAL_CHARS);
            $role = Role::findOrFail($roleId);
            if($role->hasPermissionTo($permission)) return redirect()->back()->with('warning', 'Permission ' . $permission . ' уже была добавлена!');
            $role->givePermissionTo($permission);
            return redirect()->back()->with('success', 'Permission ' . $permission . ' была успешно добавлена!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }
}
