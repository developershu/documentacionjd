<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request)
{
    // Validar la entrada
    $validated = $request->validate([
        'contenido' => 'required|string|max:1000',
        'documento_id' => 'required|exists:documentos,id'
    ]);

    // Crear el comentario relacionado con el usuario actual
    $comentario = new Comentario([
        'contenido' => $validated['contenido'],
        'documento_id' => $validated['documento_id']
    ]);

    auth()->user()->comentarios()->save($comentario);

    return back()->with('success'); 
}


     public function destroy(Comentario $comentario)
    {
        // Opcional: Verificar que el usuario sea un administrador para eliminar
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        try {
            $comentario->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el comentario.'], 500);
        }
    }
}
