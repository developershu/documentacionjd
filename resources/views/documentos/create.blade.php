



@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header" style="background-color: #003764; color: white;">
            <h3 class="mb-0">Crear Nuevo Documento</h3>
        </div>

        <div class="card-body bg-light">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                </div>

                <!-- Campo de Carpeta (Menú desplegable) -->
                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Carpeta <span class="text-danger">*</span></label>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="categoriaDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Selecciona una Carpeta
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="categoriaDropdown" id="categoria-list">
                            @foreach ($categorias as $categoria)
                                <li><a class="dropdown-item" href="#" data-id="{{ $categoria->id }}">{{ $categoria->nombre }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Campo de entrada oculto para el ID de la categoría -->
                    <input type="hidden" name="categoria_id" id="categoria_id" value="">
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
                    <input class="form-control" type="file" id="archivo" name="archivo">
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="publicado" {{ old('estado') == 'publicado' ? 'selected' : '' }}>Publicado</option>
                        <option value="borrador" {{ old('estado') == 'borrador' ? 'selected' : '' }}>Borrador</option>
                    </select>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('documentos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-primary" style="background-color: #003764; color: white !important;">
                        <i class="fas fa-save"></i> Guardar Documento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script de documentos/create.blade.php cargado correctamente.');

    const categoriaDropdown = document.getElementById('categoriaDropdown');
    const categoriaList = document.getElementById('categoria-list');
    const categoriaIdInput = document.getElementById('categoria_id');

    // Manejar la selección de categorías del menú desplegable
    categoriaList.addEventListener('click', function(event) {
        // Comprueba si el elemento clicado es un enlace de menú desplegable
        if (event.target.classList.contains('dropdown-item')) {
            event.preventDefault(); // Evita el comportamiento predeterminado del enlace
            const selectedItem = event.target;
            const selectedName = selectedItem.textContent;
            const selectedId = selectedItem.dataset.id;

            // Actualiza el texto del botón con el nombre de la categoría seleccionada
            categoriaDropdown.textContent = selectedName;

            // Actualiza el valor del campo de entrada oculto con el ID de la categoría
            categoriaIdInput.value = selectedId;

            console.log(`Categoría seleccionada: ID=${selectedId}, Nombre="${selectedName}"`);
        }
    });
});
</script>
@endpush

