<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario para editar el perfil del usuario.
     */
    public function edit()
    {
        // La vista necesitará el objeto del usuario autenticado.
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Actualiza el perfil del usuario autenticado.
     */
    public function update(Request $request)
    {
        // Validar los campos de entrada
        $validatedData = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            // La contraseña es opcional, pero si se proporciona, se valida.
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user = User::find(Auth::id());

        // Actualizar el nombre y el correo electrónico si se proporcionaron
        if ($request->filled('name')) {
            $user->name = $validatedData['name'];
        }

        if ($request->filled('email')) {
            $user->email = $validatedData['email'];
        }

        // Si se proporcionó una nueva contraseña, la hashea y la actualiza.
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')
                         ->with('success');
    }
    
    /**
     * Elimina el perfil del usuario autenticado.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);
        $user = User::find(Auth::id());

        Auth::logout();

        $user->delete();
        

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Tu cuenta ha sido eliminada. Por favor comunicate con Dirección para reactivar tu cuenta.');
    }
}
