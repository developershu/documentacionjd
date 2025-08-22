

<section class="mb-4">
    <header>
        <h2 class="h4">
            {{ __('Eliminar Cuenta') }}
        </h2>
        <p class="mt-1 text-sm text-muted">
            {{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos serán eliminados permanentemente.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger mt-4" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
        {{ __('Eliminar Cuenta') }}
    </button>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">{{ __('Eliminar Cuenta') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">
                            {{ __('¿Estás seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.') }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Confirmar Eliminación') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
