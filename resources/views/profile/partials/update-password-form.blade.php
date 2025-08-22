
<section>
    <header>
        <h2 class="h4">
            {{ __('Actualizar Contraseña') }}
        </h2>
        <p class="mt-1 text-sm text-muted">
            {{ __('Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantenerse segura.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="current_password" class="form-label">{{ __('Contraseña Actual') }}</label>
            <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
            @error('current_password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
            @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            @error('password_confirmation')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end align-items-center mt-4">
            <button type="submit" class="btn btn-primary" style="background-color: #003764; border-color: #003764;">
                {{ __('Guardar') }}
            </button>
        </div>
    </form>
</section>
