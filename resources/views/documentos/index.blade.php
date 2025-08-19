@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Encabezado con condicional para botón de creación y categoría -->
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded"
            style="background-color: #003764; color: white;">
            <h2>
                @can('create', App\Models\Documento::class)
                    Junta Directiva
                @else
                    Junta Directiva
                @endcan
            </h2>
            @can('create', App\Models\Documento::class)
                <div class="d-flex gap-2">
                    <a href="{{ route('documentos.create') }}" class="btn btn-light" style="color: #003764;">
                        <i class="fas fa-plus"></i> Nuevo Documento
                    </a>
                    <a href="#" class="btn btn-light" style="color: #003764;" data-bs-toggle="modal"
                        data-bs-target="#createCategoryModal">
                        <i class="fas fa-folder-plus"></i> Nueva Categoría
                    </a>
                </div>
            @endcan
        </div>

        <!-- Modal para crear una nueva categoría -->
        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCategoryModalLabel">Crear Nueva Categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('categorias.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la Categoría</label>
                                <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria"
                                    placeholder="Nombre de la nueva categoría" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #003764; color: white;">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Alertas y mensajes
            @if (session('success'))
    <div class="alert alert-success">
                    {{ session('success') }}
                </div>
    @endif-->

        <!-- Lógica del Explorador de Categorías con Bootstrap Accordion -->
        @if ($categorias->isEmpty())
            <div class="alert alert-info">
                No hay categorías o documentos disponibles.
            </div>
        @else
            <!-- Contenedor del acordeón -->
            <div class="accordion" id="accordionCategorias">
                @foreach ($categorias as $categoria)
                    <div class="accordion-item mb-4 shadow-sm">

                       

                        <h2 class="accordion-header" id="heading-{{ $categoria->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $categoria->id }}" aria-expanded="false"
                                aria-controls="collapse-{{ $categoria->id }}">
                                
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-folder text-warning me-2"></i>
                                        <strong>{{ $categoria->nombre }}</strong>
                                    </div>



                                   

                                </div>
                            </button>
                        </h2>

                        

                        <div id="collapse-{{ $categoria->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading-{{ $categoria->id }}" data-bs-parent="#accordionCategorias">
                            <div class="accordion-body p-0">
                                @if ($categoria->documentos->isEmpty())
                                    <div class="p-3 text-muted">
                                        No hay documentos disponibles en esta categoría.
                                    </div>
                                @else
                                    <!-- Tabla (visible en escritorio y tablets grandes) -->
                                    <div class="table-responsive d-none d-md-block">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Título</th>
                                                    @can('viewAny', App\Models\Documento::class)
                                                        <th>Estado</th>
                                                        <th>Autor</th>
                                                    @endcan
                                                    <th>Fecha</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categoria->documentos as $documento)
                                                    <tr>
                                                        <td>{{ $documento->titulo }}</td>
                                                        @can('viewAny', App\Models\Documento::class)
                                                            <td>
                                                                <span
                                                                    class="badge bg-{{ $documento->estado === 'publicado' ? 'success' : 'warning' }}">
                                                                    {{ ucfirst($documento->estado) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $documento->user->name }}</td>
                                                        @endcan
                                                        <td>{{ $documento->created_at->format('d/m/Y') }}</td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <a href="{{ route('documentos.show', $documento) }}"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                @can('update', $documento)
                                                                    <a href="{{ route('documentos.edit', $documento) }}"
                                                                        class="btn btn-sm btn-outline-secondary">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('delete', $documento)
                                                                    <form
                                                                        action="{{ route('documentos.destroy', $documento) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-danger"
                                                                            onclick="return confirm('¿Eliminar este documento?')">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    

                                    <!-- Tarjetas (visible en móviles) -->
                                    <div class="d-block d-md-none">
                                        @foreach ($categoria->documentos as $documento)
                                            <x-responsivecelu :documento="$documento" />
                                        @endforeach
                                    </div>
                                @endif
                            
                             @can('create', App\Models\Documento::class)
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('categorias.edit', $categoria) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta categoría? Esto eliminará todos los documentos asociados.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger ">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        </div>
                                        
                                    @endcan
                            
                            
                            
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
