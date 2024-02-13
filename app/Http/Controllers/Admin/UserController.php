<?php

namespace App\Http\Controllers\Admin;

// use App\Events\AdminNewUser;
use App\Models\LoginSecurity;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Hash;


use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Exception;
use App\Models\User;
use App\Models\Staff;
use App\Models\Role;
use App\DataTables\UsersDataTable;
use App\DataTables\StaffDataTable;
use Illuminate\Auth\Events\Registered;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        try {
            return $dataTable->render("admin.users.index");
        } catch (Exception $e) {
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }
    public function data(UsersDataTable $dataTable)
    {
        try {
            return $dataTable->eloquent(User::query())->toJson();
        } catch (Exception $e) {
            // dd( $e );
            return $response = ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $userData = $request->getData();
            $pw = $userData['password_plain'];
            unset($userData['password_plain']);
            // unset($request->password);
            if ($user = User::create($userData)) {
                $this->syncRoles($request, $user);
                DB::commit();
                // (event(new AdminNewUser($user))); //Not working

                Mail::to($user->email)->queue(new WelcomeEmail($user, $pw));


                $response = ['status' => 'success', 'message' => 'User created successfully!'];

                return redirect()->route('users.show', $user)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to create user!'];
            return redirect()->back()->with($response);
        } catch (Exception $e) {
            DB::rollback();  
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $permissions = $user->getPermissions();
        return view('admin.users.show', compact('user', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title = 'Edit user';
        return view('admin.users.create-form', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            DB::beginTransaction(); 
            if ($user->update($request->getData())) {
                $this->syncRoles($request, $user);
                DB::commit();
               
                $response = ['status' => 'success', 'message' => 'User updated successfully!'];
                return redirect()->route('users.show', ['user' => $user])->with($response);
            }
            
            $response = ['status' => 'error', 'message' => 'Failed to update user!'];
            return redirect()->route('users.show', ['user' => $user])->with($response);

        } catch (Exception $e) {
            DB::rollback(); 
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    private function syncRoles(UserRequest $request, User $user)
    {
        if ((auth()->user()->can('assignRole', User::class) || auth()->user()->user_type == Role::USER_TYPE_SU) && $request->filled('roles')) {
            if (  $user->roles()->count() !== count($request->get('roles'))   || count(array_xor($user->roles->map->id->toArray(), $request->get('roles')))   ) {
                $old = [
                    'roles' => $user->roles->implode('name', ', ')
                ];
                $user->syncRoles($request->roles);
            }
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function staffListing(StaffDataTable $dataTable)
    {
        try {
            return $dataTable->render("admin.staffs.index");
        } catch (Exception $e) {
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }

    public function staffCreate()
    {
        return view('admin.staffs.create-form');
    }

    public function staffStore(StaffRequest $request)
    {
        try {
            DB::beginTransaction();
            $userData = $request->getData() ;
            if ($user = User::create( $userData )) {
                $staffData = $request->getStaffData() ;
                $staffData['user_id'] = $user->id ;
               // dd($staffData);
                $saved  = Staff::create($staffData);
                DB::commit();
                $response = ['status' => 'success', 'message' => 'Staff Profile created successfully!'];

                return redirect()->route('staffs.show', $user)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to create user!'];
            return redirect()->back()->with($response);
        }catch (Exception $e) { 
            DB::rollback();
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return redirect()->back()->with($response);
        } 
    }
    /**
     * Display the specified resource.
     */
    public function staffShow(User $user)
    {
        $userWithStaff = User::with('staff')->find($user->id);
        $staffDetails = $userWithStaff->staff;
        $userDetails = $userWithStaff;
        return view('admin.staffs.show',compact('userDetails','staffDetails'));
    }
    public function staffEdit($staff_id)
    {
        $title = 'Edit Staff';
        $staff = User::find($staff_id);
        $staffData = Staff::where('user_id',$staff_id)->first();
        return view('admin.staffs.create-form', compact('staff','staffData', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function staffUpdate(StaffRequest $request, User $staff)
{
    try {
        DB::beginTransaction();
        $userData = $request->getData();        
        if ($staff->update($userData)) {
            $staffData = $request->getStaffData();
            $staff->staff->update($staffData);
            DB::commit();
            $response = ['status' => 'success', 'message' => 'Staff updated successfully!'];
            return redirect()->route('staffs.show', $staff)->with($response);
        }

        $response = ['status' => 'error', 'message' => 'Failed to update Staff!'];
        return redirect()->back()->with($response);
    } catch (Exception $e) {
        DB::rollback();
        $response = ['status' => 'error', 'message' => $e->getMessage()];
        return redirect()->back()->with($response);
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function manage2FaAuth( Request $request)
    {
        $user_id = $request->user_id ;
        $status = $request->status ;
         $user = User::find( $user_id);
        try {
            DB::beginTransaction();
            if ($status == null) {
                return response()->json(['status' => "error", 'message' => "No Status Added", 'message_title' => "Failed to update!"], 200);
            }
            $loginSecurity = $user?->loginSecurity;

            if ($loginSecurity != null) {
                
                if ($status == "reset") {
                    $loginSecurity->delete();
                    // $user->loginSecurity()->dissociate();
                    $user->save();
                    $message ="Authenitcator reset done.";
                } else {
                    if ($status == "enable") {
                        
                        // $user->loginSecurity()->associate();
                        // $user->save();
                        //// LoginSecurity::where("user_id", $user_id)->update(["google2fa_enable" => 1 ]) ;
                        $user->loginSecurity->update([
                            'google2fa_enable' => 1
                        ]);
                        $message ="Authenitcator enabled.";
                    } else {

                        //// LoginSecurity::where("user_id", $user_id)->update(["google2fa_enable" => 0 ]) ;
                        $user->loginSecurity->update([
                            'google2fa_enable' => 0 ,
                            'google2fa_secret' => null
                        ]);
                        $message ="Authenitcator Disabled.";
                    }
                }
            } else {
                
                // Initialise the 2FA class
        
                // Add the secret key to the registration data
               

                if ($status == "enable") { 
                    $login_security = LoginSecurity::firstOrNew(array('user_id' => $user_id));
                    $login_security->user_id = $user->id;
                    $login_security->google2fa_enable = 1 ;
                    $login_security->google2fa_secret = null;
                    $login_security->save();

                    $message ="Authenitcator enabled";
                    
                    // $user->loginSecurity->update([
                    //     'google2fa_enable' => 1,
                    //     'google2fa_secret' => null
                    // ]);
                } else {
                    $login_security = LoginSecurity::firstOrNew(array('user_id' => $user_id));
                    $login_security->user_id = $user->id;
                    $login_security->google2fa_enable = 0 ;
                    $login_security->google2fa_secret = null;
                    $login_security->save();
                    // $user->loginSecurity->update([
                    //     'google2fa_enable' => 2,
                    //     'google2fa_secret' => null
                    // ]);
                    $message ="Authenitcator disabled";
                }

            }
            DB::commit();

            return response()->json(['status' => "success", 'message' =>  $message , 'message_title' => "Successfully updated!"], 200);

        } catch (Exception $e) {
            return response()->json(['status' => "error", 'message' => $e->getMessage() , 'message_title' => "Failed"], 200);
        }
    }
    public function updatePassword(Request $request)
    {       

        try 
        {
            $userId = Auth()->user()->id;
            $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6'
            ]);

            $user = Auth()->user();
            if (Hash::check($request->password, $user->password))
            {
                $user->update([
                    'password' => Hash::make($request->new_password),
                ]);
                $response = ['status' => 'success', 'message' => 'Password changed successfully!'];
                    return redirect()->route('change-password')->with($response);
            } 
            else 
            {
                $response = ['status' => 'error', 'message' => 'The current password is incorrect!'];
                return redirect()->back()->with($response);
            }
            $response = ['status' => 'error', 'message' => 'Failed to change password!'];
            return redirect()->back()->with($response);            
        }
        catch (Exception $e) 
        {  
            DB::rollback();
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return redirect()->back()->with($response);
        }
    }
}
