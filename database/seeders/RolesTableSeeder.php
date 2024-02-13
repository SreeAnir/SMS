<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            [
                'name' => Role::ROLE_DEVELOPER,
                #'role_type' => Role::TYPE_SUPERVISOR,
                'guard_name' => 'admin',
                'users' => [
                    'dev@test.com'
                ],
                'permissions' => 'all'
            ],
            [
                'name' => Role::ROLE_SUPER_ADMIN,
                'guard_name' => 'admin',
               # 'role_type' => Role::TYPE_SUPERVISOR,
                'users' => [
                    'su@test.com'
                ],
                'permissions' => 'all',
               
            ],
            [
                'name' => Role::ROLE_MAIN_ADMIN,
                'guard_name' => 'admin',
               # 'role_type' => Role::TYPE_SUPERVISOR,
                'users' => [
                    'mainadmin@test.com'
                ],
                'permissions' => 'all',
               
            ],
            [
                'name' => Role::ROLE_MAIN_ACCOUNTANT,
                'guard_name' => 'admin',
               # 'role_type' => Role::TYPE_SUPERVISOR,
                'users' => [
                    'mainaccountant@test.com'
                ],
                'permissions' => 'all',
               
            ],
            [
                'name' => Role::ROLE_ADMIN,
                'guard_name' => 'admin',
                #'role_type' => Role::TYPE_ADMIN,
                'users' => [
                    'admin1@test.com',
                    'admin2@test.com',
                    'admin3@test.com',
                ],
                'permissions' => 'all'
            ],
            [
                'name' => Role::ROLE_ACCOUNTANT,
                'guard_name' => 'admin',
                #'role_type' => Role::TYPE_ADMIN,
                'users' => [
                    'account1@test.com'
                ],
                'permissions' => 'all'
            ]
        ];

        foreach ($roles as $role_data) {
            /** @var Role $role */
            $role = Role::updateOrCreate(['name' => $role_data['name']],
                Arr::only($role_data, ['guard_name', 'role_type']));
            //Link users to role
            if (array_key_exists('users', $role_data)) {
                foreach ($role_data['users'] as $user) {
                    /** @var User $user */
                    $user = User::where('email', $user)->first();
                    if ($user) {
                        $user->roles()->syncWithoutDetaching($role->id);
                    }
                }
            }

             
            //Assign permissions to role
            if (isset($role_data['permissions'])) {
                if ($role_data['permissions'] === 'all') {
                    $role->syncPermissions(Permission::where('guard_name', $role_data['guard_name'])->get());
                } else {
                    $role->syncPermissions(Permission::whereIn('name', $role_data['permissions'])->where('guard_name', $role_data['guard_name'])->get());
                }
                if (isset($role_data['permission_groups'])) {
                    $role->givePermissionTo(Permission::whereIn('group', $role_data['permission_groups'])->where('guard_name', $role_data['guard_name'])->get());
                }
            } elseif (isset($role_data['permissions_except'])) {
                $role->syncPermissions(Permission::whereNotIn('name', $role_data['permissions_except'])->where('guard_name', $role_data['guard_name'])->get());
            }
        }
    }
}
