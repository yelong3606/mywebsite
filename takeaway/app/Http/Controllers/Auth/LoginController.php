<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Shop\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Shop_User Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/';
            
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        parent::__construct();
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password') + array(
            'shop_id' => $this->shop->id,
            'user_type' => \App\User::UT_SHOP_USER
        );
    }
}