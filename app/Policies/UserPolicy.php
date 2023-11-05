<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->email === config('auth.admin.email');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}
