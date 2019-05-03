<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:role-create', ['only' => ['index']]);
        $this->middleware('auth:admin')->except('create','store');
        $this->middleware('permission:admin-list', ['only' => ['admins']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        // store in the database

        $admins = new Admin;
        $admins->name = filter_var($request->name, FILTER_SANITIZE_SPECIAL_CHARS);
        $admins->email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $admins->password = bcrypt($request->password);
        $admins->save();
        return redirect()->back()->with('success','Администратор ' . $admins->name . ' был успешно добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $admin = Admin::findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate the data
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'string'
        ]);
//        dd($request->all());
        // store in the database
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $admins = Admin::findOrFail($id);
        $admins->name = filter_var($request->name, FILTER_SANITIZE_SPECIAL_CHARS);
        $admins->email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $admins->password = bcrypt($request->password);
        $admins->save();
        return redirect()->back()->with('success','Администратор ' . $admins->name . ' был успешно изменен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adminId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $admin = Admin::findOrFail($adminId);
        if($admin->id !== auth()->id()){
            $admin->delete();
            return redirect()->back()->with('success','Пользователь ' . $admin->name . ' был успешно удален!');
        } else {
            return redirect()->back()->with('error','Администратор не может удалить сам себя!');

        }

    }

    public function users()
    {
        $users = DB::table('users')->paginate(2);
        return view('admin.pages.users',compact('users'));
    }

    public function admins()
    {
        $admins = DB::table('admins')->paginate(5);
        return view('admin.admins.index',compact('admins'));
    }
}
