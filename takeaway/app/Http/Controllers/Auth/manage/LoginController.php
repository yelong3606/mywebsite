<?php

namespace App\Http\Controllers\Auth\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * Site_Admin Login
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/manage/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest:manage')->except('logout');
    }
            
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password') + array(
            'user_type' => \App\User::UT_SITE_ADMIN
        );
    }

    protected function guard() {
        return Auth::guard('manage')->with('title', 'Login');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.manage.login');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect(route('manage.login'));
    }
}