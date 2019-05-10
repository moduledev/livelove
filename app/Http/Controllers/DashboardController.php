<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Program;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:program-list', ['only' => ['programs']]);
        $this->middleware('permission:user-list', ['only' => ['users']]);
        $this->middleware('permission:admin-list', ['only' => ['admins']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function users()
    {
        $users = DB::table('users')->paginate(5);

        return view('admin.users.index',compact('users'));
    }

    public function admins()
    {
//        $admins = DB::table('admins')->paginate(5);
        $admins = Admin::with('roles')->paginate(5);
        $roles = Admin::all();
        return view('admin.admins.index',compact('admins','roles'));
    }

    public function programs()
    {
        $programs = Program::paginate(5);

        return view('admin.programs.index',compact('programs'));
    }

    public function roles()
    {
        $roles = Role::paginate(5);
        return view('admin.roles.index',compact('roles'));
    }
}
