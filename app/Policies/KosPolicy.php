<?php

namespace App\Policies;

use App\Models\Kos;
use App\Models\User;

class KosPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->isPemilikKos();
    }

    public function view(User $user, Kos $kos): bool
    {
        return $user->isSuperAdmin()
            || ($user->isAdmin() && $kos->wilayah_id === $user->wilayah_id)
            || ($user->isPemilikKos() && $kos->user_id === $user->id);
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isPemilikKos();
    }

    public function update(User $user, Kos $kos): bool
    {
        return $user->isSuperAdmin()
            || ($user->isPemilikKos() && $kos->user_id === $user->id);
    }

    public function delete(User $user, Kos $kos): bool
    {
        return $user->isSuperAdmin();
    }

    public function verify(User $user, Kos $kos): bool
    {
        return $user->isSuperAdmin()
            || ($user->isAdmin() && $kos->wilayah_id === $user->wilayah_id);
    }
}
