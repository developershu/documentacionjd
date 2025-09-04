@vite(['resources/css/app.css'])



<div class="accordion-body p-0">
    @if (!$categorias->isEmpty())
        @foreach ($categorias as $categoria)
            <div class="accordion-item mb-4 shadow-sm">

                <h2 class="accordion-header d-flex justify-content-between align-items-center"
                    id="heading-{{ $categoria->id }}">

                    <!-- Botón del acordeón -->
                    <button class="accordion-button collapsed flex-grow-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ $categoria->id }}" aria-expanded="false"
                        aria-controls="collapse-{{ $categoria->id }}">
                        <i class="fas fa-folder text-warning me-2"></i>
                        <strong>{{ $categoria->nombre }}</strong>
                    </button>

                    <!-- Botones de acción (afuera del botón del acordeón) -->
                    @can('create', App\Models\Documento::class)
                        <div class="ms-2 d-flex gap-1">
                            <!-- Crear subcarpeta -->
                            <a href="#" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#createCategoryModal" data-parent-id="{{ $categoria->id }}">
                                <i class="fas fa-folder-plus"></i>
                            </a>

                            <!-- Editar -->
                            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Eliminar -->
                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta categoría? Esto eliminará todos los documentos asociados.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endcan
                </h2>

                <!-- Contenido del acordeón -->
                <div id="collapse-{{ $categoria->id }}" class="accordion-collapse collapse"
                    aria-labelledby="heading-{{ $categoria->id }}">


                    <div class="accordion-body">
                        @if ($categoria->documentos->isEmpty() && $categoria->subcategorias->isEmpty())
                            <div class="alert alert-info">
                                No hay documentos en esta carpeta.
                            </div>
                        @else
                            <!-- Documentos en tabla (desktop) -->
                            @if (!$categoria->documentos->isEmpty())
                                <div class="table-responsive d-none d-md-block p-3">
                                    <table class="table table-striped table-hover ">
                                        <thead class="align-items-center mb-4 p-3 text-white"
                                            style="background-color: #003764;">
                                            <tr>
                                                <th>Documento</th>
                                                <th>Descripción</th>
                                                <th>Fecha de Creación</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categoria->documentos as $documento)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('documentos.show', $documento) }}">
                                                            {{ $documento->titulo }}
                                                        </a>
                                                    </td>
                                                    <td>{{ Str::limit($documento->descripcion, 50) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge rounded-pill bg-{{ $documento->estado === 'publicado' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($documento->estado) }}
                                                        </span>
                                                    </td>

                                                    
                                                    <td>{{ $documento->created_at->format('d/m/Y') }}</td>

                                                    

                                                    <td class="text-end">
                                                        <div
                                                            class="d-flex justify-content-end align-items-center gap-2">
                                                            <!-- Ícono de Ver: Siempre visible para los documentos en la lista -->
                                                            <a href="{{ route('documentos.show', $documento) }}"
                                                                class="btn btn-sm btn-outline-info">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <!-- Ícono de Editar: Visible solo para usuarios con permiso -->
                                                            @can('update', $documento)
                                                                <a href="{{ route('documentos.edit', $documento) }}"
                                                                    class="btn btn-sm btn-outline-secondary">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endcan
                                                            <!-- Ícono de Eliminar: Visible solo para usuarios con permiso -->
                                                            @can('delete', $documento)
                                                                <form
                                                                    action="{{ route('documentos.destroy', $documento) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar este documento?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger">
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

                                <!-- Documentos en tarjetas (móvil) -->
                                <div class="d-block d-md-none p-3">
                                    @foreach ($categoria->documentos as $documento)
                                        <x-responsive-celu :documento="$documento" />
                                    @endforeach
                                </div>
                            @endif

                            <!-- Subcategorías -->
                            @if (!$categoria->subcategorias->isEmpty())
                                @include('documentos._category-tree', [
                                    'categorias' => $categoria->subcategorias,
                                ])
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

