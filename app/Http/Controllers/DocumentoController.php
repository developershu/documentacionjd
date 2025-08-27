<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Categoria;

class DocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Solo aplicar estas políticas a las rutas específicas
        $this->middleware('can:create,App\Models\Documento')->only(['create', 'store']);
        $this->middleware('can:update,documento')->only(['edit', 'update']);
        $this->middleware('can:delete,documento')->only('destroy');
    }

    public function index()
    {
        // Cargar las categorías principales (sin padre) con sus subcategorías y documentos
        $categorias = Categoria::whereNull('parent_id')
            ->with(['subcategorias', 'documentos' => function ($query) {
                if (!auth()->user()->hasRole('admin')) {
                    $query->where('estado', 'publicado');
                }
            }])->get();

        return view('documentos.index', compact('categorias'));
    }

    public function create()
    {
        $this->authorize('create', Documento::class);
        $categorias = Categoria::all(); // Carga todas las categorías para la vista de creación
        return view('documentos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id', // Se valida que la categoría exista
            'archivo' => 'nullable|file|mimes:pdf,docx,pptx|max:10240',
            'estado' => 'required|in:borrador,publicado',
            'link' => 'nullable|url'
        ]);

        $documento = new Documento;
        $documento->titulo = $request->titulo;
        $documento->descripcion = $request->descripcion;
        $documento->estado = $request->estado;
        $documento->link = $request->link;
        $documento->user_id = auth()->id(); // Asigna el usuario autenticado
        $documento->categoria_id = $request->categoria_id;

      

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('documentos', 'public');
            $documento->archivo = $path;
        }
        $documento->save();

        return redirect()->route('documentos.index')
            ->with('success', );
    }

    public function storeCategoria(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre',
        ]);

        $categoria = Categoria::create([
            'nombre' => $request->nombre_categoria,
        ]);
        
        // Retorna una respuesta JSON para que el modal funcione sin recargar
        return response()->json([
            'success' => true,
            
            'categoria' => $categoria
        ]);
    }

    public function show(Documento $documento)
    {
        $documento->load(['comentarios.usuario']); // Carga los comentarios y sus usuarios

        return view('documentos.show', compact('documento'));
    }

    public function edit(Documento $documento)
    {
        $this->authorize('update', $documento);
        // Se carga todas las categorías para la vista de edición.
        $categorias = Categoria::all();
        return view('documentos.edit', compact('documento', 'categorias'));
    }

    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:pdf,docx,pptx|max:10240',
            'estado' => 'required|in:borrador,publicado',
            'link' => 'nullable|url',
        ]);

        $data = [
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'link' => $request->link,
        ];

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if ($documento->archivo) {
                Storage::delete('public/' . $documento->archivo);
            }

            $file = $request->file('archivo');
            $filename = $this->generateFilename($file);
            
            
            $data['archivo'] = $file->storeAs('documentos', $filename, 'public');
        }

        $documento->update($data);

        return redirect()->route('documentos.index')
            ->with('success');
    }

    public function destroy(Documento $documento)
    {
        try {
            // 1. Autorizar la eliminación del documento
            $this->authorize('delete', $documento);

            // 2. Eliminar primero los comentarios asociados para evitar errores de integridad referencial.
            $documento->comentarios()->delete();

            // 3. Eliminar el archivo del almacenamiento si existe.
            if ($documento->archivo) {
                Storage::delete('public/' . $documento->archivo);
            }
            
            // 4. Eliminar el registro del documento de la base de datos.
            $documento->delete();

            // 5. Redirigir con un mensaje de éxito.
            return redirect()->route('documentos.index')->with('success', 'Documento eliminado exitosamente.');
        } catch (\Exception $e) {
            // Manejar la excepción y redirigir con un mensaje de error.
            return redirect()->route('documentos.index')->with('error', 'Ocurrió un error al intentar eliminar el documento. Por favor, inténtelo de nuevo.');
        }
    }

    protected function generateFilename($file)
    {
        return Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . time()
            . '.' . $file->getClientOriginalExtension();
    }
}
