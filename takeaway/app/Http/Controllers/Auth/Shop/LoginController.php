<?php

namespace App\Http\Controllers\Auth\Shop;

use App\Http\Controllers\Shop\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * Shop Admin Login
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';
            
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:shop')->except('logout');
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password') + array(
            'shop_id' => $this->shop->id,
            'user_type' => \App\User::UT_SHOP_ADMIN
        );
    }

    protected function guard() {
        return Auth::guard('shop');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.shop.login')->with('title', 'Login');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect(route('shop.login'));
    }
}
