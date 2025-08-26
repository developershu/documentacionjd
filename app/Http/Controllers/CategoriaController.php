<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
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
            'nombre' => 'required|string|max:255|unique:categorias,nombre,'.$categoria->id,
            'parent_id' => 'nullable|exists:categorias,id',
        ]);
    
        $categoria->nombre = $request->nombre;
        $categoria->parent_id = $request->parent_id;
        $categoria->save();
    
        return redirect()->route('documentos.index')->with('success');
    }

    
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('documentos.index')->with('success');
    }
}
