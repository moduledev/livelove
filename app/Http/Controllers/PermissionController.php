<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Validator;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**Remove permission from role
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removePermission(Request $request)
    {
        if (Auth::user()->hasPermissionTo('permission-revoke')) {
            $validator = Validator::make($request->all(), [
                'role' => 'required|integer',
                'permission' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator);
            }

            $role = Role::findOrFail($request->role);
            $role->revokePermissionTo($request->permission);
            return redirect()->back()->with('success', 'Роль ' . $request->permission . ' была успешно удалена!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    /**Assign permission to role
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignPermission(Request $request)
    {
        if (Auth::user()->hasPermissionTo('permission-assign')) {
            if ($request->permission === 'Выберите permission') return redirect()->back();
            $validator = Validator::make($request->all(), [
                'role' => 'required|integer',
                'permission' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator);
            }

            $role = Role::findOrFail($request->role);
            if ($role->hasPermissionTo($request->permission)) return redirect()->back()->with('warning', 'Permission ' . $request->permission . ' уже была добавлена!');
            $role->givePermissionTo($request->permission);
            return redirect()->back()->with('success', 'Permission ' . $request->permission . ' была успешно добавлена!');
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }
}
