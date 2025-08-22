

<section>
    <header>
        <h2 class="h4">
            {{ __('Información del Perfil') }}
        </h2>
        <p class="mt-1 text-sm text-muted">
            {{ __("Actualiza la información de tu cuenta y dirección de correo.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Nombre') }}</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
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
