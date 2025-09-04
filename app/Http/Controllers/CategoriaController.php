<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{


    //Constructor para aplicar middleware de autenticación

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {}


    public function create() {}


    public function store(Request $request)
    {

        // Validación del campo 'nombre'
        $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre',
            'parent_id' => 'nullable|exists:categorias,id', // 'parent_id' puede ser nulo, pero si se proporciona, debe existir en la tabla 'categorias'
        ]);


        // Crea la nueva categoría
        $categoria = Categoria::create([
            'nombre' => $request->input('nombre_categoria'),
            'parent_id' => $request->input('parent_id'),
        ]);

        // Si la petición es AJAX, devuelve una respuesta JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Categoría creada exitosamente.',
                'categoria' => $categoria
            ]);
        }

        // Si no es una petición AJAX, redirige a la página principal de documentos
        return redirect()->route('documentos.index')->with('success');
    }


    public function show(Categoria $categoria)
    {
        //
    }


    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }


    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'parent_id' => 'nullable|exists:categorias,id',
        ]);

        $categoria->nombre = $request->nombre;
        $categoria->parent_id = $request->parent_id;
        $categoria->save();

        return redirect()->route('documentos.index')->with('success');
    }


    public function destroy(Categoria $categoria)
    {
        try {
            DB::transaction(function () use ($categoria) {
                // Elimina todos los documentos y sus comentarios de esta categoría.
                $documentos = $categoria->documentos;
                foreach ($documentos as $documento) {
                    // Primero, elimina los comentarios del documento para evitar errores de integridad.
                    $documento->comentarios()->delete();
                    // Luego, elimina el documento.
                    $documento->delete();
                }

                // Ahora que todos los documentos (y sus comentarios) han sido eliminados, se elimina la categoria

                $categoria->delete();
            });

            return redirect()->route('documentos.index')->with('success');
        } catch (\Exception $e) {
            // Manejar cualquier error inesperado y redirigir con un mensaje de error.
            return redirect()->route('documentos.index')->with('error', 'Ocurrió un error al intentar eliminar la categoría y sus documentos.');
        }
    }
}
