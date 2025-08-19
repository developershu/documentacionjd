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
        try {
            $request->validate([
                'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre',
            ]);

            $categoria = new Categoria();
            $categoria->nombre = $request->nombre_categoria;
            $categoria->save();

            return redirect()->route('documentos.index')->with('success');
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la categoría: ' . $e->getMessage(),
                'errors' => ['nombre_categoria' => [$e->getMessage()]]
            ], 422);
        }
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
        ]);
    
        $categoria->nombre = $request->nombre;
        $categoria->save();
    
        return redirect()->route('documentos.index')->with('success');
    }

    
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('documentos.index')->with('success');
    }
}
