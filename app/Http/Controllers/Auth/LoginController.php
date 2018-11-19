<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    use RedirectsUsers, ThrottlesLogins;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Login $request)
    {
        $user = User::where('email', $request['email'])->first();
        $passwordIsVerified = password_verify($request['password'], $user['password']);

        if (!$user) {
            return back()->with('login_error', 'User not found');
        }

        if (!$passwordIsVerified) {
            return back()->with('login_error', 'Wrong password');
        }

        $this->guard()->login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
