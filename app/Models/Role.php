<?php

namespace App\Models;

use Spatie\Permission\Models\Role as Model;

class Role extends Model  
{

    /**
     * List of permission for this model
     */
    public const PERMISSION_LIST = 'List roles';
    public const PERMISSION_VIEW = 'View role';
    public const PERMISSION_CREATE = 'Create role';
    public const PERMISSION_UPDATE = 'Update role';
    public const PERMISSION_DELETE = 'Delete role';

    /**
     * List of roles
     */

     public const TYPE_SUPERVISOR = 'supervisor';
     public const TYPE_USER = 'user';

     public const TYPE_ADMIN= 'admin';


    public const ROLE_DEVELOPER = 'Developer';

    public const ROLE_SUPER_ADMIN = 'Super Admin';

    public const ROLE_MAIN_ADMIN = 'Main Admin';

    public const ROLE_ADMIN = 'Admin';

    public const ROLE_USER = 'User';

    public const ROLE_MAIN_ACCOUNTANT = 'Main Accountant';

    public const ROLE_ACCOUNTANT = 'Accountant';
    
    public const USER_TYPE_SU = 1; //This is only to check if superadmin/admin

    public const USER_TYPE_ADMIN = 2; //This is only to check if admin

    public const USER_TYPE_STAFF = 3; //This is only to check if admin

    public const USER_TYPE_STUDENT= 4; //This is only to check if admin

    public $fillable = ['name', 'guard_name'];

    public static function getRoles($only_role=null){
        if( $only_role !=null ){
            return self::where('name', $only_role)->get();

        }
        if( auth()->user()->isSuperAdmin() ){
            return self::get();
        }
        else{
            return self::whereNotIn('name',[self::ROLE_DEVELOPER ,self::ROLE_SUPER_ADMIN ])->get();
        }
    }
}
