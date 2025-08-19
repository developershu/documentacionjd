<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Documento;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentoPolicy
{
    use HandlesAuthorization;

    

    public function view(User $user, Documento $documento)
    {
        return $documento->estado === 'publicado' || $user->hasRole('admin') || $documento->user_id === $user->id;
    }

    public function viewAny(User $user)
{
    return true; // Todos pueden ver la lista
}

public function create(User $user)
{
    return $user->hasRole('admin');
}

public function update(User $user, Documento $documento)
{
    return $user->hasRole('admin') || $documento->user_id === $user->id;
}

public function delete(User $user, Documento $documento)
{
    return $user->hasRole('admin') || $documento->user_id === $user->id;
}
}