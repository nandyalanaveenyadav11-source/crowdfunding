<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CampaignPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Campaign $campaign): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Campaign $campaign): bool
    {
        return $user->id === $campaign->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Campaign $campaign): bool
    {
        return $user->id === $campaign->user_id || $user->role === 'admin';
    }

    public function restore(User $user, Campaign $campaign): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Campaign $campaign): bool
    {
        return $user->role === 'admin';
    }
}
