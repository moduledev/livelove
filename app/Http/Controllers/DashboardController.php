<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Program;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display main dashboard page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->count();
        $programs = Program::all()->count();
        return view('admin.dashboard.index', compact('users','programs'));
    }

    /**
     * Display users page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function users()
    {
        if (Auth::user()->hasPermissionTo('user-list')) {
            $users = DB::table('users')->paginate(5);
            return view('admin.users.index', compact('users'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    /**
     * Display admins page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function admins()
    {
        if (Auth::user()->hasPermissionTo('admin-list')) {
            $admins = Admin::with('roles')->paginate(5);
            $roles = Role::all();
            return view('admin.admins.index', compact('admins', 'roles'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    /**
     * Display programs page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function programs()
    {
        if (Auth::user()->hasPermissionTo('program-list')) {
            $programs = Program::paginate(5);
            return view('admin.programs.index', compact('programs'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }

    /**
     * Display roles page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function roles()
    {
        if (Auth::user()->hasPermissionTo('role-list')) {
            $roles = Role::paginate(5);
            return view('admin.roles.index', compact('roles'));
        } else {
            return redirect()->back()->with('error', 'У Вас нет прав для выполнения этой операции');
        }
    }
}
