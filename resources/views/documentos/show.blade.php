@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>{{ $documento->titulo }}</h2>
                    @if (auth()->user()->hasRole('admin'))
                        <span class="badge badge-{{ $documento->estado === 'publicado' ? 'success' : 'secondary' }}">
                            {{ ucfirst($documento->estado) }}
                        </span>
                    @endif
                </div>

                <div class="mb-4">
                    <p class="lead">{{ $documento->descripcion }}</p>

                    @if ($documento->archivo && Storage::disk('public')->exists($documento->archivo))
                        <a href="{{ asset('storage/' . $documento->archivo) }}" target="_blank" class="btn btn-outline-success"
                            style="background-color: #003764 ; color: white;">
                            <i class="fas fa-download"></i> Descargar Documento
                        </a>
                    @endif

                    <div class="mt-4">
                        @if ($documento->link)
                            <a href="{{ $documento->link }}" target="_blank">{{ $documento->link }}</a>
                        @endif
                    </div>
                </div>

                <hr>

                <h3 class="mb-3">Comentarios</h3>

                <!-- Sección del switch y botón de guardar para el administrador -->
                @if (auth()->user()->hasRole('admin'))
                    <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="comentarios-switch"
                                {{ $documento->comentarios_habilitados ? 'checked' : '' }}>
                            <label class="form-check-label" for="comentarios-switch">
                                Habilitar comentarios
                            </label>
                        </div>
                        <button id="guardar-btn" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar cambios
                        </button>
                    </div>
                @endif

                <!-- Contenedor para la sección de comentarios -->
                <div id="comentarios-seccion">
                    @forelse($documento->comentarios as $comentario)
                        <div class="card mb-3" id="comentario-{{ $comentario->id }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title">{{ $comentario->usuario->name }}</h5>
                                        <small class="text-muted">
                                            {{ $comentario->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    @if (auth()->user()->hasRole('admin'))
                                        <button class="btn btn-sm btn-outline-danger btn-eliminar-comentario"
                                            data-id="{{ $comentario->id }}" data-bs-toggle="modal"
                                            data-bs-target="#confirmacionModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                                <p class="card-text">{{ $comentario->contenido }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            No hay comentarios aún.
                        </div>
                    @endforelse

                    @auth
                        <div class="mt-4">
                            <h3>Agregar Comentario</h3>
                            <!-- Condición para deshabilitar el formulario si los comentarios no están habilitados -->
                            @if ($documento->comentarios_habilitados || auth()->user()->hasRole('admin'))
                                <form id="comentario-form" action="{{ route('comentarios.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="documento_id" value="{{ $documento->id }}">
                                    <div class="mb-3">
                                        <textarea name="contenido" class="form-control" rows="3" required placeholder="Escribe tu comentario aquí..."
                                            {{ $documento->comentarios_habilitados || auth()->user()->hasRole('admin') ? '' : 'disabled' }}></textarea>
                                        @error('contenido')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-light"
                                        style="background-color: #003764 ; color: white;"
                                        {{ $documento->comentarios_habilitados || auth()->user()->hasRole('admin') ? '' : 'disabled' }}>
                                        <i class="fas fa-paper-plane"></i> Enviar Comentario
                                    </button>
                                </form>
                            @else
                                <!-- Mensaje para usuarios cuando los comentarios están deshabilitados -->
                                <div class="alert alert-warning">
                                    Los comentarios han sido desactivados para este documento.
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">
                            <a href="{{ route('login') }}" class="alert-link">Inicia sesión</a> para poder comentar.
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div id="confirmacionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmacionModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmacionModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este comentario? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="eliminarBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- CDN de jQuery (necesario para que $ funcione) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const comentariosSwitch = $('#comentarios-switch');
            const guardarBtn = $('#guardar-btn');
            const documentoId = '{{ $documento->id }}';
            const csrfToken = '{{ csrf_token() }}';
            let comentarioAEliminarId = null;

            // Al hacer clic en el botón de eliminar, guardamos el ID del comentario en una variable
            $('body').on('click', '.btn-eliminar-comentario', function() {
                comentarioAEliminarId = $(this).data('id');
            });

            // Al hacer clic en el botón "Eliminar" dentro del modal, ejecutamos la acción
            $('#eliminarBtn').on('click', function() {
                if (comentarioAEliminarId) {
                    $.ajax({
                        url: `/comentarios/${comentarioAEliminarId}`,
                        type: 'POST',
                        data: {
                            _token: csrfToken,
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                $(`#comentario-${comentarioAEliminarId}`).fadeOut(400, function() {
                                    $(this).remove();
                                });
                            } else {
                                console.error('Error al eliminar el comentario.');
                            }
                            // Ocultar el modal después de la operación
                            $('#confirmacionModal').modal('hide');
                        },
                        error: function(xhr) {
                            if (xhr.status === 403) {
                                console.error('No tienes permiso para realizar esta acción.');
                            } else {
                                console.error('Error AJAX:', xhr.responseText);
                            }
                            // Ocultar el modal después de la operación
                            $('#confirmacionModal').modal('hide');
                        }
                    });
                }
            });

            // Manejar el clic en el botón de guardar (habilitar/deshabilitar comentarios)
            guardarBtn.on('click', function() {
                const isChecked = comentariosSwitch.is(':checked');
                $.ajax({
                    url: `/documentos/${documentoId}/toggle-comentarios`,
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        comentarios_habilitados: isChecked
                    },
                    success: function(response) {
                        console.log('Respuesta del servidor:', response);
                        if (response.success) {
                            location.reload();
                        } else {
                            console.error('Error al guardar los cambios.');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 403) {
                            console.error('No tienes permiso para realizar esta acción.');
                        } else {
                            console.error('Error AJAX:', xhr.responseText);
                        }
                    }
                });
            });
        });
    </script>
@endpush
