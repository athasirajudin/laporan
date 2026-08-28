<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wilayah;

class WilayahPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user, Wilayah $wilayah): bool
    {
        return $user->isSuperAdmin()
            || ($user->isAdmin() && $user->wilayah_id === $wilayah->id);
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Wilayah $wilayah): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, Wilayah $wilayah): bool
    {
        return $user->isSuperAdmin();
    }
}
