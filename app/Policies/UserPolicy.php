<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user, User $targetUser): bool
    {
        return $user->isSuperAdmin() || $user->id === $targetUser->id;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, User $targetUser): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, User $targetUser): bool
    {
        return $user->isSuperAdmin() && $user->id !== $targetUser->id;
    }

    public function manageStatus(User $user, User $targetUser): bool
    {
        return $user->isSuperAdmin() && $user->id !== $targetUser->id;
    }

    public function manageRole(User $user, User $targetUser): bool
    {
        return $user->isSuperAdmin() && $user->id !== $targetUser->id;
    }
}
