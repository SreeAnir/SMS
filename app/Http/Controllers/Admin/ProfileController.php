<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    //
       /**
     * Display the specified resource.
     */
    public function viewProfile()
    {
        $user = auth()->user();
        $permissions = $user->getPermissions();
        return view('admin.users.profile', compact('user','permissions'));
    }


}
