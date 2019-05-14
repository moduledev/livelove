<?php

namespace App\Http\Controllers\auth\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
//        $this->middleware('auth:admin')->except('logout');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
//        if(!Auth::guest()) return redirect(route('dashboard.index'));
        return view('admin.auth.login');
    }
    public function loginAdmin(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect()->intended(route('dashboard.index'));
        }
        // if unsuccessful, then redirect back to the login with the form data
//        dd($request->only('email', 'remember'));
        return redirect('admin/login')->withInput($request->only('email', 'remember'))->withErrors( [
            'password' => 'Неверный пароль',
            'email' => 'Неверный E-mail'
        ]);
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
