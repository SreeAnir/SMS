<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
// use App\DataTables\UserDataTable;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // echo "fdds";
        $roles = Role::get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('admin.roles.add-edit', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleRequest  $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        /** @var Role $role */
        if ($role = Role::create($request->getData())) {
            $role->syncPermissions($request->permissions);

            $response = ['status' => 'success', 'message' => 'Role created successfully!'];
            return redirect()->route('roles.index')->with($response);
        }

        $response = ['status' => 'error', 'message' => 'Failed to create role!'];
        return redirect()->back()->with($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return Application|Factory|View
     */
    public function show(Role $role)
    {
        $permissions = Permission::all();
        // $roleUsersDataTable->filterBy('role', $role->id);
        // $roleUsersDataTable->hideColumn('role');
        return view('admin.roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return Application|Factory|View
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('group');
        return view('admin.roles.add-edit', compact('permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleRequest  $request
     * @param  Role  $role
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        if ($role->update($request->getData())) {
            if ($request->filled('permissions') && ($role->permissions()->count() !== count($request->get('permissions'))
                    || count(array_xor($role->permissions->map->id->toArray(), $request->get('permissions'))))) {
                $existing = $role->permissions->map->name->toArray();
                $role->guard(['admin'])->syncPermissions($request->permissions);
                $updated = $role->permissions->map->name->toArray();

                $old = [];
                $new = [];

                $removed = array_diff($existing, $updated);
                if (count($removed)) {
                    $old = ['removed_permissions' => implode(', ', $removed)];
                }
                $added = array_diff($updated, $existing);
                if (count($added)) {
                    $new = ['added_permissions' => implode(', ', $added)];
                }
                //Custom log permissions sync
            }

            $response = ['status' => 'success', 'message' => 'Role updated successfully!'];
            return redirect()->route('roles.show', $role)->with($response);
        }

        $response = ['status' => 'error', 'message' => 'Failed to update role!'];
        return redirect()->back()->with($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  Role  $role
     * @return RedirectResponse|string[]
     */
    public function destroy(Request $request, Role $role)
    {
        if ($role->delete()) {
            $response = ['status' => 'success', 'message' => 'Role deleted successfully!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to delete role!'];
        }

        if ($request->ajax()) {
            return $response;
        } else {
            return redirect()->route('admin.roles.index')->with($response);
        }
    }

    /**
     * @param  Role  $role
     * @param  User  $user
     * @return string[]
     */
    public function removeUser(Role $role, User $user)
    {
        if ($user->removeRole($role)) {
            return ['status' => 'success', 'message' => 'User removed from this role successfully!'];
        }
        return ['status' => 'error', 'message' => 'Failed to remove user from this role!'];
    }
}
