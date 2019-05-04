<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
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
        return view('admin.pages.users',compact('users'));
    }

    public function admins()
    {
        $admins = DB::table('admins')->paginate(5);
        return view('admin.admins.index',compact('admins'));
    }
}
