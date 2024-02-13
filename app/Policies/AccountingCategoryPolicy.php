<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\AccountingCategory;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AccountingCategoryPolicy
{
    use HandlesAuthorization;

     /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->can(AccountingCategory::PERMISSION_CATEGORY_LIST);
    }

     /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return Response|bool
     */
    public function view(User $user,  AccountingCategory $model): Response|bool
    {
        return $user->can( AccountingCategory::PERMISSION_CATEGORY_VIEW);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->can(AccountingCategory::PERMISSION_CATEGORY_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return Response|bool
     */
    public function update(User $user,  AccountingCategory $model): Response|bool
    {
        return   ($user->can( AccountingCategory::PERMISSION_CATEGORY_UPDATE) || $user->is($model));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return Response|bool
     */
    public function delete(User $user,  AccountingCategory $model): Response|bool
    {
        return !$model->hasRole(Role::ROLE_SUPER_ADMIN) && $user->can( AccountingCategory::PERMISSION_CATEGORY_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return Response|bool
     */
    public function restore(User $user, AccountingCategory $model): Response|bool
    {
        return $model->trashed() && $user->hasRole(Role::ROLE_SUPER_ADMIN);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return Response|bool
     */
    public function forceDelete(User $user, AccountingCategory $model): Response|bool
    {
        //
    }


    public function isSuper(User $user): Response|bool
    {
        return $user->hasRole(Role::ROLE_SUPER_ADMIN) ;
    }
}
