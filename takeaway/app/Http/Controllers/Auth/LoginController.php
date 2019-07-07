<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Laravel\Socialite\Facades\Socialite;

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
    }

    public function showLoginForm()
    {
        return view('auth.login')->with('title', 'Login');
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password') + array(
            'user_type' => \App\User::UT_SHOP_USER
        );
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // check if they're an existing user
        $existing_user = User::where('user_type', User::UT_SHOP_USER)->where('email', $user->email)->first();
        if($existing_user){
            // log them in
            auth()->login($existing_user, false);
        } else {
            // create a new user
            $new_user                  = new User;
            $new_user->name            = $user->name;
            $new_user->email           = $user->email;
            $new_user->password        = '';
            $new_user->user_type       = User::UT_SHOP_USER;
            $new_user->shop_id         = 0;

            $new_user->save();
            auth()->login($new_user, false);
        }
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // check if they're an existing user
        $existing_user = User::where('user_type', User::UT_SHOP_USER)->where('email', $user->email)->first();
        if($existing_user){
            // log them in
            auth()->login($existing_user, false);
        } else {
            // create a new user
            $new_user                  = new User;
            $new_user->name            = $user->name;
            $new_user->email           = $user->email;
            $new_user->password        = '';
            $new_user->user_type       = User::UT_SHOP_USER;
            $new_user->shop_id         = 0;

            $new_user->save();
            auth()->login($new_user, false);
        }
        return redirect()->intended($this->redirectPath());
    }
}