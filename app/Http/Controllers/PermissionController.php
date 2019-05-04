<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:role-edit', ['only' => ['assignPermission']]);
        $this->middleware('permission:role-delete', ['only' => ['removePermission']]);
    }

    public function removePermission(Request $request)
    {
        $adminId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $permission = filter_var($request->permission, FILTER_SANITIZE_SPECIAL_CHARS);
        $admin = Admin::findOrFail($adminId);
        $admin->revokePermissionTo($permission);
        return redirect()->back()->with('success', 'Роль ' . $permission . ' была успешно удалена!');

    }

    public function assignPermission(Request $request)
    {
        $adminId = filter_var($request->user, FILTER_SANITIZE_NUMBER_INT);
        $permission = filter_var($request->permission, FILTER_SANITIZE_SPECIAL_CHARS);
        $admin = Admin::findOrFail($adminId);
        if($admin->hasPermissionTo($permission)) return redirect()->back()->with('warning', 'Роль ' . $permission . ' уже была добавлена!');
        $admin->givePermissionTo($permission);
        return redirect()->back()->with('success', 'Роль ' . $permission . ' была успешно добавлена!');
    }
}
