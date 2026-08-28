<?php

namespace App\Policies;

use App\Models\Penghuni;
use App\Models\User;

class PenghuniPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->isPemilikKos();
    }

    public function view(User $user, Penghuni $penghuni): bool
    {
        $kos = $penghuni->kos;

        return $user->isSuperAdmin()
            || ($user->isAdmin() && $kos !== null && $kos->wilayah_id === $user->wilayah_id)
            || ($user->isPemilikKos() && $kos !== null && $kos->user_id === $user->id);
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isPemilikKos();
    }

    public function update(User $user, Penghuni $penghuni): bool
    {
        return $user->isSuperAdmin()
            || ($user->isPemilikKos()
                && $penghuni->kos !== null
                && $penghuni->kos->user_id === $user->id);
    }

    public function delete(User $user, Penghuni $penghuni): bool
    {
        return false;
    }

    public function markAsExited(User $user, Penghuni $penghuni): bool
    {
        return $user->isSuperAdmin()
            || ($user->isPemilikKos()
                && $penghuni->status === 'active'
                && $penghuni->kos !== null
                && $penghuni->kos->user_id === $user->id);
    }
}
