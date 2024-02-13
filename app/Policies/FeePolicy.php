<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\Fee;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->can(Fee::PERMISSION_BATCH_LIST);
    }

     /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return Response|bool
     */
    public function view(User $user,  Fee $model): Response|bool
    {
        return $user->can( Fee::PERMISSION_FEE_MANAGE);
    }

}
