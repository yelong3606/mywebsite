<?php
namespace App\Http\Controllers\Auth\Site;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
/**
 * Site Admin Login
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
        $this->middleware('guest:site')->except('logout');
    }
            
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password') + array(
            'user_type' => \App\User::UT_SITE_ADMIN
        );
    }
    protected function guard() {
        return Auth::guard('site');
    }
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.site.login')->with('title', 'Login');
    }
    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect(route('site.login'));
    }
}