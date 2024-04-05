<?php

namespace App\Policies;

use App\Models\CreatorProfile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CreatorProfilePolicy
{

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_creator');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CreatorProfile $creatorProfile): bool
    {
        return $user->can('view_creator');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_creator');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CreatorProfile $creatorProfile): bool
    {
        return $user->can('update_creator');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CreatorProfile $creatorProfile): bool
    {
        return $user->can('delete_creator');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CreatorProfile $creatorProfile): bool
    {
        return $user->can('restore_creator');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CreatorProfile $creatorProfile): bool
    {
        return $user->can('restore_any_creator');
    }
}
