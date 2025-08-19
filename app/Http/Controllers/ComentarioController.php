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

    return back()->with('success'); /*'Comentario creado correctamente' */
}
    public function destroy(Comentario $comentario)
    {
        $this->authorize('delete', $comentario);
        
        $comentario->delete();
        
        return back()->with('success'); /*'Comentario eliminado correctamente' */
    }
}
