@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Encabezado con condicional para botón de creación y categoría -->
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded"
            style="background-color: #003764; color: white;">
            <h3>
                @can('create', App\Models\Documento::class)
                    Junta Directiva
                @else
                    Junta Directiva
                @endcan
            </h3>
            @can('create', App\Models\Documento::class)
                <div class="d-flex gap-2">
                    <a href="{{ route('documentos.create') }}" class="btn btn-light" style="color: #003764;">
                        <i class="fas fa-plus"></i> Nuevo Documento
                    </a>
                    <a href="#" class="btn btn-light" style="color: #003764;" data-bs-toggle="modal"
                        data-bs-target="#createCategoryModal" data-parent-id="">
                        <i class="fas fa-folder-plus"></i> Nueva Carpeta
                    </a>
                </div>
            @endcan
        </div>

        <!-- Modal para crear una nueva categoría -->
        @include('documentos.create-category-modal')
            

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
                <!-- Se incluye la vista parcial recursiva para mostrar las categorías -->
                @include('documentos._category-tree', ['categorias' => $categorias])
            </div>
        @endif
    </div> 
@endsection 


