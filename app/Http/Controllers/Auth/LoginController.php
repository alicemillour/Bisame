<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth, Lang;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $login = $request->input('email');
        if(preg_match('/@/', $login)){
            if (Auth::attempt(['email' => $login, 'password' => $request->input('password')],true)) {
            // Authentication passed...
            return redirect()->intended($this->redirectPath());
            }
        } else {
            if (Auth::attempt(['name' => $login, 'password' => $request->input('password')],true)) {
            // Authentication passed...
            return redirect()->intended($this->redirectPath());
            }
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);

    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }
}
