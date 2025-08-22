@extends('layouts.guest')

@section('content')

    <!-- Estado de la Sesión -->
    @if (session('status'))
        <div class="alert alert-success mt-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Campo de Correo Electrónico -->
        <div class="mb-3">
            <label for="email" class="form-label" style="color:aliceblue">Email</label>
            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Campo de Contraseña -->
        <div class="mb-3">
            <label for="password" class="form-label" style="color:aliceblue">Contraseña</label>
            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary btn-m btn-login" >
                Ingresar
            </button>
        </div>
    </form>
@endsection
