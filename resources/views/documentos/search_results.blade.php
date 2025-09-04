@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Resultados de búsqueda para: "{{ $query }}"</h1>
    <a href="{{ route('documentos.index') }}" class="btn btn-primary  mb-4" >Volver al inicio</a>

    @if($documentos->isEmpty())
        <div class="alert alert-warning" role="alert">
            No se encontraron documentos que coincidan con su búsqueda.
        </div>
    @else
        <div class="row">
            @foreach($documentos as $documento)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $documento->titulo }}</h5>
                            <p class="card-text text-muted">
                                Categoría: {{ $documento->categoria->nombre }}
                            </p>
                            @if($documento->descripcion)
                                <p class="card-text">{{ Str::limit($documento->descripcion, 100) }}</p>
                            @endif
                            <a href="{{ route('documentos.show', $documento) }}" class="btn btn-outline-primary">Ver Documento</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection