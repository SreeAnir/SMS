<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
 
class StudentLoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'user_name' => ['required'],
            'password' => ['required'],
        ]);
       
        if (Auth::attempt($credentials)) {  
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors([
            'user_name' => 'The provided username/password do not match our records.',
        ])->onlyInput('user_name');
    }
    
    public function studentLogout(){
        Auth::guard('web')->logout();
        return redirect()->route('home');
    }
}