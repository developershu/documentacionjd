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
                        <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    </div>

                    <!-- Campo de Carpeta (Menú desplegable) -->
                    <div class="mb-3">
                        <label for="categoriaDropdown" class="form-label">Carpeta</label>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="categoriaDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Selecciona una carpeta
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categoriaDropdown" id="categoria-list">

                                @foreach ($categorias->whereNull('parent_id') as $categoria)
                                    @include('documentos._category-dropdown-item', [
                                        'categorias' => $categorias,
                                    ])
                                @endforeach
                            </ul>
                        </div>
                        <!-- Campo oculto para el ID de la categoría -->
                        <input type="hidden" id="categoria_id" name="categoria_id" required>
                    </div>


                    <div class="mb-3">
                        <label for="link" class="form-label">Link para los usuarios</label>
                        <input type="url" class="form-control @error('link') is-invalid @enderror" id="link"
                            name="link" value="{{ old('link') }}">
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
                            <option value="publicado" {{ old('estado') == 'publicado' ? 'selected' : '' }}>Publicado
                            </option>
                            <option value="borrador" {{ old('estado') == 'borrador' ? 'selected' : '' }}>Borrador</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('documentos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-primary"
                            style="background-color: #003764; color: white !important;">
                            <i class="fas fa-save"></i> Guardar Documento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* Estilos personalizados para el menú desplegable de categorías */
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            display: none;
            position: absolute;
            top: 0;
            left: 100%;
            margin-left: 0.1rem;
            background-color: #ffffff;
            border-left: 2px solid #003764;
        }

        .dropdown-submenu .dropdown-menu.show {
            display: block;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Script de documentos/create.blade.php cargado correctamente.');

            // Obtenemos las referencias a los elementos del DOM
            const categoriaDropdown = document.getElementById('categoriaDropdown');
            const categoriaList = document.getElementById('categoria-list');
            const categoriaIdInput = document.getElementById('categoria_id');

            // Verificamos que los elementos existan antes de agregar los listeners
            if (categoriaList && categoriaDropdown && categoriaIdInput) {
                // Manejar la selección de una categoría (elemento de hoja)
                categoriaList.addEventListener('click', function(event) {
                    // Usamos .closest para encontrar el <a> tag, incluso si se hace clic en un <i> o <span> dentro de él.
                    const selectedItem = event.target.closest('.dropdown-item');

                    if (selectedItem && selectedItem.dataset.id) {
                        event.preventDefault(); // Evitamos que el enlace navegue a otra página
                        const selectedName = selectedItem.textContent.trim();
                        const selectedId = selectedItem.dataset.id;

                        // Actualizamos el texto del botón del menú principal y el valor del input oculto
                        categoriaDropdown.textContent = selectedName;
                        categoriaIdInput.value = selectedId;

                        console.log(`Categoría seleccionada: ID=${selectedId}, Nombre="${selectedName}"`);
                    }
                });

                // Manejar la apertura y cierre de submenús anidados
                categoriaList.addEventListener('click', function(event) {
                    const toggle = event.target.closest('.dropdown-submenu .dropdown-toggle');

                    if (toggle) {
                        event.preventDefault();
                        event.stopPropagation();

                        // Obtenemos el submenú asociado a este toggle
                        const submenu = toggle.nextElementSibling;
                        if (!submenu || !submenu.classList.contains('dropdown-menu')) {
                            return;
                        }

                        // Cerramos todos los otros submenús abiertos en el mismo nivel
                        const parentMenu = toggle.closest('.dropdown-menu');
                        if (parentMenu) {
                            parentMenu.querySelectorAll('.dropdown-menu.show').forEach(function(openSub) {
                                if (openSub !== submenu) {
                                    openSub.classList.remove('show');
                                }
                            });
                        }

                        // Alternamos el estado 'show' del submenú actual
                        submenu.classList.toggle('show');
                    }
                });
            }
        });
    </script>
@endpush
