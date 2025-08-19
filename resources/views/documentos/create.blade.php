@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header" style="background-color: #003764; color: white">
            <h3 class="mb-0">Crear Nuevo Documento</h3>
        </div>

        <!--Alerta de mensajes creados
            
            <div class="card-body">
             Alertas y mensajes
            <div id="alert-container">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            -->

            <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título del Documento <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo de Categoría y botón para crear nueva -->
                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center">
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="categoriaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Selecciona una categoría
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categoriaDropdown" id="categoria-list">
                                @foreach ($categorias as $categoria)
                                    <li><a class="dropdown-item" href="#" data-id="{{ $categoria->id }}">{{ $categoria->nombre }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn btn-outline-secondary ms-2" data-bs-toggle="modal" data-bs-target="#createCategoryModal" title="Crear nueva categoría">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- Campo oculto para enviar el ID de la categoría -->
                    <input type="hidden" name="categoria_id" id="categoria_id" required>
                </div>

                <div class="mb-3">
                    <label for="link" class="form-label">Link para los usuarios</label>
                    <input type="url" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link') }}">
                    <div class="form-text">Ejemplo: https://drive.google.com/...</div>
                    @error('link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="archivo" class="form-label">Archivo</label>
                    <input type="file" class="form-control @error('archivo') is-invalid @enderror" id="archivo" name="archivo" accept=".pdf,.doc,.docx,.pptx">
                    <div class="form-text">Formatos aceptados: PDF, Word (DOC/DOCX), PowerPoint (PPT/PPTX)</div>
                    @error('archivo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                    <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="">Seleccione un estado</option>
                        <option value="borrador" {{ old('estado') == 'borrador' ? 'selected' : '' }}>Borrador</option>
                        <option value="publicado" {{ old('estado') == 'publicado' ? 'selected' : '' }}>Publicado</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('documentos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-ligth" style="background-color: #003764; color: white !important;">
                        <i class="fas fa-save"></i> Guardar Documento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para crear nueva categoría -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Crear Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createCategoryForm" action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="modal-alert-container"></div>
                    <div class="mb-3">
                        <label for="nombre_categoria" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #003764; color: white;">Crear Categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('createCategoryModal'));
        const form = document.getElementById('createCategoryForm');
        const categoriaList = document.getElementById('categoria-list');
        const categoriaDropdown = document.getElementById('categoriaDropdown');
        const categoriaIdInput = document.getElementById('categoria_id');
        const modalAlertContainer = document.getElementById('modal-alert-container');
        const mainAlertContainer = document.getElementById('alert-container');

        // Manejar la selección de categoría desde el dropdown
        categoriaList.addEventListener('click', function(event) {
            if (event.target.classList.contains('dropdown-item')) {
                event.preventDefault();
                const selectedId = event.target.dataset.id;
                const selectedText = event.target.textContent;

                categoriaIdInput.value = selectedId;
                categoriaDropdown.textContent = selectedText;
                
                // Cierra el dropdown después de seleccionar
                const dropdown = bootstrap.Dropdown.getInstance(categoriaDropdown);
                if (dropdown) {
                    dropdown.hide();
                }
            }
        });

        // Manejar el envío del formulario del modal
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            modalAlertContainer.innerHTML = '';
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw errorData;
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Crea y agrega el nuevo elemento al dropdown
                    const newListItem = document.createElement('li');
                    const newLink = document.createElement('a');
                    newLink.classList.add('dropdown-item');
                    newLink.href = '#';
                    newLink.dataset.id = data.categoria.id;
                    newLink.textContent = data.categoria.nombre;
                    newListItem.appendChild(newLink);
                    categoriaList.appendChild(newListItem);

                    // Selecciona la nueva categoría automáticamente
                    categoriaIdInput.value = data.categoria.id;
                    categoriaDropdown.textContent = data.categoria.nombre;

                    modal.hide();
                    
                    // Mostrar alerta de éxito en la página principal
                    mainAlertContainer.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    form.reset(); // Limpia el formulario del modal
                }
            })
            .catch(error => {
                let errorMessage = 'Ocurrió un error. Por favor, inténtalo de nuevo.';
                if (error.errors && error.errors.nombre_categoria) {
                    errorMessage = error.errors.nombre_categoria[0];
                }
                modalAlertContainer.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        ${errorMessage}
                    </div>
                `;
            });
        });
    });
</script>
@endsection
