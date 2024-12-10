<?php

namespace App\Policies;

use App\Models\Instance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstancePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Instance $instance): bool
    {
        return $user->id === $instance->user_id;
    }

    public function update(User $user, Instance $instance): bool
    {
        return $user->id === $instance->user_id;
    }

    public function delete(User $user, Instance $instance): bool
    {
        return $user->id === $instance->user_id;
    }
} 