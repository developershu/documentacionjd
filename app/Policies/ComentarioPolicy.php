<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comentario;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComentarioPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Comentario $comentario)
    {
        return $user->hasRole('admin') || $comentario->user_id === $user->id;
    }
}