<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo() {
        $user = Auth::user();

        switch ($user->user_type) {
            case User::UT_SHOP_USER:
                return '/user/dashboard';

            case User::UT_SHOP_ADMIN:
                return '/admin/dashboard';
            
            // case User::UT_SITE_ADMIN:
            //     return '/manage/dashboard';

            default:
                return '/';
        }
    }
    
    /**
     * Get the needed authorization credentials from the request.
     * override parent method from: AuthenticatesUsers
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password', 'shop_id');
    }
}