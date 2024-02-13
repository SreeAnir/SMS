<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Status;
use App\Models\Role;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    { 
        
       //debugpermission
        // $userRoles = auth()->user()->getRoleNames();
// $userPermissions = auth()->user()->getAllPermissions()->pluck('name');dd($userPermissions);
        $roles = Role::where('name', '<>', Role::ROLE_USER)->get()->pluck('name')->toArray(); 
        if(Auth::check()) {  
            if(Auth::user()->status_id != Status::STATUS_ACTIVE || !Auth::user()->hasAnyRole($roles)) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors([__('Sorry You don\'t have a permission to View The Portal')]);
            }
            if(Auth::user()->loginSecurity ==null ){
                return redirect()->route('enable2FaForm');
            }
        }
        return $next($request);
    }
 
}
