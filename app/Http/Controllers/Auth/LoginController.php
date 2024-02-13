<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function attemptLogin(\Illuminate\Http\Request  $request)
    {
        $email = $request->input('email');
        $field = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'email' : 'email';
        if($request->input('user_type') == Role::USER_TYPE_STUDENT){
            return Auth::guard('web')->attempt(
                [$field => $email, 'password' => $request->input('password'), 'user_type' =>  Role::USER_TYPE_STUDENT],
                $request->filled('remember')
            );
        }else{
            return Auth::guard('admin')->attempt(
                [$field => $email, 'password' => $request->input('password')],
                $request->filled('remember')
            );
        }
       
    }
    protected function authenticated($request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }
       
        return redirect('/dashboard');
    }
}
