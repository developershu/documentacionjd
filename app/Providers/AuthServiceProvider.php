<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Documento;
use App\Policies\DocumentoPolicy;
use App\Models\Comentario;
use App\Policies\ComentarioPolicy;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Documento::class => DocumentoPolicy::class,
        Comentario::class => ComentarioPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Definir gate para administradores
        Gate::define('admin-access', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}